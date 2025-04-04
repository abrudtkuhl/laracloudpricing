<?php

namespace App\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class PricingService
{
    protected $config;
    protected $region = 'us-ohio'; // Default region
    protected $apiKey;

    public function __construct()
    {
        $this->config = Config::get('laracloud');
        $this->apiKey = env('OPENAI_API_KEY');
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
        // Custom domains are included in plan allowances and not separately charged
        // This is a validation check only - no additional cost
        $allowanceConfig = Arr::get($this->config, 'usage_allowances.custom_domains');
        if (!$allowanceConfig) return 0;
        
        $planAllowance = $allowanceConfig[$plan] ?? 0;
        
        // If trying to use more domains than plan allows, this is a validation concern
        // But there's no additional cost per domain
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
    
    // --- AI Configuration Methods ---
    
    public function generatePricingConfiguration(string $userDescription)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-4-turbo',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are a pricing configuration assistant for Laravel Cloud. You help users determine the best package based on their needs. Make sure to consider plan-specific limitations, such as: Sandbox plan only supports Flex compute; custom domains are included in plan allowances (0 for Sandbox, 3 for Production, 10 for Business) and cannot be purchased separately.'
                ],
                [
                    'role' => 'user',
                    'content' => "Based on the following Laravel Cloud pricing configuration data:\n" . 
                        json_encode($this->config, JSON_PRETTY_PRINT) . 
                        "\n\nCreate a configuration recommending the best plan and resources for the following user requirement:\n" .
                        $userDescription
                ]
            ],
            'functions' => [
                [
                    'name' => 'generate_pricing_configuration',
                    'description' => 'Generate the optimal pricing configuration for Laravel Cloud based on user requirements',
                    'parameters' => [
                        'type' => 'object',
                        'properties' => [
                            'plan' => [
                                'type' => 'string',
                                'enum' => ['sandbox', 'production', 'business'],
                                'description' => 'The recommended plan based on user needs'
                            ],
                            'compute' => [
                                'type' => 'string',
                                'description' => 'The recommended compute option key from the configuration'
                            ],
                            'database' => [
                                'type' => 'object',
                                'properties' => [
                                    'type' => [
                                        'type' => 'string',
                                        'enum' => ['mysql', 'postgres', 'none'],
                                        'description' => 'Database type'
                                    ],
                                    'size' => [
                                        'type' => 'string',
                                        'description' => 'Database size key from configuration'
                                    ]
                                ]
                            ],
                            'kv' => [
                                'type' => 'string',
                                'description' => 'Recommended KV storage option key'
                            ],
                            'explanation' => [
                                'type' => 'string',
                                'description' => 'Brief explanation of why this configuration was chosen'
                            ]
                        ],
                        'required' => ['plan']
                    ]
                ]
            ],
            'function_call' => ['name' => 'generate_pricing_configuration'],
            'temperature' => 0.5,
        ]);
        
        $data = $response->json();
        
        if (!$response->successful()) {
            return ['error' => 'Failed to get response from AI', 'details' => $data];
        }
        
        $functionCall = $data['choices'][0]['message']['function_call'] ?? null;
        
        if (!$functionCall) {
            return ['error' => 'No function call in response'];
        }
        
        $configuration = json_decode($functionCall['arguments'], true);
        return $this->buildAiConfigurationResponse($configuration);
    }
    
    protected function buildAiConfigurationResponse(array $configuration)
    {
        $totalPrice = 0;
        $details = [];
        
        // Calculate plan price
        $planPrice = $this->calculateBasePlanCost($configuration['plan']);
        $totalPrice += $planPrice;
        $details['plan'] = [
            'name' => $configuration['plan'],
            'label' => Arr::get($this->config, "plans.{$configuration['plan']}.label", ucfirst($configuration['plan'])),
            'price' => $planPrice
        ];
        
        // Calculate compute price
        if (isset($configuration['compute'])) {
            $computePrice = $this->calculateMonthlyComputeCost($configuration['compute'], 1);
            $totalPrice += $computePrice;
            $details['compute'] = [
                'type' => $configuration['compute'],
                'label' => $this->getComputeLabel($configuration['compute']),
                'price' => $computePrice
            ];
        }
        
        // Calculate database price if needed
        if (isset($configuration['database']['type']) && $configuration['database']['type'] !== 'none') {
            $dbType = $configuration['database']['type'];
            $dbSize = $configuration['database']['size'] ?? null;
            
            if ($dbType === 'mysql' && $dbSize) {
                $storageGB = 10; // Default value
                $dbPrice = $this->calculateDatabaseCost($dbType, $dbSize, null, $storageGB);
                $totalPrice += $dbPrice;
                $details['database'] = [
                    'type' => $dbType,
                    'size' => $dbSize,
                    'label' => $this->getMySqlLabel($dbSize),
                    'storage_gb' => $storageGB,
                    'price' => $dbPrice
                ];
            } elseif ($dbType === 'postgres') {
                $cpuUnits = 1; // Default value
                $storageGB = 10; // Default value
                $dbPrice = $this->calculateDatabaseCost($dbType, null, $cpuUnits, $storageGB);
                $totalPrice += $dbPrice;
                $details['database'] = [
                    'type' => $dbType,
                    'cpu_units' => $cpuUnits,
                    'storage_gb' => $storageGB,
                    'price' => $dbPrice
                ];
            }
        }
        
        // Calculate KV store price if needed
        if (isset($configuration['kv'])) {
            $kvPrice = $this->calculateKvCost($configuration['kv']);
            $totalPrice += $kvPrice;
            $details['kv'] = [
                'size' => $configuration['kv'],
                'label' => $this->getKvLabel($configuration['kv']),
                'price' => $kvPrice
            ];
        }
        
        return [
            'configuration' => $configuration,
            'details' => $details,
            'total_monthly_price' => $totalPrice,
            'explanation' => $configuration['explanation'] ?? ''
        ];
    }
} 