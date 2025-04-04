<?php

namespace App\Livewire;

use App\Services\PricingService;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\On;

class PricingCalculator extends Component
{
    protected PricingService $pricingService;

    // Configuration
    public string $plan = 'production'; // sandbox, production, business
    public string $region = 'us-ohio'; // For future expansion

    // App Compute
    public string $webComputeSize;
    public int $webInstances = 1;
    public bool $includeWorkers = false;
    public string $workerComputeSize;
    public int $workerInstances = 1;

    // Database
    public string $databaseType = 'mysql'; // none, mysql, postgres
    public ?string $mysqlDatabaseSize; // Can be null if not mysql
    public float $postgresComputeUnits;
    public int $databaseStorageGB = 10; // GB

    // Other Resources
    public bool $includeKv = false;
    public string $kvTier;
    public bool $includeObjectStorage = false;
    public int $objectStorageGB = 10; // GB
    public float $objectStorageClassAOpsThousands = 100; // Thousands of operations
    public float $objectStorageClassBOpsThousands = 1000; // Thousands of operations

    // Usage
    public int $dataTransfer = 100; // GB
    public int $requests = 10; // Millions
    public int $customDomains = 3;

    // Users
    public int $additionalUsers = 0;

    // --- Removed Pricing Data Arrays ---

    // --- Component Lifecycle & Updates ---

    public function boot(PricingService $pricingService)
    {
         $this->pricingService = $pricingService;
    }

    public function mount()
    {
        // Initialize properties using the service
        $this->webComputeSize = $this->pricingService->getComputeDefaultSizeKey();
        $this->workerComputeSize = $this->pricingService->getComputeDefaultSizeKey();
        $this->mysqlDatabaseSize = $this->pricingService->getMySqlDefaultSizeKey();
        $this->postgresComputeUnits = $this->pricingService->getPostgresMinCpu();
        $this->kvTier = $this->pricingService->getKvDefaultTierKey();

        $this->resetUsageToPlanDefaults();
    }

    public function updated($property)
    {
        // Use direct validation for simplicity on update
         $numericProps = [
            'webInstances', 'workerInstances', 'databaseStorageGB',
            'postgresComputeUnits', 'objectStorageGB', 'objectStorageClassAOpsThousands',
            'objectStorageClassBOpsThousands', 'dataTransfer', 'requests',
            'customDomains', 'additionalUsers'
        ];

        if (in_array($property, $numericProps)) {
            $validated = Validator::make(
                [$property => $this->$property],
                [$property => 'numeric|min:0']
            )->validate();

            // Coerce specific integers
             $intProps = ['webInstances', 'workerInstances', 'databaseStorageGB', 'objectStorageGB', 'dataTransfer', 'requests', 'customDomains', 'additionalUsers'];
             if (in_array($property, $intProps)) {
                 $this->$property = max(0, (int)$validated[$property]);
             }
             // Coerce specific floats/decimals
             $floatProps = ['postgresComputeUnits', 'objectStorageClassAOpsThousands', 'objectStorageClassBOpsThousands'];
             if (in_array($property, $floatProps)) {
                $this->$property = max(0, (float)$validated[$property]);
             }
        }

        // Reset dependent values when the plan changes
        if ($property === 'plan') {
            $this->resetUsageToPlanDefaults();
            $this->validateInputsForPlan(); // Keep potential plan specific validation logic
        }

        // Reset database size if type changes
        if ($property === 'databaseType') {
            if ($this->databaseType === 'mysql') {
                $this->mysqlDatabaseSize = $this->pricingService->getMySqlDefaultSizeKey() ?? 'mysql-flex-1c-1g'; // Provide a fallback
            } elseif ($this->databaseType === 'postgres') {
                 $this->postgresComputeUnits = $this->pricingService->getPostgresMinCpu();
            }
        }

         // Reset KV tier if toggled off or default missing
         if (($property === 'includeKv' && !$this->includeKv) || ($property === 'kvTier' && !$this->kvTier)) {
              $this->kvTier = $this->pricingService->getKvDefaultTierKey() ?? '1gb'; // Fallback
         }

         // Reset object storage if toggled off
         if ($property === 'includeObjectStorage' && !$this->includeObjectStorage) {
             $this->objectStorageGB = 10;
             $this->objectStorageClassAOpsThousands = 100;
             $this->objectStorageClassBOpsThousands = 1000;
         }

         // Reset workers if toggled off or default missing
         if (($property === 'includeWorkers' && !$this->includeWorkers) || ($property === 'workerComputeSize' && !$this->workerComputeSize)) {
             $this->workerComputeSize = $this->pricingService->getComputeDefaultSizeKey() ?? 'flex-1c-512m'; // Fallback
             $this->workerInstances = 1;
         }

         // Reset web compute if default missing
         if ($property === 'webComputeSize' && !$this->webComputeSize) {
            $this->webComputeSize = $this->pricingService->getComputeDefaultSizeKey() ?? 'flex-1c-1g'; // Fallback
         }
    }

