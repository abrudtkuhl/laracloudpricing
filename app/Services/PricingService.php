<?php

namespace App\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;

class PricingService
{
    protected $config;
    protected $region = 'us-ohio'; // Default region

    public function __construct()
    {
        $this->config = Config::get('laracloud');
        // TODO: Allow region selection if needed in the future
    }

    // --- Cost Calculation Methods ---

    public function calculateBasePlanCost(string $plan): float
    {
        return $this->config['plans'][$plan]['price_monthly'] ?? 0;
    }

    /**
     * Calculates compute cost based on monthly price.
     */
    public function calculateMonthlyComputeCost(string $sizeKey, int $instances): float
    {
        $priceInfo = Arr::get($this->config, "compute.{$this->region}.{$sizeKey}");
        if (!$priceInfo) return 0;

        // Note: Plan-based restrictions (e.g., Sandbox flex-only) should be handled
        // by the caller (e.g., the Livewire component) before calling this.
        return round($priceInfo['price_monthly'] * $instances, 2);
    }

    /**
     * Calculates compute cost based on hourly usage (hibernation scenario).
     */
    public function calculateHourlyComputeCost(string $sizeKey, int $activeHours): float
    {
        $priceInfo = Arr::get($this->config, "compute.{$this->region}.{$sizeKey}");
        // Ensure hourly price exists for the calculation
        if (!$priceInfo || !isset($priceInfo['price_hourly'])) return 0;

        return round($priceInfo['price_hourly'] * $activeHours, 2);
    }

    /**
     * Calculates compute cost based on hourly usage across different scales.
     * $hoursAtScale = [ scale => hours, ... ] e.g., [ 1 => 360, 2 => 200, ... ]
     */
    public function calculateAutoscalingComputeCost(string $sizeKey, array $hoursAtScale): float
    {
        $priceInfo = Arr::get($this->config, "compute.{$this->region}.{$sizeKey}");
        // Ensure hourly price exists for the calculation
        if (!$priceInfo || !isset($priceInfo['price_hourly'])) return 0;

        $totalComputeHours = 0;
        foreach ($hoursAtScale as $scale => $hours) {
            $totalComputeHours += (int)$scale * (int)$hours;
        }

        return round($totalComputeHours * $priceInfo['price_hourly'], 2);
    }

    public function calculateDatabaseCost(string $dbType, ?string $mysqlSizeKey, ?float $postgresCpuUnits, int $storageGB): float
    {
        if ($dbType === 'none') {
            return 0;
        }

        $regionPrices = Arr::get($this->config, "database.{$this->region}");
        if (!$regionPrices) return 0;

        if ($dbType === 'mysql') {
            if (!$mysqlSizeKey) return 0; // Need a size key for MySQL
            $sizeInfo = Arr::get($regionPrices, "mysql.sizes.{$mysqlSizeKey}");
            if (!$sizeInfo) return 0;

            $computeCost = $sizeInfo['price_monthly'];
            $storageCost = $storageGB * Arr::get($regionPrices, 'mysql.storage_price_gb_month', 0);
            return round($computeCost + $storageCost, 2);

        } elseif ($dbType === 'postgres') {
            $pgConfig = Arr::get($regionPrices, 'postgres');
            if (!$pgConfig || $postgresCpuUnits === null) return 0;

            $cpuUnits = max($pgConfig['min_cpu'], $postgresCpuUnits);
            $hoursPerMonth = $this->config['hours_per_month'] ?? 730;
            $computeCost = $cpuUnits * $pgConfig['cpu_price_per_hour'] * $hoursPerMonth;
            $storageCost = $storageGB * $pgConfig['storage_price_gb_month'];
            return round($computeCost + $storageCost, 2);
        }

        return 0;
    }

    public function calculateKvCost(string $tier): float
    {
        return Arr::get($this->config, "kv.{$tier}.price_monthly", 0);
    }

    public function calculateObjectStorageCost(int $storageGB, float $classAOpsThousands, float $classBOpsThousands): float
    {
        $prices = $this->config['object_storage'] ?? null;
        if (!$prices) return 0;

        $storageCost = $storageGB * $prices['storage_price_gb_month'];
        $classACost = $classAOpsThousands * $prices['class_a_price_per_thousand'];
        $classBCost = $classBOpsThousands * $prices['class_b_price_per_thousand'];

        return round($storageCost + $classACost + $classBCost, 2);
    }

    public function calculateDataTransferCost(string $plan, int $totalGB): float
    {
        $allowanceConfig = Arr::get($this->config, 'usage_allowances.data_transfer');
        if (!$allowanceConfig) return 0;

        $freeAllowance = $allowanceConfig[$plan] ?? 0;
        $chargeableGB = max(0, $totalGB - $freeAllowance);
        return round($chargeableGB * $allowanceConfig['price_per_gb'], 2);
    }

