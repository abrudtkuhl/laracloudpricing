<!-- Pricing Summary -->
<div class="max-w-7xl mx-auto my-16">
    <div class="bg-zinc-50 dark:bg-neutral-800 p-8 rounded-xl shadow-xl border border-zinc-200 dark:border-neutral-700">
        <h2 class="text-3xl font-bold text-black dark:text-white mb-8">Monthly Cost</h2>
        
        <div class="space-y-6">
            <!-- Base Plan Cost -->
            <div class="flex justify-between items-start p-4 rounded-lg bg-white dark:bg-neutral-900">
                <div>
                    <h3 class="text-lg font-semibold text-black dark:text-white">{{ ucfirst($plan) }} Plan</h3>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">Base subscription</p>
                </div>
                <span class="text-lg font-semibold text-black dark:text-white">${{ number_format($this->basePlanCost(), 2) }}</span>
            </div>
            
            <!-- Web Compute Cost -->
            <div class="flex justify-between items-start p-4 rounded-lg bg-white dark:bg-neutral-900">
                <div>
                    <h3 class="text-lg font-semibold text-black dark:text-white">Web Compute</h3>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ $webComputeSize }} CPU × {{ $webInstances }} instances</p>
                </div>
                <span class="text-lg font-semibold text-black dark:text-white">${{ number_format($this->webComputeCost(), 2) }}</span>
            </div>
            
            <!-- Worker Compute Cost -->
            @if($includeWorkers)
            <div class="flex justify-between items-start p-4 rounded-lg bg-white dark:bg-neutral-900">
                <div>
                    <h3 class="text-lg font-semibold text-black dark:text-white">Workers</h3>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ $workerComputeSize }} CPU × {{ $workerInstances }} instances</p>
                </div>
                <span class="text-lg font-semibold text-black dark:text-white">${{ number_format($this->workerComputeCost(), 2) }}</span>
            </div>
            @endif
            
            <!-- Database Cost -->
            @if($databaseType !== 'none')
            <div class="flex justify-between items-start p-4 rounded-lg bg-white dark:bg-neutral-900">
                <div>
                    <h3 class="text-lg font-semibold text-black dark:text-white">{{ ucfirst($databaseType) }} Database</h3>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ $databaseSize }} GB</p>
                </div>
                <span class="text-lg font-semibold text-black dark:text-white">${{ number_format($this->databaseCost(), 2) }}</span>
            </div>
            @endif
            
            <!-- KV Store Cost -->
            @if($includeKv)
            <div class="flex justify-between items-start p-4 rounded-lg bg-white dark:bg-neutral-900">
                <div>
                    <h3 class="text-lg font-semibold text-black dark:text-white">Laravel KV</h3>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ $kvStorage }} GB</p>
                </div>
                <span class="text-lg font-semibold text-black dark:text-white">${{ number_format($this->kvCost(), 2) }}</span>
            </div>
            @endif
            
            <!-- Object Storage Cost -->
            @if($includeObjectStorage)
            <div class="flex justify-between items-start p-4 rounded-lg bg-white dark:bg-neutral-900">
                <div>
                    <h3 class="text-lg font-semibold text-black dark:text-white">Object Storage</h3>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ $objectStorage }} GB</p>
                </div>
                <span class="text-lg font-semibold text-black dark:text-white">${{ number_format($this->objectStorageCost(), 2) }}</span>
            </div>
            @endif
            
            <!-- Data Transfer Cost -->
            @if($this->dataTransferCost() > 0)
            <div class="flex justify-between items-start p-4 rounded-lg bg-white dark:bg-neutral-900">
                <div>
                    <h3 class="text-lg font-semibold text-black dark:text-white">Data Transfer</h3>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ $dataTransfer }} GB ({{ $dataTransferFreeAllowance[$plan] }} GB included)</p>
                </div>
                <span class="text-lg font-semibold text-black dark:text-white">${{ number_format($this->dataTransferCost(), 2) }}</span>
            </div>
            @endif
            
            <!-- Requests Cost -->
            @if($this->requestsCost() > 0)
            <div class="flex justify-between items-start p-4 rounded-lg bg-white dark:bg-neutral-900">
                <div>
                    <h3 class="text-lg font-semibold text-black dark:text-white">Requests</h3>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ $requests }}M ({{ $requestsFreeAllowance[$plan] }}M included)</p>
                </div>
                <span class="text-lg font-semibold text-black dark:text-white">${{ number_format($this->requestsCost(), 2) }}</span>
            </div>
            @endif
            
            <!-- Custom Domains Cost -->
            @if($this->customDomainsCost() > 0)
            <div class="flex justify-between items-start p-4 rounded-lg bg-white dark:bg-neutral-900">
                <div>
                    <h3 class="text-lg font-semibold text-black dark:text-white">Custom Domains</h3>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ $customDomains }} domains ({{ $customDomainsFreeAllowance[$plan] }} included)</p>
                </div>
                <span class="text-lg font-semibold text-black dark:text-white">${{ number_format($this->customDomainsCost(), 2) }}</span>
            </div>
            @endif
            
            <!-- Total Monthly Cost -->
            <div class="flex justify-between items-center mt-8 pt-8 border-t-2 border-zinc-200 dark:border-neutral-700">
                <h3 class="text-2xl font-bold text-black dark:text-white">Total Monthly Cost</h3>
                <span class="text-3xl font-bold text-red-500">${{ number_format($this->totalMonthlyCost(), 2) }}</span>
            </div>
        </div>
        
        <div class="mt-12">
            <a href="https://laravel.cloud" class="w-full block text-center py-5 px-6 bg-red-500 hover:bg-red-600 text-white text-lg font-semibold transition-colors rounded-xl shadow-lg hover:shadow-xl">
                Get Started on Laravel Cloud
            </a>
        </div>
    </div>
</div> 