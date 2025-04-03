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
                Sandbox plan includes {{ $dataTransferFreeAllowance['sandbox'] }}GB data transfer for free. Additional data is ${{ $dataTransferPrice }}/GB.
            @elseif($plan == 'production')
                Production plan includes {{ $dataTransferFreeAllowance['production'] }}GB data transfer for free. Additional data is ${{ $dataTransferPrice }}/GB.
            @elseif($plan == 'business')
                Business plan includes {{ $dataTransferFreeAllowance['business'] }}GB data transfer for free. Additional data is ${{ $dataTransferPrice }}/GB.
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
                Sandbox plan includes {{ $requestsFreeAllowance['sandbox'] }}M requests for free. Additional requests are ${{ $requestsPrice }} per million.
            @elseif($plan == 'production')
                Production plan includes {{ $requestsFreeAllowance['production'] }}M requests for free. Additional requests are ${{ $requestsPrice }} per million.
            @elseif($plan == 'business')
                Business plan includes {{ $requestsFreeAllowance['business'] }}M requests for free. Additional requests are ${{ $requestsPrice }} per million.
            @endif
        </p>
    </div>
    
    <!-- Custom Domains -->
    <div>
        <div class="flex justify-between items-center mb-2">
            <label for="custom-domains" class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                Custom Domains
            </label>
            <div class="flex space-x-2 items-center">
                <button type="button" wire:click="decrementCustomDomains" class="inline-flex items-center justify-center w-8 h-8 border border-zinc-300 dark:border-neutral-700 rounded bg-white dark:bg-neutral-800 text-black dark:text-white hover:bg-zinc-50 dark:hover:bg-neutral-700" {{ $plan == 'sandbox' ? 'disabled' : '' }}>
                    <span class="sr-only">Decrease</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                    </svg>
                </button>
                <span class="w-10 text-center font-bold text-black dark:text-white">{{ $customDomains }}</span>
                <button type="button" wire:click="incrementCustomDomains" class="inline-flex items-center justify-center w-8 h-8 border border-zinc-300 dark:border-neutral-700 rounded bg-white dark:bg-neutral-800 text-black dark:text-white hover:bg-zinc-50 dark:hover:bg-neutral-700" {{ $plan == 'sandbox' ? 'disabled' : '' }}>
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
                id="custom-domains" 
                wire:model.live="customDomains" 
                min="0" 
                max="50" 
                step="1"
                class="w-full h-2 bg-zinc-200 dark:bg-neutral-700 rounded appearance-none cursor-pointer accent-red-500"
                {{ $plan == 'sandbox' ? 'disabled' : '' }}
            >
        </div>
        
        <div class="grid grid-cols-3">
            <span class="text-xs text-zinc-500 dark:text-zinc-400">0</span>
            <span class="text-xs text-center text-zinc-500 dark:text-zinc-400">25</span>
            <span class="text-xs text-right text-zinc-500 dark:text-zinc-400">50</span>
        </div>
        
        <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
            @if($plan == 'sandbox')
                Sandbox plan does not include custom domains. Upgrade to Production or Business plan.
            @elseif($plan == 'production')
                Production plan includes {{ $customDomainsFreeAllowance['production'] }} custom domains for free. Additional domains are ${{ $customDomainsPrice }} per month.
            @elseif($plan == 'business')
                Business plan includes {{ $customDomainsFreeAllowance['business'] }} custom domains for free. Additional domains are ${{ $customDomainsPrice }} per month.
            @endif
        </p>
    </div>
</div> 