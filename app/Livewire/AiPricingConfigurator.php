<?php

namespace App\Livewire;

use App\Services\PricingService;
use Livewire\Component;
use Livewire\Attributes\Title;

class AiPricingConfigurator extends Component
{
    protected PricingService $pricingService;
    
    public string $userDescription = '';
    public bool $isLoading = false;
    public array $aiConfiguration = [];
    public bool $hasError = false;
    public string $errorMessage = '';
    
    public function boot(PricingService $pricingService)
    {
        $this->pricingService = $pricingService;
    }
    
    public function generateConfiguration()
    {
        $this->validate([
            'userDescription' => 'required|string|min:5|max:500'
        ]);
        
        $this->isLoading = true;
        $this->aiConfiguration = [];
        $this->hasError = false;
        $this->errorMessage = '';
        
        try {
            $configuration = $this->pricingService->generatePricingConfiguration($this->userDescription);
            
            if (isset($configuration['error'])) {
                $this->hasError = true;
                $this->errorMessage = $configuration['error'];
            } else {
                $this->aiConfiguration = $configuration;
                
                // Automatically apply the configuration
                if (isset($configuration['configuration'])) {
                    $this->dispatch('applyAiConfiguration', configuration: $configuration['configuration']);
                }
            }
        } catch (\Exception $e) {
            $this->hasError = true;
            $this->errorMessage = 'An error occurred: ' . $e->getMessage();
        }
        
        $this->isLoading = false;
    }
    
    #[Title('Laravel Cloud AI Pricing Configurator')]
    public function render()
    {
        return view('livewire.ai-pricing-configurator');
    }
} 