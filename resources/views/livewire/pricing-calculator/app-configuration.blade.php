<!-- App Configuration -->
<div class="p-6 border-b border-zinc-200 dark:border-neutral-700">
    <h2 class="text-2xl font-semibold text-black dark:text-white mb-6">App Configuration</h2>
    
    <!-- Web app compute size -->
    <div class="mb-6">
        <h3 class="text-lg font-medium text-black dark:text-white mb-4">Web App Compute Size</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="relative">
                <input type="radio" id="web-compute-size-0.5" name="web-compute-size" wire:model.live="webComputeSize" value="0.5" class="peer absolute h-0 w-0 opacity-0">
                <label for="web-compute-size-0.5" class="flex flex-col p-4 border rounded cursor-pointer border-zinc-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 peer-checked:border-red-500 peer-checked:bg-red-50 dark:peer-checked:bg-red-900/10 hover:border-red-300 dark:hover:border-red-800 transition-colors">
                    <span class="font-medium text-black dark:text-white">0.5 CPU / 512 MB</span>
                    <span class="text-sm text-zinc-500 dark:text-zinc-400">Small apps or development</span>
                    <span class="mt-2 text-sm font-semibold text-red-500">${{ $webComputePrices['0.5'] ?? 0 }}/mo per instance</span>
                </label>
            </div>
            
            <div class="relative">
                <input type="radio" id="web-compute-size-1" name="web-compute-size" wire:model.live="webComputeSize" value="1" class="peer absolute h-0 w-0 opacity-0">
                <label for="web-compute-size-1" class="flex flex-col p-4 border rounded cursor-pointer border-zinc-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 peer-checked:border-red-500 peer-checked:bg-red-50 dark:peer-checked:bg-red-900/10 hover:border-red-300 dark:hover:border-red-800 transition-colors">
                    <span class="font-medium text-black dark:text-white">1 CPU / 1 GB</span>
                    <span class="text-sm text-zinc-500 dark:text-zinc-400">Medium traffic apps</span>
                    <span class="mt-2 text-sm font-semibold text-red-500">${{ $webComputePrices['1'] ?? 0 }}/mo per instance</span>
                </label>
            </div>
            
            <div class="relative">
                <input type="radio" id="web-compute-size-2" name="web-compute-size" wire:model.live="webComputeSize" value="2" class="peer absolute h-0 w-0 opacity-0">
                <label for="web-compute-size-2" class="flex flex-col p-4 border rounded cursor-pointer border-zinc-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 peer-checked:border-red-500 peer-checked:bg-red-50 dark:peer-checked:bg-red-900/10 hover:border-red-300 dark:hover:border-red-800 transition-colors">
                    <span class="font-medium text-black dark:text-white">2 CPU / 2 GB</span>
                    <span class="text-sm text-zinc-500 dark:text-zinc-400">High traffic apps</span>
                    <span class="mt-2 text-sm font-semibold text-red-500">${{ $webComputePrices['2'] ?? 0 }}/mo per instance</span>
                </label>
            </div>
        </div>
    </div>
    
    <!-- Web App Instances -->
    <div class="mb-6">
        <h3 class="text-lg font-medium text-black dark:text-white mb-4">Web App Instances</h3>
        
        <div class="flex flex-col space-y-4">
            <div class="flex justify-between items-center mb-2">
                <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                    Number of Instances
                </label>
                <div class="flex space-x-2 items-center">
                    <button type="button" wire:click="decrementWebInstances" class="inline-flex items-center justify-center w-8 h-8 border border-zinc-300 dark:border-neutral-700 rounded bg-white dark:bg-neutral-800 text-black dark:text-white hover:bg-zinc-50 dark:hover:bg-neutral-700">
                        <span class="sr-only">Decrease</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <span class="w-10 text-center font-bold text-black dark:text-white">{{ $webInstances }}</span>
                    <button type="button" wire:click="incrementWebInstances" class="inline-flex items-center justify-center w-8 h-8 border border-zinc-300 dark:border-neutral-700 rounded bg-white dark:bg-neutral-800 text-black dark:text-white hover:bg-zinc-50 dark:hover:bg-neutral-700">
                        <span class="sr-only">Increase</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
            
            <div class="mb-2">
                <input 
                    type="range" 
                    wire:model.live="webInstances" 
                    min="1" 
                    max="10" 
                    step="1"
                    class="w-full h-2 bg-zinc-200 dark:bg-neutral-700 rounded appearance-none cursor-pointer accent-red-500"
                >
            </div>
            
            <div class="grid grid-cols-3">
                <span class="text-xs text-zinc-500 dark:text-zinc-400">1</span>
                <span class="text-xs text-center text-zinc-500 dark:text-zinc-400">5</span>
                <span class="text-xs text-right text-zinc-500 dark:text-zinc-400">10</span>
            </div>
        </div>
    </div>
    
    <!-- Workers -->
    <div class="mb-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-medium text-black dark:text-white">Workers</h3>
            <label class="inline-flex items-center">
                <input type="checkbox" wire:model.live="includeWorkers" class="h-4 w-4 rounded border-zinc-300 text-red-500 focus:ring-red-500 dark:border-neutral-700 dark:bg-neutral-800">
                <span class="ml-2 text-sm font-medium text-zinc-700 dark:text-zinc-300">Include Workers</span>
            </label>
        </div>
        
        <div x-show="$wire.includeWorkers">
            <!-- Worker compute size -->
            <div class="mb-6">
                <h4 class="text-base font-medium text-black dark:text-white mb-4">Worker Compute Size</h4>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="relative">
                        <input type="radio" id="worker-compute-size-0.5" name="worker-compute-size" wire:model.live="workerComputeSize" value="0.5" class="peer absolute h-0 w-0 opacity-0">
                        <label for="worker-compute-size-0.5" class="flex flex-col p-4 border rounded cursor-pointer border-zinc-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 peer-checked:border-red-500 peer-checked:bg-red-50 dark:peer-checked:bg-red-900/10 hover:border-red-300 dark:hover:border-red-800 transition-colors">
                            <span class="font-medium text-black dark:text-white">0.5 CPU / 512 MB</span>
                            <span class="text-sm text-zinc-500 dark:text-zinc-400">Light processing</span>
                            <span class="mt-2 text-sm font-semibold text-red-500">${{ $workerComputePrices['0.5'] ?? 0 }}/mo per instance</span>
                        </label>
                    </div>
                    
                    <div class="relative">
                        <input type="radio" id="worker-compute-size-1" name="worker-compute-size" wire:model.live="workerComputeSize" value="1" class="peer absolute h-0 w-0 opacity-0">
                        <label for="worker-compute-size-1" class="flex flex-col p-4 border rounded cursor-pointer border-zinc-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 peer-checked:border-red-500 peer-checked:bg-red-50 dark:peer-checked:bg-red-900/10 hover:border-red-300 dark:hover:border-red-800 transition-colors">
                            <span class="font-medium text-black dark:text-white">1 CPU / 1 GB</span>
                            <span class="text-sm text-zinc-500 dark:text-zinc-400">Medium processing</span>
                            <span class="mt-2 text-sm font-semibold text-red-500">${{ $workerComputePrices['1'] ?? 0 }}/mo per instance</span>
                        </label>
                    </div>
                    
                    <div class="relative">
                        <input type="radio" id="worker-compute-size-2" name="worker-compute-size" wire:model.live="workerComputeSize" value="2" class="peer absolute h-0 w-0 opacity-0">
                        <label for="worker-compute-size-2" class="flex flex-col p-4 border rounded cursor-pointer border-zinc-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 peer-checked:border-red-500 peer-checked:bg-red-50 dark:peer-checked:bg-red-900/10 hover:border-red-300 dark:hover:border-red-800 transition-colors">
                            <span class="font-medium text-black dark:text-white">2 CPU / 2 GB</span>
                            <span class="text-sm text-zinc-500 dark:text-zinc-400">Heavy processing</span>
                            <span class="mt-2 text-sm font-semibold text-red-500">${{ $workerComputePrices['2'] ?? 0 }}/mo per instance</span>
                        </label>
                    </div>
                </div>
            </div>
            
            <!-- Worker Instances -->
            <div>
                <h4 class="text-base font-medium text-black dark:text-white mb-4">Worker Instances</h4>
                
                <div class="flex flex-col space-y-4">
                    <div class="flex justify-between items-center mb-2">
                        <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                            Number of Instances
                        </label>
                        <div class="flex space-x-2 items-center">
                            <button type="button" wire:click="decrementWorkerInstances" class="inline-flex items-center justify-center w-8 h-8 border border-zinc-300 dark:border-neutral-700 rounded bg-white dark:bg-neutral-800 text-black dark:text-white hover:bg-zinc-50 dark:hover:bg-neutral-700">
                                <span class="sr-only">Decrease</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <span class="w-10 text-center font-bold text-black dark:text-white">{{ $workerInstances }}</span>
                            <button type="button" wire:click="incrementWorkerInstances" class="inline-flex items-center justify-center w-8 h-8 border border-zinc-300 dark:border-neutral-700 rounded bg-white dark:bg-neutral-800 text-black dark:text-white hover:bg-zinc-50 dark:hover:bg-neutral-700">
                                <span class="sr-only">Increase</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <div class="mb-2">
                        <input 
                            type="range" 
                            wire:model.live="workerInstances" 
                            min="1" 
                            max="10" 
                            step="1"
                            class="w-full h-2 bg-zinc-200 dark:bg-neutral-700 rounded appearance-none cursor-pointer accent-red-500"
                        >
                    </div>
                    
                    <div class="grid grid-cols-3">
                        <span class="text-xs text-zinc-500 dark:text-zinc-400">1</span>
                        <span class="text-xs text-center text-zinc-500 dark:text-zinc-400">5</span>
                        <span class="text-xs text-right text-zinc-500 dark:text-zinc-400">10</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 