    public function calculateRequestsCost(string $plan, int $totalMillions): float
    {
         $allowanceConfig = Arr::get($this->config, 'usage_allowances.requests');
         if (!$allowanceConfig) return 0;

        $freeAllowance = $allowanceConfig[$plan] ?? 0;
        $chargeableMillions = max(0, $totalMillions - $freeAllowance);
        return round($chargeableMillions * $allowanceConfig['price_per_million'], 2);
    }

    public function calculateCustomDomainsCost(string $plan, int $count): float
    {
        // Document does not specify a cost for additional domains
        // Allowance check could happen here or in the caller if needed.
        return 0;
    }

    public function calculateUsersCost(string $plan, int $additionalUsers): float
    {
        if ($plan === 'sandbox') return 0; // No additional users allowed/priced on sandbox

        $allowanceConfig = Arr::get($this->config, 'usage_allowances.users');
        if (!$allowanceConfig) return 0;

        // Cost is based on *additional* users specified
        $chargeableUsers = max(0, $additionalUsers);
        return round($chargeableUsers * $allowanceConfig['additional_user_price'], 2);
    }

    // --- Helper / Info Methods ---

    public function getComputePriceInfo(string $sizeKey): ?array
    {
        return Arr::get($this->config, "compute.{$this->region}.{$sizeKey}");
    }

    public function getAvailableComputeSizes(string $plan): array
    {
         $sizes = Arr::get($this->config, "compute.{$this->region}", []);
         // Filter based on plan (e.g., Sandbox only Flex)
         if ($plan === 'sandbox') {
             return array_filter($sizes, fn($key) => str_starts_with($key, 'flex-'), ARRAY_FILTER_USE_KEY);
         }
         return $sizes;
    }

     public function getAvailableMySqlSizes(): array
     {
         return Arr::get($this->config, "database.{$this->region}.mysql.sizes", []);
     }

     public function getAvailableKvTiers(): array
     {
         return $this->config['kv'] ?? [];
     }

     public function getAvailablePlans(): array
     {
        return $this->config['plans'] ?? [];
     }

     public function getPlanAllowance(string $type, string $plan): int
     {
        return Arr::get($this->config, "usage_allowances.{$type}.{$plan}", 0);
     }

     public function getPostgresMinCpu(): float
     {
        return Arr::get($this->config, "database.{$this->region}.postgres.min_cpu", 0.25);
     }

     public function getMySqlDefaultSizeKey(): ?string
     {
        $sizes = $this->getAvailableMySqlSizes();
        return !empty($sizes) ? array_key_first($sizes) : null;
     }

     public function getKvDefaultTierKey(): ?string
     {
        $tiers = $this->getAvailableKvTiers();
        return !empty($tiers) ? array_key_first($tiers) : null;
     }

     public function getComputeDefaultSizeKey(): ?string
     {
        $sizes = Arr::get($this->config, "compute.{$this->region}", []);
        return !empty($sizes) ? array_key_first($sizes) : null;
     }

     // --- Added Methods ---
     public function getPostgresCpuPricePerHour(): ?float
     {
        return Arr::get($this->config, "database.{$this->region}.postgres.cpu_price_per_hour");
     }

     public function getMySqlStoragePricePerGb(): ?float
     {
        return Arr::get($this->config, "database.{$this->region}.mysql.storage_price_gb_month");
     }

     public function getPostgresStoragePricePerGb(): ?float
     {
        return Arr::get($this->config, "database.{$this->region}.postgres.storage_price_gb_month");
     }

    // --- Added Usage Price/Allowance Getters ---
    public function getDataTransferPricePerGb(): ?float
    {
        return Arr::get($this->config, 'usage_allowances.data_transfer.price_per_gb');
    }

    public function getRequestsPricePerMillion(): ?float
    {
        return Arr::get($this->config, 'usage_allowances.requests.price_per_million');
    }

    public function getAdditionalUserPrice(): ?float
    {
        return Arr::get($this->config, 'usage_allowances.users.additional_user_price');
    }

    // getPlanAllowance already exists for free allowances
    // --- End Added Methods ---

    // --- Added Label Getters ---
    public function getComputeLabel(string $sizeKey): string
    {
       return Arr::get($this->config, "compute.{$this->region}.{$sizeKey}.label", $sizeKey); // Fallback to key
    }

    public function getMySqlLabel(string $sizeKey): string
    {
        return Arr::get($this->config, "database.{$this->region}.mysql.sizes.{$sizeKey}.label", $sizeKey);
    }

    public function getKvLabel(string $tierKey): string
    {
       return Arr::get($this->config, "kv.{$tierKey}.label", $tierKey); // Fallback to key
    }
    // --- End Added Methods ---
} 