<!-- Database and Storage -->
<div class="p-6 border-b border-zinc-200 dark:border-neutral-700">
    <h2 class="text-2xl font-semibold text-black dark:text-white mb-6">Database and Storage</h2>
    
    <!-- Postgres Database -->
    <div class="mb-8">
        <div class="flex items-center mb-4">
            <input wire:model="usePostgres" type="checkbox" class="h-4 w-4 text-red-600 border-zinc-300 dark:border-neutral-600 rounded focus:ring-red-500">
            <h3 class="ml-2 text-lg font-medium text-black dark:text-white">Serverless Postgres</h3>
        </div>
        
        <div class="ml-6 space-y-6" x-show="$wire.usePostgres" x-transition>
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Size
                    </label>
                    <select wire:model="postgresSize" class="w-full rounded-md border-zinc-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-zinc-900 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500">
                        <option value="small">Small (0.5 vCPU, 1GB RAM)</option>
                        <option value="medium">Medium (1 vCPU, 2GB RAM)</option>
                        <option value="large">Large (2 vCPU, 4GB RAM)</option>
                    </select>
                    <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                        Hibernates after 300ms of inactivity
                    </p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Storage (GB)
                    </label>
                    <input type="number" wire:model="postgresStorage" min="0" class="w-full rounded-md border-zinc-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-zinc-900 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500">
                    <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                        $1.50 per GB per month
                    </p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Additional Users
                    </label>
                    <input type="number" wire:model="postgresUsers" min="1" class="w-full rounded-md border-zinc-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-zinc-900 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500">
                    <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                        {{ $plan === 'sandbox' ? 'Additional users not available in Sandbox plan' : '$10.00 per additional user per month (first user included)' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- KV Store -->
    <div class="mb-8">
        <div class="flex items-center mb-4">
            <input wire:model="useKvStore" type="checkbox" class="h-4 w-4 text-red-600 border-zinc-300 dark:border-neutral-600 rounded focus:ring-red-500">
            <h3 class="ml-2 text-lg font-medium text-black dark:text-white">KV Store</h3>
        </div>
        
        <div class="ml-6" x-show="$wire.useKvStore" x-transition>
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Size (GB)
                    </label>
                    <input type="number" wire:model="kvStoreSize" min="0" class="w-full rounded-md border-zinc-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-zinc-900 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500">
                    <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                        $0.30 per GB per month
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Object Storage -->
    <div>
        <h3 class="text-lg font-medium text-black dark:text-white mb-4">Object Storage</h3>
        
        <div class="grid md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                    Storage (GB)
                </label>
                <input type="number" wire:model="objectStorage" min="0" class="w-full rounded-md border-zinc-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-zinc-900 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500">
                <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                    $0.02 per GB per month
                </p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                    Class A Requests (thousands)
                </label>
                <input type="number" wire:model="classARequests" min="0" class="w-full rounded-md border-zinc-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-zinc-900 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500">
                <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                    $0.005 per thousand requests
                </p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                    Class B Requests (thousands)
                </label>
                <input type="number" wire:model="classBRequests" min="0" class="w-full rounded-md border-zinc-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-zinc-900 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500">
                <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                    $0.0005 per thousand requests
                </p>
            </div>
        </div>
    </div>
</div> 