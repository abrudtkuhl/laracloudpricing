<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>The missing Laravel Cloud Pricing Calculator</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="antialiased min-h-screen bg-zinc-50 dark:bg-neutral-900">
    <div class="flex flex-col min-h-screen">

        <main class="flex-1">
            @yield('content')
        </main>

        <footer class="py-8 border-t border-zinc-200 dark:border-neutral-800">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="mb-4 md:mb-0">
                        <p class="text-zinc-500 dark:text-zinc-400">
                            Not affiliate with Laravel. Built by <a href="https://github.com/abrudtkuhl/laracloudpricing" target="_blank" class="text-zinc-500 dark:text-zinc-400 hover:text-black dark:hover:text-white transition-colors">@abrudtkuhl</a>
                        </p>
                    </div>
                    
                </div>
            </div>
        </footer>
        
    </div>
    
    @livewireScripts
</body>
</html> 