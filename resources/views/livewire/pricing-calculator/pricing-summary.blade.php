<!-- Pricing Summary -->
<div class="max-w-7xl mx-auto my-16">
    <div class="bg-zinc-50 dark:bg-neutral-800 p-8 rounded-xl shadow-xl border border-zinc-200 dark:border-neutral-700">
        <h2 class="text-3xl font-bold text-black dark:text-white mb-8">Estimated Monthly Cost</h2>
        
        <div class="space-y-6">
            <!-- Base Plan Cost -->
            <div class="flex justify-between items-start p-4 rounded-lg bg-white dark:bg-neutral-900">
                <div>
                    <h3 class="text-lg font-semibold text-black dark:text-white">{{ ucfirst($plan) }} Plan</h3>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">Base subscription</p>
                </div>
                <span class="text-lg font-semibold text-black dark:text-white">
                    ${{ number_format($this->basePlanCost(), 2) }}
                    @if($plan !== 'sandbox') 
                        <span class="text-sm font-normal text-zinc-500 dark:text-zinc-400">+ usage</span>
                    @endif
                </span>
            </div>
            
            <!-- Web Compute Cost -->
            <div class="flex justify-between items-start p-4 rounded-lg bg-white dark:bg-neutral-900">
                <div>
                    <h3 class="text-lg font-semibold text-black dark:text-white">Web Compute</h3>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">
                        {{ $this->pricingService->getComputeLabel($webComputeSize) }} × {{ $webInstances }} instance(s)
                    </p>
                </div>
                <span class="text-lg font-semibold text-black dark:text-white">${{ number_format($this->webComputeCost(), 2) }}</span>
            </div>
            
            <!-- Worker Compute Cost -->
            @if($includeWorkers)
            <div class="flex justify-between items-start p-4 rounded-lg bg-white dark:bg-neutral-900">
                <div>
                    <h3 class="text-lg font-semibold text-black dark:text-white">Workers</h3>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">
                        {{ $this->pricingService->getComputeLabel($workerComputeSize) }} × {{ $workerInstances }} instance(s)
                    </p>
                </div>
                <span class="text-lg font-semibold text-black dark:text-white">${{ number_format($this->workerComputeCost(), 2) }}</span>
            </div>
            @endif
            
            <!-- Database Cost -->
            @if($databaseType !== 'none')
            <div class="flex justify-between items-start p-4 rounded-lg bg-white dark:bg-neutral-900">
                <div>
                    <h3 class="text-lg font-semibold text-black dark:text-white">{{ ucfirst($databaseType) }} Database</h3>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">
                        @if($databaseType === 'mysql')
                            {{ $this->pricingService->getMySqlLabel($mysqlDatabaseSize) ?? 'Selected Size' }} 
                        @elseif($databaseType === 'postgres')
                            {{ $postgresComputeUnits }} vCPU Compute 
                        @endif
                        + {{ $databaseStorageGB }} GB Storage
                    </p>
                </div>
                <span class="text-lg font-semibold text-black dark:text-white">${{ number_format($this->databaseCost(), 2) }}</span>
            </div>
            @endif
            
            <!-- KV Store Cost -->
            @if($includeKv)
            <div class="flex justify-between items-start p-4 rounded-lg bg-white dark:bg-neutral-900">
                <div>
                    <h3 class="text-lg font-semibold text-black dark:text-white">Laravel KV</h3>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">
                        {{ $this->pricingService->getKvLabel($kvTier) }} Tier
                    </p>
                </div>
                <span class="text-lg font-semibold text-black dark:text-white">${{ number_format($this->kvCost(), 2) }}</span>
            </div>
            @endif
            
            <!-- Object Storage Cost -->
            @if($includeObjectStorage)
            <div class="flex justify-between items-start p-4 rounded-lg bg-white dark:bg-neutral-900">
                <div>
                    <h3 class="text-lg font-semibold text-black dark:text-white">Object Storage</h3>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">
                        {{ $objectStorageGB }} GB Storage + {{ $objectStorageClassAOpsThousands }}k Class A Ops + {{ $objectStorageClassBOpsThousands }}k Class B Ops
                    </p>
                </div>
                <span class="text-lg font-semibold text-black dark:text-white">${{ number_format($this->objectStorageCost(), 2) }}</span>
            </div>
            @endif
            
            <!-- Data Transfer Cost -->
            @if($this->dataTransferCost() > 0)
            <div class="flex justify-between items-start p-4 rounded-lg bg-white dark:bg-neutral-900">
                <div>
                    <h3 class="text-lg font-semibold text-black dark:text-white">Data Transfer</h3>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ $dataTransfer }} GB ({{ $this->pricingService->getPlanAllowance('data_transfer', $plan) }} GB included)</p>
                </div>
                <span class="text-lg font-semibold text-black dark:text-white">${{ number_format($this->dataTransferCost(), 2) }}</span>
            </div>
            @endif
            
            <!-- Requests Cost -->
            @if($this->requestsCost() > 0)
            <div class="flex justify-between items-start p-4 rounded-lg bg-white dark:bg-neutral-900">
                <div>
                    <h3 class="text-lg font-semibold text-black dark:text-white">Requests</h3>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ $requests }}M ({{ number_format($this->pricingService->getPlanAllowance('requests', $plan)) }}M included)</p>
                </div>
                <span class="text-lg font-semibold text-black dark:text-white">${{ number_format($this->requestsCost(), 2) }}</span>
            </div>
            @endif
            
            <!-- Custom Domains - only shown for plans that include them -->
            @if($plan != 'sandbox')
            <div class="flex justify-between items-start p-4 rounded-lg bg-white dark:bg-neutral-900">
                <div>
                    <h3 class="text-lg font-semibold text-black dark:text-white">Custom Domains</h3>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">
                        {{ $this->pricingService->getPlanAllowance('custom_domains', $plan) }} domains included with {{ ucfirst($plan) }} plan
                    </p>
                </div>
                <span class="text-lg font-semibold text-black dark:text-white">Included</span>
            </div>
            @endif
            
            <!-- Users Cost -->
            @if($this->usersCost() > 0)
            <div class="flex justify-between items-start p-4 rounded-lg bg-white dark:bg-neutral-900">
                <div>
                    <h3 class="text-lg font-semibold text-black dark:text-white">Additional Users</h3>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">
                        {{ $additionalUsers }} user(s) beyond plan allowance
                    </p>
                </div>
                <span class="text-lg font-semibold text-black dark:text-white">${{ number_format($this->usersCost(), 2) }}</span>
            </div>
            @endif
            
            <!-- Total Monthly Cost -->
            <div class="flex justify-end items-center mt-8 pt-8 border-t-2 border-zinc-200 dark:border-neutral-700">
                <span class="text-3xl font-bold text-red-500">${{ number_format($this->totalMonthlyCost(), 2) }}</span>
            </div>
        </div>
        
        <div class="mt-12">
            @if($plan === 'business')
                <div class="text-center text-sm text-zinc-600 dark:text-zinc-400 mb-2">Coming soon</div>
            @endif
            
            <a 
                href="{{ $plan === 'business' ? '#' : 'https://app.laravel.cloud/register?plan=' . $plan }}"
                @class([
                    'w-full block text-center py-5 px-6 text-white text-lg font-semibold transition-colors rounded-xl shadow-lg hover:shadow-xl',
                    'bg-red-500 hover:bg-red-600' => $plan !== 'business',
                    'bg-zinc-400 cursor-not-allowed' => $plan === 'business'
                ])
            >
                @if($plan === 'business')
                    Coming Soon
                @else
                    Get Started on Laravel Cloud
                @endif
            </a>
        </div>
    </div>
</div> 