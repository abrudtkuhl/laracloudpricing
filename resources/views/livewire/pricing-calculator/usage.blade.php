<!-- Usage Configuration -->
<div class="p-6 border-b border-zinc-200 dark:border-neutral-700">
    <h2 class="text-2xl font-semibold text-black dark:text-white mb-6">Usage Configuration</h2>
    
    <!-- Data Transfer -->
    <div class="mb-6">
        <div class="flex justify-between items-center mb-2">
            <label for="data-transfer" class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                Data Transfer (GB)
            </label>
            <div class="flex space-x-2 items-center">
                <button type="button" wire:click="decrementDataTransfer" class="inline-flex items-center justify-center w-8 h-8 border border-zinc-300 dark:border-neutral-700 rounded bg-white dark:bg-neutral-800 text-black dark:text-white hover:bg-zinc-50 dark:hover:bg-neutral-700">
                    <span class="sr-only">Decrease</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                    </svg>
                </button>
                <span class="w-10 text-center font-bold text-black dark:text-white">{{ $dataTransfer }}</span>
                <button type="button" wire:click="incrementDataTransfer" class="inline-flex items-center justify-center w-8 h-8 border border-zinc-300 dark:border-neutral-700 rounded bg-white dark:bg-neutral-800 text-black dark:text-white hover:bg-zinc-50 dark:hover:bg-neutral-700">
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
                id="data-transfer" 
                wire:model.live="dataTransfer" 
                min="1" 
                max="500" 
                step="1"
                class="w-full h-2 bg-zinc-200 dark:bg-neutral-700 rounded appearance-none cursor-pointer accent-red-500"
            >
        </div>
        
        <div class="grid grid-cols-3">
            <span class="text-xs text-zinc-500 dark:text-zinc-400">1 GB</span>
            <span class="text-xs text-center text-zinc-500 dark:text-zinc-400">250 GB</span>
            <span class="text-xs text-right text-zinc-500 dark:text-zinc-400">500 GB</span>
        </div>
        
        <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
            @if($plan == 'sandbox')
                Sandbox plan includes {{ $this->pricingService->getPlanAllowance('data_transfer', 'sandbox') }}GB data transfer for free. Additional data is ${{ number_format($this->pricingService->getDataTransferPricePerGb() ?? 0, 2) }}/GB.
            @elseif($plan == 'production')
                Production plan includes {{ $this->pricingService->getPlanAllowance('data_transfer', 'production') }}GB data transfer for free. Additional data is ${{ number_format($this->pricingService->getDataTransferPricePerGb() ?? 0, 2) }}/GB.
            @elseif($plan == 'business')
                Business plan includes {{ $this->pricingService->getPlanAllowance('data_transfer', 'business') }}GB data transfer for free. Additional data is ${{ number_format($this->pricingService->getDataTransferPricePerGb() ?? 0, 2) }}/GB.
            @endif
        </p>
    </div>
    
    <!-- Requests -->
    <div class="mb-6">
        <div class="flex justify-between items-center mb-2">
            <label for="requests" class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                Requests (millions)
            </label>
            <div class="flex space-x-2 items-center">
                <button type="button" wire:click="decrementRequests" class="inline-flex items-center justify-center w-8 h-8 border border-zinc-300 dark:border-neutral-700 rounded bg-white dark:bg-neutral-800 text-black dark:text-white hover:bg-zinc-50 dark:hover:bg-neutral-700">
                    <span class="sr-only">Decrease</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                    </svg>
                </button>
                <span class="w-10 text-center font-bold text-black dark:text-white">{{ $requests }}</span>
                <button type="button" wire:click="incrementRequests" class="inline-flex items-center justify-center w-8 h-8 border border-zinc-300 dark:border-neutral-700 rounded bg-white dark:bg-neutral-800 text-black dark:text-white hover:bg-zinc-50 dark:hover:bg-neutral-700">
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
                id="requests" 
                wire:model.live="requests" 
                min="1" 
                max="100" 
                step="1"
                class="w-full h-2 bg-zinc-200 dark:bg-neutral-700 rounded appearance-none cursor-pointer accent-red-500"
            >
        </div>
        
        <div class="grid grid-cols-3">
            <span class="text-xs text-zinc-500 dark:text-zinc-400">1M</span>
            <span class="text-xs text-center text-zinc-500 dark:text-zinc-400">50M</span>
            <span class="text-xs text-right text-zinc-500 dark:text-zinc-400">100M</span>
        </div>
        
        <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
            @if($plan == 'sandbox')
                Sandbox plan includes {{ number_format($this->pricingService->getPlanAllowance('requests', 'sandbox')) }}M requests for free. Additional requests are ${{ number_format($this->pricingService->getRequestsPricePerMillion() ?? 0, 2) }} per million.
            @elseif($plan == 'production')
                Production plan includes {{ number_format($this->pricingService->getPlanAllowance('requests', 'production')) }}M requests for free. Additional requests are ${{ number_format($this->pricingService->getRequestsPricePerMillion() ?? 0, 2) }} per million.
            @elseif($plan == 'business')
                Business plan includes {{ number_format($this->pricingService->getPlanAllowance('requests', 'business')) }}M requests for free. Additional requests are ${{ number_format($this->pricingService->getRequestsPricePerMillion() ?? 0, 2) }} per million.
            @endif
        </p>
    </div>
    
    <!-- Custom Domains -->
    <div class="mb-6">
        <div class="flex justify-between items-center mb-2">
            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                Custom Domains
            </label>
            @if($plan != 'sandbox')
            <div class="bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200 text-xs font-medium px-2.5 py-0.5 rounded-full">
                {{ $this->pricingService->getPlanAllowance('custom_domains', $plan) }} included
            </div>
            @endif
        </div>
        
        @if($plan == 'sandbox')
            <div class="p-4 bg-zinc-100 dark:bg-neutral-800 rounded-md border border-zinc-200 dark:border-neutral-700">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-zinc-500 dark:text-zinc-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">
                        Sandbox plan does not include custom domains. Upgrade to Production or Business plan.
                    </p>
                </div>
            </div>
        @else
            <div class="p-4 bg-zinc-50 dark:bg-neutral-800 rounded-md border border-zinc-200 dark:border-neutral-700">
                <p class="text-sm text-zinc-600 dark:text-zinc-400">
                    Your {{ ucfirst($plan) }} plan includes {{ $this->pricingService->getPlanAllowance('custom_domains', $plan) }} custom domains.
                </p>
                
                @if($plan == 'production')
                    <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-2">
                        Need more domains? <a href="#" class="text-red-500 hover:text-red-600 font-medium">Upgrade to Business</a> for 10 domains.
                    </p>
                @endif
            </div>
        @endif
    </div>

    <!-- Additional Users -->
    <div>
        <div class="flex justify-between items-center mb-2">
            <label for="additional-users" class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                Additional Users (beyond free allowance)
            </label>
            <div class="flex space-x-2 items-center">
                <button type="button" wire:click="$set('additionalUsers', {{ max(0, $additionalUsers - 1) }})" class="inline-flex items-center justify-center w-8 h-8 border border-zinc-300 dark:border-neutral-700 rounded bg-white dark:bg-neutral-800 text-black dark:text-white hover:bg-zinc-50 dark:hover:bg-neutral-700" {{ $plan == 'sandbox' ? 'disabled' : '' }}>
                    <span class="sr-only">Decrease</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                    </svg>
                </button>
                <span class="w-10 text-center font-bold text-black dark:text-white">{{ $additionalUsers }}</span>
                <button type="button" wire:click="$set('additionalUsers', {{ $additionalUsers + 1 }})" class="inline-flex items-center justify-center w-8 h-8 border border-zinc-300 dark:border-neutral-700 rounded bg-white dark:bg-neutral-800 text-black dark:text-white hover:bg-zinc-50 dark:hover:bg-neutral-700" {{ $plan == 'sandbox' ? 'disabled' : '' }}>
                    <span class="sr-only">Increase</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
        
        {{-- Simple number input is likely better than a range here --}}
        <div class="mb-2">
             <input 
                id="additional-users"
                type="number" 
                wire:model.live="additionalUsers" 
                min="0" 
                step="1"
                class="w-full rounded border border-zinc-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 p-2 focus:border-red-500 focus:outline-none focus:ring-red-500 sm:text-sm"
                placeholder="0"
                 {{ $plan == 'sandbox' ? 'disabled' : '' }}
            >
        </div>

        <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
            @if($plan == 'sandbox')
                Additional users cannot be added to the Sandbox plan (includes {{ $this->pricingService->getPlanAllowance('users', 'sandbox') }} free users).
            @elseif($plan == 'production')
                Production plan includes {{ $this->pricingService->getPlanAllowance('users', 'production') }} free users. Additional users are ${{ number_format($this->pricingService->getAdditionalUserPrice() ?? 0, 2) }} per user/month.
            @elseif($plan == 'business')
                Business plan includes {{ $this->pricingService->getPlanAllowance('users', 'business') }} free users. Additional users are ${{ number_format($this->pricingService->getAdditionalUserPrice() ?? 0, 2) }} per user/month.
            @endif
        </p>
    </div>

</div> 