    protected function resetUsageToPlanDefaults()
    {
        // Use service to get allowances
        $this->dataTransfer = $this->pricingService->getPlanAllowance('data_transfer', $this->plan);
        $this->requests = $this->pricingService->getPlanAllowance('requests', $this->plan);
        $this->customDomains = $this->pricingService->getPlanAllowance('custom_domains', $this->plan);
        $this->additionalUsers = 0; // Reset additional users

        // Sandbox limitations
        if ($this->plan === 'sandbox') {
            $this->customDomains = 0;
            $this->additionalUsers = 0; // Cannot add users

            // Ensure default compute sizes are Flex for Sandbox
            $defaultCompute = $this->pricingService->getComputeDefaultSizeKey() ?? 'flex-1c-1g'; // Fallback
            $defaultWorkerCompute = $this->pricingService->getComputeDefaultSizeKey() ?? 'flex-1c-512m'; // Fallback

            // Force Flex compute if Sandbox (assuming Pro/Dedicated not allowed)
             if (!$this->webComputeSize || str_starts_with($this->webComputeSize, 'pro-')) {
                 $this->webComputeSize = $defaultCompute;
             }
             if ($this->includeWorkers && (!$this->workerComputeSize || str_starts_with($this->workerComputeSize, 'pro-'))) {
                 $this->workerComputeSize = $defaultWorkerCompute;
             }
        }
    }

    protected function validateInputsForPlan()
    {
         // Check if current web compute size is valid for the selected plan
         $availableWebSizes = $this->pricingService->getAvailableComputeSizes($this->plan);
         if (!array_key_exists($this->webComputeSize, $availableWebSizes)) {
             // Reset to a default valid size for the plan
             $this->webComputeSize = !empty($availableWebSizes) ? array_key_first($availableWebSizes) : ($this->pricingService->getComputeDefaultSizeKey() ?? 'flex-1c-1g');
             $this->addError('webComputeSize', 'Selected compute size is not available for this plan. Resetting.');
         }

        // Check worker compute size validity
        if ($this->includeWorkers) {
            $availableWorkerSizes = $this->pricingService->getAvailableComputeSizes($this->plan);
             if (!array_key_exists($this->workerComputeSize, $availableWorkerSizes)) {
                $this->workerComputeSize = !empty($availableWorkerSizes) ? array_key_first($availableWorkerSizes) : ($this->pricingService->getComputeDefaultSizeKey() ?? 'flex-1c-512m');
                $this->addError('workerComputeSize', 'Selected worker size is not available for this plan. Resetting.');
            }
        }
         // Add more plan-specific validations if required
    }


    // --- Computed Properties for Costs ---

    #[Computed]
    public function basePlanCost()
    {
        // Delegate to service
        return $this->pricingService->calculateBasePlanCost($this->plan);
    }

    #[Computed]
    public function webComputeCost()
    {
        // Delegate to service
        // Handle potential null from default key setting
        if (!$this->webComputeSize) return 0;
        return $this->pricingService->calculateMonthlyComputeCost($this->webComputeSize, $this->webInstances);
    }

    #[Computed]
    public function workerComputeCost()
    {
        if (!$this->includeWorkers || !$this->workerComputeSize) return 0;
        // Delegate to service
        return $this->pricingService->calculateMonthlyComputeCost($this->workerComputeSize, $this->workerInstances);
    }

    #[Computed]
    public function databaseCost()
    {
        // Delegate to service
        return $this->pricingService->calculateDatabaseCost(
            $this->databaseType,
            $this->mysqlDatabaseSize,
            $this->postgresComputeUnits,
            $this->databaseStorageGB
        );
    }

    #[Computed]
    public function kvCost()
    {
        if (!$this->includeKv || !$this->kvTier) return 0;
        // Delegate to service
        return $this->pricingService->calculateKvCost($this->kvTier);
    }

    #[Computed]
    public function objectStorageCost()
    {
        if (!$this->includeObjectStorage) return 0;
        // Delegate to service
        return $this->pricingService->calculateObjectStorageCost(
            $this->objectStorageGB,
            $this->objectStorageClassAOpsThousands,
            $this->objectStorageClassBOpsThousands
        );
    }

    #[Computed]
    public function dataTransferCost()
    {
        // Delegate to service
        return $this->pricingService->calculateDataTransferCost($this->plan, $this->dataTransfer);
    }

    #[Computed]
    public function requestsCost()
    {
        // Delegate to service
        return $this->pricingService->calculateRequestsCost($this->plan, $this->requests);
    }

    #[Computed]
    public function customDomainsCost()
    {
        // Delegate to service
        return $this->pricingService->calculateCustomDomainsCost($this->plan, $this->customDomains);
    }

