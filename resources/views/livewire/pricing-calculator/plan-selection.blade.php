<!-- Plan Selection -->
<div class="p-6 border-b border-zinc-200 dark:border-neutral-700">
    <h2 class="text-3xl font-semibold text-black dark:text-white mb-2">Laravel Cloud Pricing Calculator</h2>
    <p class="text-zinc-500 dark:text-zinc-400 mb-8">Estimate your monthly costs for hosting your Laravel application on Laravel Cloud.</p>
    
    <h3 class="text-xl font-medium text-black dark:text-white mb-6">Choose Your Plan</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Sandbox Plan -->
        <div class="relative group">
            <input type="radio" id="plan-sandbox" name="plan" wire:model.live="plan" value="sandbox" class="peer absolute h-0 w-0 opacity-0">
            <label for="plan-sandbox" class="flex flex-col h-full p-6 border-2 rounded-md cursor-pointer border-zinc-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 peer-checked:border-red-500 hover:border-red-300 transition-colors">
                <div class="mb-4">
                    <span class="inline-block px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">Sandbox</span>
                </div>
                <div class="mb-4">
                    <span class="text-3xl font-bold text-black dark:text-white">${{ $planPrices['sandbox'] }}</span>
                    <span class="text-sm text-zinc-500 dark:text-zinc-400">/month</span>
                </div>
                <ul class="space-y-3 mb-6 flex-grow">
                    <li class="flex items-center text-sm text-zinc-700 dark:text-zinc-300">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Shared compute resources
                    </li>
                    <li class="flex items-center text-sm text-zinc-700 dark:text-zinc-300">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        256MB RAM / 0.5 CPU
                    </li>
                    <li class="flex items-center text-sm text-zinc-700 dark:text-zinc-300">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        1 web / 0 workers
                    </li>
                    <li class="flex items-center text-sm text-zinc-700 dark:text-zinc-300">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        10 GB included bandwidth
                    </li>
                    <li class="flex items-center text-sm text-zinc-700 dark:text-zinc-300">
                        <svg class="w-5 h-5 mr-2 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <span class="text-zinc-400 dark:text-zinc-500">No custom domains</span>
                    </li>
                </ul>
                <div class="text-center mt-auto">
                    <span class="inline-block w-full py-2 px-4 text-sm font-medium rounded peer-checked:bg-red-500 peer-checked:text-white bg-zinc-100 text-zinc-800 dark:bg-neutral-700 dark:text-zinc-200 transition-colors">
                        {{ $plan === 'sandbox' ? 'Selected' : 'Select Plan' }}
                    </span>
                </div>
            </label>
        </div>
        
        <!-- Production Plan -->
        <div class="relative group">
            <div class="absolute -top-2 left-0 right-0 flex justify-center z-10">
                <span class="px-3 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                    Popular
                </span>
            </div>
            <input type="radio" id="plan-production" name="plan" wire:model.live="plan" value="production" class="peer absolute h-0 w-0 opacity-0">
            <label for="plan-production" class="flex flex-col h-full p-6 border-2 rounded-md cursor-pointer border-zinc-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 peer-checked:border-red-500 hover:border-red-300 transition-colors">
                <div class="mb-4">
                    <span class="inline-block px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Production</span>
                </div>
                <div class="mb-4">
                    <span class="text-3xl font-bold text-black dark:text-white">${{ $planPrices['production'] }}</span>
                    <span class="text-sm text-zinc-500 dark:text-zinc-400">/month</span>
                </div>
                <ul class="space-y-3 mb-6 flex-grow">
                    <li class="flex items-center text-sm text-zinc-700 dark:text-zinc-300">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Dedicated compute resources
                    </li>
                    <li class="flex items-center text-sm text-zinc-700 dark:text-zinc-300">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        1GB RAM / 1 CPU
                    </li>
                    <li class="flex items-center text-sm text-zinc-700 dark:text-zinc-300">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        1 web + additional workers
                    </li>
                    <li class="flex items-center text-sm text-zinc-700 dark:text-zinc-300">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        100 GB included bandwidth
                    </li>
                    <li class="flex items-center text-sm text-zinc-700 dark:text-zinc-300">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        3 included custom domains
                    </li>
                </ul>
                <div class="text-center mt-auto">
                    <span class="inline-block w-full py-2 px-4 text-sm font-medium rounded peer-checked:bg-red-500 peer-checked:text-white bg-zinc-100 text-zinc-800 dark:bg-neutral-700 dark:text-zinc-200 transition-colors">
                        {{ $plan === 'production' ? 'Selected' : 'Select Plan' }}
                    </span>
                </div>
            </label>
        </div>
        
        <!-- Business Plan -->
        <div class="relative group">
            <input type="radio" id="plan-business" name="plan" wire:model.live="plan" value="business" class="peer absolute h-0 w-0 opacity-0">
            <label for="plan-business" class="flex flex-col h-full p-6 border-2 rounded-md cursor-pointer border-zinc-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 peer-checked:border-red-500 hover:border-red-300 transition-colors">
                <div class="mb-4">
                    <span class="inline-block px-3 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">Business</span>
                </div>
                <div class="mb-4">
                    <span class="text-3xl font-bold text-black dark:text-white">${{ $planPrices['business'] }}</span>
                    <span class="text-sm text-zinc-500 dark:text-zinc-400">/month</span>
                </div>
                <ul class="space-y-3 mb-6 flex-grow">
                    <li class="flex items-center text-sm text-zinc-700 dark:text-zinc-300">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Enhanced compute resources
                    </li>
                    <li class="flex items-center text-sm text-zinc-700 dark:text-zinc-300">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        2GB RAM / 2 CPU
                    </li>
                    <li class="flex items-center text-sm text-zinc-700 dark:text-zinc-300">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Multiple web & worker replicas
                    </li>
                    <li class="flex items-center text-sm text-zinc-700 dark:text-zinc-300">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        1TB included bandwidth
                    </li>
                    <li class="flex items-center text-sm text-zinc-700 dark:text-zinc-300">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        10 included custom domains
                    </li>
                </ul>
                <div class="text-center mt-auto">
                    <span class="inline-block w-full py-2 px-4 text-sm font-medium rounded peer-checked:bg-red-500 peer-checked:text-white bg-zinc-100 text-zinc-800 dark:bg-neutral-700 dark:text-zinc-200 transition-colors">
                        {{ $plan === 'business' ? 'Selected' : 'Select Plan' }}
                    </span>
                </div>
            </label>
        </div>
    </div>
</div> 