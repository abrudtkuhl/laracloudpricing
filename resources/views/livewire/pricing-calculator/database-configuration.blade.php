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
                <input type="radio" id="database-type-postgresql" name="database-type" wire:model.live="databaseType" value="postgresql" class="peer absolute h-0 w-0 opacity-0">
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
    
    <!-- Database Size -->
    <div class="mb-6" x-show="$wire.databaseType !== 'none'">
        <h3 class="text-lg font-medium text-black dark:text-white mb-4">Database Size</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="relative">
                <input type="radio" id="database-size-1gb" name="database-size" wire:model.live="databaseSize" value="1" class="peer absolute h-0 w-0 opacity-0">
                <label for="database-size-1gb" class="flex flex-col p-4 h-full border rounded cursor-pointer border-zinc-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 peer-checked:border-red-500 peer-checked:bg-red-50 dark:peer-checked:bg-red-900/10 hover:border-red-300 dark:hover:border-red-800 transition-colors">
                    <span class="font-medium text-black dark:text-white">1 GB</span>
                    <span class="text-sm text-zinc-500 dark:text-zinc-400">Small projects</span>
                    <span class="mt-2 text-sm font-semibold text-red-500">${{ $databasePrices[1] ?? 0 }}/mo</span>
                </label>
            </div>
            
            <div class="relative">
                <input type="radio" id="database-size-3gb" name="database-size" wire:model.live="databaseSize" value="3" class="peer absolute h-0 w-0 opacity-0">
                <label for="database-size-3gb" class="flex flex-col p-4 h-full border rounded cursor-pointer border-zinc-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 peer-checked:border-red-500 peer-checked:bg-red-50 dark:peer-checked:bg-red-900/10 hover:border-red-300 dark:hover:border-red-800 transition-colors">
                    <span class="font-medium text-black dark:text-white">3 GB</span>
                    <span class="text-sm text-zinc-500 dark:text-zinc-400">Medium projects</span>
                    <span class="mt-2 text-sm font-semibold text-red-500">${{ $databasePrices[3] ?? 0 }}/mo</span>
                </label>
            </div>
            
            <div class="relative">
                <input type="radio" id="database-size-5gb" name="database-size" wire:model.live="databaseSize" value="5" class="peer absolute h-0 w-0 opacity-0">
                <label for="database-size-5gb" class="flex flex-col p-4 h-full border rounded cursor-pointer border-zinc-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 peer-checked:border-red-500 peer-checked:bg-red-50 dark:peer-checked:bg-red-900/10 hover:border-red-300 dark:hover:border-red-800 transition-colors">
                    <span class="font-medium text-black dark:text-white">5 GB</span>
                    <span class="text-sm text-zinc-500 dark:text-zinc-400">Large projects</span>
                    <span class="mt-2 text-sm font-semibold text-red-500">${{ $databasePrices[5] ?? 0 }}/mo</span>
                </label>
            </div>
            
            <div class="relative">
                <input type="radio" id="database-size-10gb" name="database-size" wire:model.live="databaseSize" value="10" class="peer absolute h-0 w-0 opacity-0">
                <label for="database-size-10gb" class="flex flex-col p-4 h-full border rounded cursor-pointer border-zinc-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 peer-checked:border-red-500 peer-checked:bg-red-50 dark:peer-checked:bg-red-900/10 hover:border-red-300 dark:hover:border-red-800 transition-colors">
                    <span class="font-medium text-black dark:text-white">10 GB</span>
                    <span class="text-sm text-zinc-500 dark:text-zinc-400">Enterprise projects</span>
                    <span class="mt-2 text-sm font-semibold text-red-500">${{ $databasePrices[10] ?? 0 }}/mo</span>
                </label>
            </div>
        </div>
    </div>
    
    <!-- Laravel KV -->
    <div class="mb-6">
        <h3 class="text-lg font-medium text-black dark:text-white mb-4">Laravel KV</h3>
        
        <div class="space-y-3">
            <label class="flex items-center rounded p-3 border border-zinc-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 hover:border-red-300 dark:hover:border-red-800 transition-colors cursor-pointer">
                <input id="include-kv" type="checkbox" wire:model.live="includeKv" class="h-4 w-4 rounded border-zinc-300 text-red-500 focus:ring-red-500 dark:border-neutral-700 dark:bg-neutral-800">
                <span class="ml-2 text-sm font-medium text-zinc-700 dark:text-zinc-300">Include Laravel KV</span>
            </label>
            
            <div x-show="$wire.includeKv" class="pl-6 pt-2">
                <div class="flex justify-between items-center mb-2">
                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                        KV Storage (GB)
                    </label>
                    <span class="text-sm font-bold text-black dark:text-white">{{ $kvStorage }} GB</span>
                </div>
                
                <div class="mb-2">
                    <input 
                        type="range" 
                        wire:model.live="kvStorage" 
                        min="1" 
                        max="10" 
                        step="1"
                        class="w-full h-2 bg-zinc-200 dark:bg-neutral-700 rounded appearance-none cursor-pointer accent-red-500"
                    >
                </div>
                
                <div class="grid grid-cols-3">
                    <span class="text-xs text-zinc-500 dark:text-zinc-400">1 GB</span>
                    <span class="text-xs text-center text-zinc-500 dark:text-zinc-400">5 GB</span>
                    <span class="text-xs text-right text-zinc-500 dark:text-zinc-400">10 GB</span>
                </div>
                
                <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
                    ${{ $kvPrices[$kvStorage] ?? 0 }}/month for {{ $kvStorage }} GB
                </p>
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
            
            <div x-show="$wire.includeObjectStorage" class="pl-6 pt-2">
                <div class="flex justify-between items-center mb-2">
                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                        Object Storage (GB)
                    </label>
                    <span class="text-sm font-bold text-black dark:text-white">{{ $objectStorage }} GB</span>
                </div>
                
                <div class="mb-2">
                    <input 
                        type="range" 
                        wire:model.live="objectStorage" 
                        min="5" 
                        max="100" 
                        step="5"
                        class="w-full h-2 bg-zinc-200 dark:bg-neutral-700 rounded appearance-none cursor-pointer accent-red-500"
                    >
                </div>
                
                <div class="grid grid-cols-3">
                    <span class="text-xs text-zinc-500 dark:text-zinc-400">5 GB</span>
                    <span class="text-xs text-center text-zinc-500 dark:text-zinc-400">50 GB</span>
                    <span class="text-xs text-right text-zinc-500 dark:text-zinc-400">100 GB</span>
                </div>
                
                <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
                    ${{ $objectStoragePrices[$objectStorage] ?? 0 }}/month for {{ $objectStorage }} GB
                </p>
            </div>
        </div>
    </div>
</div> 