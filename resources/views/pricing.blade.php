@extends('layouts.pricing')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-bold text-center mb-2 text-red-500">Laravel Cloud Pricing</h1>
        <p class="text-center text-sm text-zinc-500 dark:text-zinc-400 mb-8">Find the perfect plan for your needs</p>
        
        <livewire:ai-pricing-configurator />
        
        <div id="calculator" class="bg-white dark:bg-neutral-900 rounded-lg overflow-hidden">
            <div class="border-b border-zinc-200 dark:border-neutral-700 py-4 px-6">
                <h2 class="text-xl font-semibold">Pricing Calculator</h2>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Customize your setup or use AI recommendations above</p>
            </div>
            <livewire:pricing-calculator />
        </div>
    </div>
@endsection 