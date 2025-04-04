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
                            <a href="https://github.com/abrudtkuhl/laracloudpricing" class="text-zinc-500 dark:text-zinc-400 hover:text-black dark:hover:text-white transition-colors inline-flex items-center" target="_blank">
                                <svg class="w-4 h-4 inline-block" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M0 12.305C0 17.74 3.438 22.352 8.207 23.979C8.807 24.092 9.027 23.712 9.027 23.386C9.027 23.094 9.016 22.32 9.01 21.293C5.671 22.037 4.967 19.643 4.967 19.643C4.422 18.223 3.635 17.845 3.635 17.845C2.545 17.081 3.718 17.096 3.718 17.096C4.921 17.183 5.555 18.364 5.555 18.364C6.626 20.244 8.364 19.702 9.048 19.386C9.157 18.591 9.468 18.049 9.81 17.741C7.145 17.431 4.344 16.376 4.344 11.661C4.344 10.318 4.811 9.219 5.579 8.359C5.456 8.048 5.044 6.797 5.696 5.103C5.696 5.103 6.704 4.773 8.996 6.364C9.954 6.091 10.98 5.955 12.001 5.95C13.02 5.955 14.047 6.091 15.005 6.364C17.295 4.772 18.302 5.103 18.302 5.103C18.956 6.797 18.544 8.048 18.421 8.359C19.191 9.219 19.655 10.318 19.655 11.661C19.655 16.387 16.849 17.428 14.175 17.732C14.606 18.112 14.99 18.862 14.99 20.011C14.99 21.656 14.975 22.982 14.975 23.386C14.975 23.715 15.191 24.098 15.8 23.977C20.565 22.347 24 17.738 24 12.305C24 5.508 18.627 0 12 0C5.373 0 0 5.508 0 12.305Z" fill="currentColor"></path>
        </svg>                        <span class="sr-only">GitHub</span>
                
                            </a> <a href="https://github.com/abrudtkuhl/laracloudpricing" target="_blank" class="text-zinc-500 dark:text-zinc-400 hover:text-black dark:hover:text-white transition-colors">Built with 🤙 by @abrudtkuhl</a> / <a href="https://surveysnaps.com/surveys/56023cb0-f5c5-41b8-b7a5-6ceb0b211c3f" target="_blank" class="text-zinc-500 dark:text-zinc-400 hover:text-black dark:hover:text-white transition-colors">Give Feedback</a> / <a href="https://donate.stripe.com/dR65ll80XeORasw9AL" target="_blank" class="text-zinc-500 dark:text-zinc-400 hover:text-black dark:hover:text-white transition-colors">Donate</a> 
                        </p>
                        <p class="text-zinc-500 dark:text-zinc-400 text-xs mt-2">
                            Not affiliated with Laravel. 
                            Pricing data is sourced from <a href="https://cloud.laravel.com/docs/pricing" target="_blank" class="text-zinc-900 dark:text-zinc-400 hover:text-black dark:hover:text-white transition-colors">Laravel Cloud Docs</a> and isn't guaranteed to be 100% accurate. Data last updated: 2025-04-04.
                        </p>
                    </div>
                    
                </div>
            </div>
        </footer>
        
    </div>
    
    @livewireScripts
</body>
</html> 