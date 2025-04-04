<div class="bg-white dark:bg-neutral-900 p-6 rounded-lg shadow-sm border border-zinc-200 dark:border-neutral-700 mb-8">
    <div class="flex items-center gap-2 mb-4">
        <div class="bg-red-100 dark:bg-red-900/30 p-2 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
        </div>
        <h2 class="text-xl font-bold text-red-500">AI-Powered Configurator</h2>
    </div>
    
    <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-4">
        Describe your project, and we'll recommend the perfect configuration
    </p>
    
    <div class="mb-4">
        <textarea 
            id="userDescription" 
            wire:model="userDescription" 
            class="w-full px-3 py-2 border border-zinc-300 dark:border-neutral-600 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 dark:bg-neutral-800 dark:text-white"
            rows="2"
            placeholder="e.g., 'Blog with 5,000 monthly visitors and MySQL database' or 'E-commerce site with 15,000 users'"
        ></textarea>
        @error('userDescription') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
    </div>
    
    <div>
        <button 
            wire:click="generateConfiguration" 
            wire:loading.attr="disabled"
            class="px-6 py-2 bg-red-500 text-white font-medium rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 disabled:opacity-50 transition shadow-sm"
        >
            <span wire:loading.remove wire:target="generateConfiguration">Generate Configuration</span>
            <span wire:loading wire:target="generateConfiguration">
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Processing...
            </span>
        </button>
    </div>
    
    @if($hasError)
        <div class="mt-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-800 rounded-md">
            <p class="text-sm text-red-700 dark:text-red-400">{{ $errorMessage }}</p>
        </div>
    @endif
    
    @if(!empty($aiConfiguration))
        <div class="mt-4 bg-zinc-50 dark:bg-neutral-800 p-4 rounded-md">
            <div class="flex flex-col items-center text-center mb-3">
                <h3 class="text-md font-semibold mb-1">Monthly Estimate</h3>
                <div class="text-3xl font-bold text-red-500">
                    ${{ number_format($aiConfiguration['total_monthly_price'] ?? 0, 2)}}
                </div>
                <div class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                    Recommended configuration for your needs
                </div>
            </div>
            
            <div class="mb-3 bg-white dark:bg-neutral-700 border border-zinc-200 dark:border-neutral-600 p-3 rounded">
                <p class="text-sm text-zinc-700 dark:text-zinc-300">{{ $aiConfiguration['explanation'] ?? 'Here is the recommended configuration for your requirements.' }}</p>
            </div>
            
            <div class="grid grid-cols-2 gap-2 mb-3">
                <div class="bg-white dark:bg-neutral-700 p-2 rounded border border-zinc-200 dark:border-neutral-600">
                    <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400">Plan</p>
                    <p class="text-sm font-medium">{{ $aiConfiguration['details']['plan']['label'] ?? 'Not specified' }}</p>
                </div>
                
                @if(isset($aiConfiguration['details']['compute']))
                <div class="bg-white dark:bg-neutral-700 p-2 rounded border border-zinc-200 dark:border-neutral-600">
                    <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400">Compute</p>
                    <p class="text-sm font-medium">{{ $aiConfiguration['details']['compute']['label'] ?? 'Not specified' }}</p>
                </div>
                @endif
                
                @if(isset($aiConfiguration['details']['database']))
                <div class="bg-white dark:bg-neutral-700 p-2 rounded border border-zinc-200 dark:border-neutral-600">
                    <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400">Database</p>
                    <p class="text-sm font-medium">{{ $aiConfiguration['details']['database']['label'] ?? ucfirst($aiConfiguration['details']['database']['type'] ?? 'Not specified') }}</p>
                </div>
                @endif
                
                @if(isset($aiConfiguration['details']['kv']))
                <div class="bg-white dark:bg-neutral-700 p-2 rounded border border-zinc-200 dark:border-neutral-600">
                    <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400">KV Store</p>
                    <p class="text-sm font-medium">{{ $aiConfiguration['details']['kv']['label'] ?? 'Not specified' }}</p>
                </div>
                @endif
            </div>
            
            <div class="flex items-center justify-center border-t border-zinc-200 dark:border-neutral-700 pt-3 mt-2">
                <a href="#calculator" class="inline-flex items-center text-sm text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 transition">
                    <svg class="mr-1.5 h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Applied to calculator below</span>
                    <svg class="ml-1.5 h-4 w-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </a>
            </div>
        </div>
    @endif
</div> 