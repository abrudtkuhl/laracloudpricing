<div class="max-w-7xl mx-auto dark:bg-neutral-900 rounded-lg overflow-hidden">
    <!-- Floating Summary -->
    <div 
        class="fixed top-4 right-4 z-50 w-80 bg-white dark:bg-neutral-800 rounded-lg shadow-xl border border-zinc-200 dark:border-neutral-700 overflow-hidden"
        x-data="{ show: false }"
        x-show="show"
        x-transition
        x-init="window.addEventListener('scroll', () => { show = window.scrollY > 100 })"
    >
        <div class="flex justify-between items-center p-3 bg-red-500 text-white">
            <h3 class="text-sm font-semibold">Monthly Estimate</h3>
            <button 
                @click="show = false" 
                class="text-white hover:text-red-100"
            >
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <div class="p-3">
            <div class="flex justify-between items-center mb-2">
                <span class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Total</span>
                <span class="text-lg font-bold text-red-500">${{ number_format($this->totalMonthlyCost(), 2) }}</span>
            </div>
            
            <div class="space-y-1 text-xs">
                <div class="flex justify-between">
                    <span class="text-zinc-600 dark:text-zinc-400">Base Plan</span>
                    <span class="font-medium text-zinc-800 dark:text-zinc-200">${{ number_format($this->basePlanCost(), 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-zinc-600 dark:text-zinc-400">Web Compute</span>
                    <span class="font-medium text-zinc-800 dark:text-zinc-200">${{ number_format($this->webComputeCost(), 2) }}</span>
                </div>
                @if($includeWorkers)
                <div class="flex justify-between">
                    <span class="text-zinc-600 dark:text-zinc-400">Workers</span>
                    <span class="font-medium text-zinc-800 dark:text-zinc-200">${{ number_format($this->workerComputeCost(), 2) }}</span>
                </div>
                @endif
                @if($databaseType !== 'none')
                <div class="flex justify-between">
                    <span class="text-zinc-600 dark:text-zinc-400">Database</span>
                    <span class="font-medium text-zinc-800 dark:text-zinc-200">${{ number_format($this->databaseCost(), 2) }}</span>
                </div>
                @endif
                @if($includeKv)
                <div class="flex justify-between">
                    <span class="text-zinc-600 dark:text-zinc-400">KV Store</span>
                    <span class="font-medium text-zinc-800 dark:text-zinc-200">${{ number_format($this->kvCost(), 2) }}</span>
                </div>
                @endif
                @if($includeObjectStorage)
                <div class="flex justify-between">
                    <span class="text-zinc-600 dark:text-zinc-400">Object Storage</span>
                    <span class="font-medium text-zinc-800 dark:text-zinc-200">${{ number_format($this->objectStorageCost(), 2) }}</span>
                </div>
                @endif
                @if($this->dataTransferCost() > 0)
                <div class="flex justify-between">
                    <span class="text-zinc-600 dark:text-zinc-400">Data Transfer</span>
                    <span class="font-medium text-zinc-800 dark:text-zinc-200">${{ number_format($this->dataTransferCost(), 2) }}</span>
                </div>
                @endif
                @if($this->requestsCost() > 0)
                <div class="flex justify-between">
                    <span class="text-zinc-600 dark:text-zinc-400">Requests</span>
                    <span class="font-medium text-zinc-800 dark:text-zinc-200">${{ number_format($this->requestsCost(), 2) }}</span>
                </div>
                @endif
                @if($this->customDomainsCost() > 0)
                <div class="flex justify-between">
                    <span class="text-zinc-600 dark:text-zinc-400">Custom Domains</span>
                    <span class="font-medium text-zinc-800 dark:text-zinc-200">${{ number_format($this->customDomainsCost(), 2) }}</span>
                </div>
                @endif
            </div>
            
            <div class="mt-3">
                <a href="https://laravel.cloud" class="block w-full py-2 px-3 text-center text-sm font-medium text-white bg-red-500 hover:bg-red-600 rounded">
                    Get Started
                </a>
            </div>
        </div>
    </div>
    
    <!-- Calculator Components -->
    <div class="divide-y divide-zinc-200 dark:divide-neutral-700 bg-white dark:bg-neutral-900">
        <!-- Plan Selection -->
        @include('livewire.pricing-calculator.plan-selection')
        
        <!-- App Configuration -->
        @include('livewire.pricing-calculator.app-configuration')
        
        <!-- Database Configuration -->
        @include('livewire.pricing-calculator.database-configuration')
        
        <!-- Usage -->
        @include('livewire.pricing-calculator.usage')
        
        <!-- Pricing Summary -->
        
    </div>

    @include('livewire.pricing-calculator.pricing-summary')
</div> 