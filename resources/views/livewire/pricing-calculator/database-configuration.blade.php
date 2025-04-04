<!-- Database Configuration -->
<div class="p-6 border-b border-zinc-200 dark:border-neutral-700">
    <h2 class="text-2xl font-semibold text-black dark:text-white mb-6">Database Configuration</h2>
    
    <!-- Database Type -->
    <div class="mb-6">
        <h3 class="text-lg font-medium text-black dark:text-white mb-4">Database</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="relative">
                <input type="radio" id="database-type-mysql" name="database-type" wire:model.live="databaseType" value="mysql" class="peer absolute h-0 w-0 opacity-0">
                <label for="database-type-mysql" class="flex flex-col p-4 border rounded cursor-pointer border-zinc-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 peer-checked:border-red-500 peer-checked:bg-red-50 dark:peer-checked:bg-red-900/10 hover:border-red-300 dark:hover:border-red-800 transition-colors">
                    <span class="font-medium text-black dark:text-white">MySQL</span>
                    <span class="text-sm text-zinc-500 dark:text-zinc-400">Traditional relational database</span>
                </label>
            </div>
            
            <div class="relative">
                <input type="radio" id="database-type-postgresql" name="database-type" wire:model.live="databaseType" value="postgres" class="peer absolute h-0 w-0 opacity-0">
                <label for="database-type-postgresql" class="flex flex-col p-4 border rounded cursor-pointer border-zinc-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 peer-checked:border-red-500 peer-checked:bg-red-50 dark:peer-checked:bg-red-900/10 hover:border-red-300 dark:hover:border-red-800 transition-colors">
                    <span class="font-medium text-black dark:text-white">PostgreSQL</span>
                    <span class="text-sm text-zinc-500 dark:text-zinc-400">Advanced SQL database</span>
                </label>
            </div>
            
            <div class="relative">
                <input type="radio" id="database-type-none" name="database-type" wire:model.live="databaseType" value="none" class="peer absolute h-0 w-0 opacity-0">
                <label for="database-type-none" class="flex flex-col p-4 border rounded cursor-pointer border-zinc-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 peer-checked:border-red-500 peer-checked:bg-red-50 dark:peer-checked:bg-red-900/10 hover:border-red-300 dark:hover:border-red-800 transition-colors">
                    <span class="font-medium text-black dark:text-white">No Database</span>
                    <span class="text-sm text-zinc-500 dark:text-zinc-400">Don't include a database</span>
                </label>
            </div>
        </div>
    </div>
    
    {{-- Database Configuration (Conditional) --}}
    <div x-show="$wire.databaseType !== 'none'" class="space-y-6">
        {{-- MySQL Specific Configuration --}}
        <div x-show="$wire.databaseType === 'mysql'" x-transition>
            <h3 class="text-lg font-medium text-black dark:text-white mb-4">MySQL Configuration</h3>
            <div>
                <label for="mysql-size" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                    MySQL Instance Size
                </label>
                <select id="mysql-size" wire:model.live="mysqlDatabaseSize" class="w-full rounded border border-zinc-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 py-2 pl-3 pr-10 text-base focus:border-red-500 focus:outline-none focus:ring-red-500 sm:text-sm">
                    @php
                        // Ensure the collection exists before iterating
                        $mysqlSizes = $this->getAvailableMySqlSizes();
                    @endphp
                    @if(is_array($mysqlSizes) || $mysqlSizes instanceof \Illuminate\Support\Collection)
                         @foreach($mysqlSizes as $key => $size)
                             {{-- Skip the storage price key --}}
                             @if($key !== 'storage_price_gb_month' && is_array($size))
                                 <option value="{{ $key }}">{{ $size['label'] ?? $key }} - Est. ${{ $size['price_monthly'] ?? 0 }}/month (Compute)</option>
                             @endif
                         @endforeach
                    @endif
                </select>
                 <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                    Monthly estimate based on compute. Storage cost is additional.
                </p>
            </div>
        </div>

        {{-- Postgres Specific Configuration --}}
        <div x-show="$wire.databaseType === 'postgres'" x-transition>
             <h3 class="text-lg font-medium text-black dark:text-white mb-4">Postgres Configuration</h3>
             <div>
                <label for="postgres-compute" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                    Postgres Compute Units (vCPU)
                </label>
                <input 
                    id="postgres-compute"
                    type="number" 
                    wire:model.live="postgresComputeUnits" 
                    min="0.25" 
                    step="0.25" 
                    class="w-full rounded border border-zinc-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 p-2 focus:border-red-500 focus:outline-none focus:ring-red-500 sm:text-sm"
                >
                <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                    Billed per vCPU hour (${{ $this->pricingService->getPostgresCpuPricePerHour() ?? 'N/A' }} / hour). Starts at 0.25 vCPU. Storage cost is additional.
                </p>
             </div>
        </div>

         {{-- Shared Storage Configuration --}}
         <div>
             <h3 class="text-lg font-medium text-black dark:text-white mb-2">Database Storage</h3>
             <div class="flex justify-between items-center mb-1">
                <label for="database-storage" class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                    Storage Amount (GB)
                </label>
                <span class="text-sm font-bold text-black dark:text-white">{{ $databaseStorageGB }} GB</span>
            </div>
            <input 
                id="database-storage"
                type="range" 
                wire:model.live="databaseStorageGB" 
                min="1" 
                max="1000" {{-- Adjust max --}}
                step="1"
                class="w-full h-2 bg-zinc-200 dark:bg-neutral-700 rounded appearance-none cursor-pointer accent-red-500"
            >
            <div class="flex justify-between text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                <span>1 GB</span>
                <span>1000 GB</span>
            </div>
            <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                 @if($databaseType === 'mysql')
                     MySQL Storage: ${{ $this->pricingService->getMySqlStoragePricePerGb() ?? 'N/A' }} / GB-month.
                 @elseif($databaseType === 'postgres')
                     Postgres Storage: ${{ $this->pricingService->getPostgresStoragePricePerGb() ?? 'N/A' }} / GB-month.
                 @endif
            </p>
         </div>

         {{-- Display Total Calculated Database Cost --}}
         <p class="text-sm text-zinc-600 dark:text-zinc-400">
            Estimated Database Cost: <span class="font-semibold text-black dark:text-white">${{ number_format($this->databaseCost(), 2) }}</span> / month
         </p>
    </div>

    <!-- Laravel KV -->
    <div class="mt-6"> {{-- Add margin top --}}
        <h3 class="text-lg font-medium text-black dark:text-white mb-4">Laravel KV</h3>
        
        <div class="space-y-3">
            <label class="flex items-center rounded p-3 border border-zinc-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 hover:border-red-300 dark:hover:border-red-800 transition-colors cursor-pointer">
                <input id="include-kv" type="checkbox" wire:model.live="includeKv" class="h-4 w-4 rounded border-zinc-300 text-red-500 focus:ring-red-500 dark:border-neutral-700 dark:bg-neutral-800">
                <span class="ml-2 text-sm font-medium text-zinc-700 dark:text-zinc-300">Include Laravel KV</span>
            </label>
            
            <div x-show="$wire.includeKv" class="pl-6 pt-2 space-y-3">
                <div>
                    <label for="kv-tier" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                        KV Tier
                    </label>
                    <select id="kv-tier" wire:model.live="kvTier" class="w-full rounded border border-zinc-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 py-2 pl-3 pr-10 text-base focus:border-red-500 focus:outline-none focus:ring-red-500 sm:text-sm">
                        @foreach($this->getAvailableKvTiers() as $key => $tier)
                            <option value="{{ $key }}">{{ $tier['label'] }} - ${{ $tier['price_monthly'] }}/month</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Optional: Display calculated cost for clarity -->
                <!--
                <p class="text-sm text-zinc-500 dark:text-zinc-400">
                    Selected Tier Cost: ${{ $this->kvCost() }}
                </p>
                -->
            </div>
        </div>
    </div>
    
    <!-- Laravel Object Storage -->
    <div>
        <h3 class="text-lg font-medium text-black dark:text-white mb-4">Laravel Object Storage</h3>
        
        <div class="space-y-3">
            <label class="flex items-center rounded p-3 border border-zinc-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 hover:border-red-300 dark:hover:border-red-800 transition-colors cursor-pointer">
                <input id="include-object-storage" type="checkbox" wire:model.live="includeObjectStorage" class="h-4 w-4 rounded border-zinc-300 text-red-500 focus:ring-red-500 dark:border-neutral-700 dark:bg-neutral-800">
                <span class="ml-2 text-sm font-medium text-zinc-700 dark:text-zinc-300">Include Laravel Object Storage</span>
            </label>
            
            <div x-show="$wire.includeObjectStorage" class="pl-6 pt-2 space-y-3">
                {{-- Storage Amount --}}
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <label for="object-storage-gb" class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                            Object Storage (GB)
                        </label>
                        <span class="text-sm font-bold text-black dark:text-white">{{ $objectStorageGB }} GB</span>
                    </div>
                    <input 
                        id="object-storage-gb"
                        type="range" 
                        wire:model.live="objectStorageGB" 
                        min="0" 
                        max="1000" {{-- Adjust max as needed --}}
                        step="10"
                        class="w-full h-2 bg-zinc-200 dark:bg-neutral-700 rounded appearance-none cursor-pointer accent-red-500"
                    >
                     <div class="flex justify-between text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                        <span>0 GB</span>
                        <span>1000 GB</span>
                    </div>
                </div>

                {{-- Class A Operations --}}
                <div>
                    <label for="object-storage-ops-a" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                        Class A Operations (Thousands / month)
                        <span class="text-xs text-zinc-400">(e.g., PutObject, ListObjects)</span>
                    </label>
                    <input 
                        id="object-storage-ops-a"
                        type="number" 
                        wire:model.live="objectStorageClassAOpsThousands" 
                        min="0"
                        step="10"
                        class="w-full rounded border border-zinc-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 p-2 focus:border-red-500 focus:outline-none focus:ring-red-500 sm:text-sm"
                        placeholder="e.g., 100"
                    >
                </div>

                {{-- Class B Operations --}}
                 <div>
                    <label for="object-storage-ops-b" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                        Class B Operations (Thousands / month)
                         <span class="text-xs text-zinc-400">(e.g., GetObject, HeadObject)</span>
                    </label>
                    <input 
                        id="object-storage-ops-b"
                        type="number" 
                        wire:model.live="objectStorageClassBOpsThousands" 
                        min="0"
                        step="100"
                         class="w-full rounded border border-zinc-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 p-2 focus:border-red-500 focus:outline-none focus:ring-red-500 sm:text-sm"
                         placeholder="e.g., 1000"
                    >
                </div>

                 <!-- Display calculated cost -->
                 <p class="text-sm text-zinc-500 dark:text-zinc-400">
                    Estimated Object Storage Cost: <span class="font-semibold text-black dark:text-white">${{ number_format($this->objectStorageCost(), 2) }}</span> / month
                 </p>
            </div>
        </div>
    </div>
</div> 