    #[Computed]
    public function usersCost()
    {
         // Delegate to service
        return $this->pricingService->calculateUsersCost($this->plan, $this->additionalUsers);
    }


    #[Computed]
    public function totalMonthlyCost()
    {
        // Ensure all individual costs are accessed to be calculated
        $costs = [
            $this->basePlanCost(),
            $this->webComputeCost(),
            $this->workerComputeCost(),
            $this->databaseCost(),
            $this->kvCost(),
            $this->objectStorageCost(),
            $this->dataTransferCost(),
            $this->requestsCost(),
            $this->customDomainsCost(),
            $this->usersCost(),
        ];

        return round(array_sum($costs), 2);
    }

    // --- Helper Methods for View ---

    /**
     * @return array<string, array<string, mixed>>
     */
    public function getAvailableComputeSizes(): array
    {
         // Use service
         return $this->pricingService->getAvailableComputeSizes($this->plan);
    }

     /**
      * @return array<string, array<string, mixed>>
      */
     public function getAvailableMySqlSizes(): array
     {
         // Use service
         return $this->pricingService->getAvailableMySqlSizes();
     }

     /**
      * @return array<string, array<string, mixed>>
      */
     public function getAvailableKvTiers(): array
     {
         // Use service
         return $this->pricingService->getAvailableKvTiers();
     }

    #[Title('Laravel Cloud Pricing Calculator')]
    public function render()
    {
        // Revert to simpler render as partial now accesses computed property directly
        return view('livewire.pricing-calculator');
    }

    // --- Button Action Methods ---
    // These remain the same as they modify component state

    public function incrementDataTransfer()
    {
        // Example: Increment by 10GB, max 5TB
        $this->dataTransfer = min(5000, $this->dataTransfer + 10);
    }

    public function decrementDataTransfer()
    {
         // Example: Decrement by 10GB, min 0
        $this->dataTransfer = max(0, $this->dataTransfer - 10);
    }

    public function incrementRequests()
    {
         // Example: Increment by 1 Million, max 1 Billion
        $this->requests = min(1000, $this->requests + 1);
    }

    public function decrementRequests()
    {
         // Example: Decrement by 1 Million, min 0
        $this->requests = max(0, $this->requests - 1);
    }

    public function incrementCustomDomains()
    {
        // Only allow changes if not Sandbox
        if ($this->plan !== 'sandbox') {
            // Example: Increment by 1, max 50
            $this->customDomains = min(50, $this->customDomains + 1);
        }
    }

    public function decrementCustomDomains()
    {
         // Only allow changes if not Sandbox
         if ($this->plan !== 'sandbox') {
             // Example: Decrement by 1, min 0
            $this->customDomains = max(0, $this->customDomains - 1);
        }
    }

     public function incrementAdditionalUsers()
    {
        // Only allow changes if not Sandbox
        if ($this->plan !== 'sandbox') {
            // Example: Increment by 1, max 50
             $this->additionalUsers = min(50, $this->additionalUsers + 1);
        }
    }

    public function decrementAdditionalUsers()
    {
         // Only allow changes if not Sandbox
         if ($this->plan !== 'sandbox') {
             // Example: Decrement by 1, min 0
             $this->additionalUsers = max(0, $this->additionalUsers - 1);
        }
    }

    // --- Added Computed Property ---
    /**
     * @return array<string, array<string, mixed>>
     */
    #[Computed]
    public function availablePlans(): array
    {
        return $this->pricingService->getAvailablePlans();
    }
    // --- End Added Computed Property ---

    public function handleAiConfiguration($configuration)
    {
        // Set plan
        if (isset($configuration['plan'])) {
            $this->plan = $configuration['plan'];
        }
        
        // Set compute
        if (isset($configuration['compute'])) {
            $this->webComputeSize = $configuration['compute'];
        }
        
        // Set database
        if (isset($configuration['database']['type'])) {
            $this->databaseType = $configuration['database']['type'];
            
            if ($this->databaseType === 'mysql' && isset($configuration['database']['size'])) {
                $this->mysqlDatabaseSize = $configuration['database']['size'];
            } elseif ($this->databaseType === 'postgres') {
                // Set default postgres values since they're not specified in the AI response
                $this->postgresComputeUnits = $this->pricingService->getPostgresMinCpu();
            }
        }
        
        // Set KV store
        if (isset($configuration['kv'])) {
            $this->includeKv = true;
            $this->kvTier = $configuration['kv'];
        } else {
            $this->includeKv = false;
        }
        
        // Reset usage to plan defaults based on the new plan
        $this->resetUsageToPlanDefaults();
        
        // Validate inputs for the new plan
        $this->validateInputsForPlan();
    }

    #[On('applyAiConfiguration')]
    public function applyAiConfiguration($configuration)
    {
        $this->handleAiConfiguration($configuration);
    }
} 