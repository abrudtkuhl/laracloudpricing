<!-- Plan Selection -->
<div class="bg-white dark:bg-neutral-800/50 p-6 sm:p-8">
    {{-- Add back the main title and description --}}
    <h2 class="text-3xl font-semibold text-black dark:text-white mb-2">Laravel Cloud Pricing Calculator</h2>
    <p class="text-zinc-500 dark:text-zinc-400 mb-8">Estimate your monthly costs for hosting your Laravel application on Laravel Cloud.</p>

    <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">Choose your plan</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($this->availablePlans as $planKey => $planDetails)
            <div class="relative">
                <input 
                    type="radio" 
                    wire:model.live="plan" 
                    value="{{ $planKey }}" 
                    id="plan-{{ $planKey }}" 
                    class="peer sr-only"
                >
                <label 
                    for="plan-{{ $planKey }}" 
                    class="flex flex-col h-full p-6 border-2 rounded-md cursor-pointer border-zinc-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 peer-checked:border-red-500 hover:border-red-300 transition-colors"
                >
                    <div class="mb-4">
                        <span class="inline-block px-3 py-1 text-xs font-medium rounded-full 
                            @if($planKey === 'sandbox') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 
                            @elseif($planKey === 'production') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                            @else bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200 @endif"
                        >
                            {{ $planDetails['label'] ?? ucfirst($planKey) }}
                        </span>
                    </div>
                    <div class="mb-4">
                        <span class="text-3xl font-bold text-black dark:text-white">${{ $planDetails['price_monthly'] ?? 0 }}</span>
                        <span class="text-sm text-zinc-500 dark:text-zinc-400">/month</span>
                    </div>
                    <ul class="space-y-3 mb-6 flex-grow text-sm text-zinc-700 dark:text-zinc-300">
                        @if($planKey === 'sandbox')
                            <li class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Shared compute resources
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                {{ $this->pricingService->getPlanAllowance('data_transfer', 'sandbox') }} GB Data Transfer
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                {{ number_format($this->pricingService->getPlanAllowance('requests', 'sandbox')) }}M Edge Requests
                            </li>
                             <li class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                {{ $this->pricingService->getPlanAllowance('users', 'sandbox') }} Team Members
                            </li>
                        @elseif($planKey === 'production')
                             <li class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Dedicated compute resources
                            </li>
                             <li class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                {{ $this->pricingService->getPlanAllowance('data_transfer', 'production') }} GB Data Transfer
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                {{ number_format($this->pricingService->getPlanAllowance('requests', 'production')) }}M Edge Requests
                            </li>
                             <li class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                {{ $this->pricingService->getPlanAllowance('users', 'production') }} Team Members
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                {{ $this->pricingService->getPlanAllowance('custom_domains', 'production') }} Custom Domains
                            </li>
                        @else {{-- Business Plan --}}
                             <li class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Enhanced compute & features
                            </li>
                             <li class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                {{ ($this->pricingService->getPlanAllowance('data_transfer', 'business') / 1000) }} TB Data Transfer
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                {{ number_format($this->pricingService->getPlanAllowance('requests', 'business')) }}M Edge Requests
                            </li>
                             <li class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                {{ $this->pricingService->getPlanAllowance('users', 'business') }} Team Members
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                {{ $this->pricingService->getPlanAllowance('custom_domains', 'business') }} Custom Domains
                            </li>
                             <li class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Priority Support
                            </li>
                        @endif
                    </ul>
                    <div class="mt-auto">
                        <span class="block w-full text-center px-4 py-2 rounded-md 
                            peer-checked:bg-red-500 peer-checked:text-white 
                            bg-gray-100 dark:bg-neutral-700 text-gray-700 dark:text-gray-200 peer-hover:bg-red-100 dark:peer-hover:bg-red-900/50 transition-colors">
                            {{ $plan == $planKey ? 'Selected' : 'Select Plan' }}
                        </span>
                    </div>
                </label>
            </div>
        @endforeach
    </div>
</div> 