<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;

class PricingCalculator extends Component
{
    // Plan selection
    public $plan = 'production';
    
    // Usage
    public $dataTransfer = 100;
    public $requests = 10;
    public $customDomains = 3;
    
    // Database configuration
    public $databaseType = 'mysql';
    public $databaseSize = 3;
    public $includeKv = false;
    public $kvStorage = 1;
    public $includeObjectStorage = false;
    public $objectStorage = 10;
    
    // App configuration
    public $webComputeSize = 1;
    public $webInstances = 2;
    public $includeWorkers = false;
    public $workerComputeSize = 0.5;
    public $workerInstances = 1;
    
    // Base prices
    public $planPrices = [
        'sandbox' => 0,
        'production' => 20,
        'business' => 200,
    ];
    
    // Compute prices
    public $webComputePrices = [
        '0.5' => 8,
        '1' => 15,
        '2' => 30,
    ];
    
    public $workerComputePrices = [
        '0.5' => 6,
        '1' => 12,
        '2' => 24,
    ];
    
    // Database prices
    public $databasePrices = [
        1 => 10,
        3 => 25,
        5 => 40,
        10 => 70,
    ];
    
    // KV storage prices (per GB)
    public $kvPrices = [
        1 => 5,
        2 => 10,
        3 => 15,
        4 => 20,
        5 => 25,
        6 => 30,
        7 => 35,
        8 => 40,
        9 => 45,
        10 => 50,
    ];
    
    // Object storage prices
    public $objectStoragePrices = [
        'storage' => 0.02,
        'classA' => 0.005,
        'classB' => 0.0005,
    ];
    
    // Usage pricing
    public $dataTransferFreeAllowance = [
        'sandbox' => 10,
        'production' => 100,
        'business' => 1000,
    ];
    
    public $dataTransferPrice = 0.10;
    
    public $requestsFreeAllowance = [
        'sandbox' => 1,
        'production' => 10,
        'business' => 100,
    ];
    
    public $requestsPrice = 1.00;
    
    public $customDomainsFreeAllowance = [
        'sandbox' => 0,
        'production' => 3,
        'business' => 10,
    ];
    
    public $customDomainsPrice = 0.50;
    
    public $databaseStoragePrice = 1.50;
    public $databaseAdditionalUserPrice = 10.00;
    
    public function mount()
    {
        $this->resetUsageValues();
    }
    
    public function updatedDataTransfer($value)
    {
        $this->dataTransfer = (int) $value;
    }
    
    public function updatedRequests($value)
    {
        $this->requests = (int) $value;
    }
    
    public function updatedCustomDomains($value)
    {
        $this->customDomains = (int) $value;
    }
    
    public function incrementDataTransfer()
    {
        $this->dataTransfer = min(500, $this->dataTransfer + 10);
    }
    
    public function decrementDataTransfer()
    {
        $this->dataTransfer = max(1, $this->dataTransfer - 10);
    }
    
    public function incrementRequests()
    {
        $this->requests = min(100, $this->requests + 1);
    }
    
    public function decrementRequests()
    {
        $this->requests = max(1, $this->requests - 1);
    }
    
    public function incrementCustomDomains()
    {
        if ($this->plan != 'sandbox') {
            $this->customDomains = min(50, $this->customDomains + 1);
        }
    }
    
    public function decrementCustomDomains()
    {
        if ($this->plan != 'sandbox') {
            $this->customDomains = max(0, $this->customDomains - 1);
        }
    }
    
    public function incrementWebInstances()
    {
        $this->webInstances = min(10, $this->webInstances + 1);
    }
    
    public function decrementWebInstances()
    {
        $this->webInstances = max(1, $this->webInstances - 1);
    }
    
    public function incrementWorkerInstances()
    {
        $this->workerInstances = min(10, $this->workerInstances + 1);
    }
    
    public function decrementWorkerInstances()
    {
        $this->workerInstances = max(1, $this->workerInstances - 1);
    }
    
    public function resetUsageValues()
    {
        if ($this->plan === 'sandbox') {
            $this->customDomains = 0;
        } else {
            $this->customDomains = $this->customDomainsFreeAllowance[$this->plan];
        }
    }
    
    public function updatedPlan()
    {
        $this->resetUsageValues();
    }
    
    public function updatedWebComputeSize()
    {
        if (!isset($this->webComputePrices[$this->webComputeSize])) {
            $this->webComputeSize = 1;
        }
    }
    
    public function updatedWorkerComputeSize()
    {
        if (!isset($this->workerComputePrices[$this->workerComputeSize])) {
            $this->workerComputeSize = 0.5;
        }
    }
    
    #[Computed]
    public function basePlanCost()
    {
        return $this->planPrices[$this->plan];
    }
    
    #[Computed]
    public function webComputeCost()
    {
        return $this->webComputePrices[$this->webComputeSize] * $this->webInstances;
    }
    
    #[Computed]
    public function workerComputeCost()
    {
        if (!$this->includeWorkers) {
            return 0;
        }
        
        return $this->workerComputePrices[$this->workerComputeSize] * $this->workerInstances;
    }
    
    #[Computed]
    public function databaseCost()
    {
        if ($this->databaseType === 'none') {
            return 0;
        }
        
        return $this->databasePrices[$this->databaseSize];
    }
    
    #[Computed]
    public function kvCost()
    {
        if (!$this->includeKv) {
            return 0;
        }
        
        return $this->kvPrices[$this->kvStorage];
    }
    
    #[Computed]
    public function objectStorageCost()
    {
        if (!$this->includeObjectStorage) {
            return 0;
        }
        
        return $this->objectStoragePrices['storage'] * $this->objectStorage;
    }
    
    #[Computed]
    public function dataTransferCost()
    {
        $freeAllowance = $this->dataTransferFreeAllowance[$this->plan];
        $extraGB = max(0, $this->dataTransfer - $freeAllowance);
        
        return round($extraGB * $this->dataTransferPrice, 2);
    }
    
    #[Computed]
    public function requestsCost()
    {
        $freeAllowance = $this->requestsFreeAllowance[$this->plan];
        $extraMillions = max(0, $this->requests - $freeAllowance);
        
        return round($extraMillions * $this->requestsPrice, 2);
    }
    
    #[Computed]
    public function customDomainsCost()
    {
        if ($this->plan === 'sandbox') {
            return 0;
        }
        
        $freeAllowance = $this->customDomainsFreeAllowance[$this->plan];
        $extraDomains = max(0, $this->customDomains - $freeAllowance);
        
        return $extraDomains * $this->customDomainsPrice;
    }
    
    #[Computed]
    public function totalMonthlyCost()
    {
        return round(
            $this->basePlanCost() +
            $this->webComputeCost() +
            $this->workerComputeCost() +
            $this->databaseCost() +
            $this->kvCost() +
            $this->objectStorageCost() +
            $this->dataTransferCost() +
            $this->requestsCost() +
            $this->customDomainsCost(),
            2
        );
    }
    
    #[Title('Laravel Cloud Pricing Calculator')]
    public function render()
    {
        return view('livewire.pricing-calculator');
    }
} 