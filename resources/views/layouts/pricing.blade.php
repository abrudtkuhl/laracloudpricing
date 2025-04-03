<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Laravel Cloud Pricing Calculator' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="antialiased min-h-screen bg-zinc-50 dark:bg-neutral-900">
    <div class="flex flex-col min-h-screen">
        {{-- <header class="py-6 border-b border-zinc-200 dark:border-neutral-800 bg-white dark:bg-neutral-900">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center">
                    <a href="/" class="flex items-center">
                        <svg class="h-8 w-auto text-[#F53003] dark:text-[#F61500]" viewBox="0 0 84 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3.58219 0H0V23.5804H10.2956V20.0252H3.58219V0Z" fill="currentColor"/>
                            <path d="M22.9369 9.61203C22.4778 8.79856 21.8341 8.17026 21.0037 7.70753C20.1746 7.24513 19.3206 7.01377 18.451 7.01377C17.3521 7.01377 16.3479 7.20918 15.4396 7.59965C14.5314 7.99012 13.7417 8.5418 13.0731 9.54655C12.4041 10.3339 11.8953 11.2393 11.5491 12.2634C11.2029 13.2882 11.0297 14.3791 11.0297 15.5349C11.0297 16.7118 11.2029 17.8126 11.5491 18.8374C11.8953 19.8616 12.4041 20.75 13.0731 21.5374C13.7417 22.3249 14.5314 22.9544 15.4396 23.3444C16.3479 23.7348 17.3521 23.9302 18.451 23.9302C19.3206 23.9302 20.1746 23.6988 21.0037 23.2365C21.8341 22.7737 22.4778 22.1451 22.9369 21.3318V23.5801H26.3195V7.4281H22.9369V9.61203ZM22.6249 17.4902C22.417 18.1147 22.1242 18.6672 21.7497 19.1341C21.3748 19.6011 20.9217 19.9694 20.3882 20.2388C19.8546 20.5082 19.2797 20.6428 18.6459 20.6428C18.0116 20.6428 17.4468 20.5082 16.9414 20.2388C16.4361 19.9694 16.0102 19.6011 15.6649 19.1341C15.3193 18.6672 15.0569 18.1147 14.8772 17.4902C14.6969 16.8661 14.607 16.2073 14.607 15.535C14.607 14.8626 14.6969 14.2038 14.8772 13.5797C15.0569 12.9555 15.3193 12.4037 15.6649 11.9364C16.0102 11.4694 16.4359 11.1011 16.9414 10.8317C17.4468 10.5623 18.0116 10.4277 18.6459 10.4277C19.2799 10.4277 19.8546 10.5623 20.3882 10.8317C20.9217 11.1011 21.3748 11.4693 21.7497 11.9364C22.1243 12.4037 22.417 12.9555 22.6249 13.5797C22.8327 14.2038 22.9369 14.8626 22.9369 15.535C22.9369 16.2073 22.8327 16.8661 22.6249 17.4902Z" fill="currentColor"/>
                            <path d="M50.5127 9.61203C50.0536 8.79856 49.4099 8.17026 48.5794 7.70753C47.7504 7.24513 46.8964 7.01377 46.0267 7.01377C44.9279 7.01377 43.9237 7.20918 43.0154 7.59965C42.1071 7.99012 41.3175 8.5418 40.6489 9.54655C39.9799 10.3339 39.4711 11.2393 39.1249 12.2634C38.7786 13.2882 38.6055 14.3791 38.6055 15.5349C38.6055 16.7118 38.7786 17.8126 39.1249 18.8374C39.4711 19.8616 39.9799 20.75 40.6489 21.5374C41.3175 22.3249 42.1071 22.9544 43.0154 23.3444C43.9237 23.7348 44.9279 23.9302 46.0267 23.9302C46.8964 23.9302 47.7504 23.6988 48.5794 23.2365C49.4099 22.7737 50.0536 22.1451 50.5127 21.3318V23.5801H53.8952V7.4281H50.5127V9.61203ZM50.2006 17.4902C49.9928 18.1147 49.7 18.6672 49.3255 19.1341C48.9506 19.6011 48.4975 19.9694 47.964 20.2388C47.4304 20.5082 46.8555 20.6428 46.2217 20.6428C45.5874 20.6428 45.0226 20.5082 44.5172 20.2388C44.0119 19.9694 43.5859 19.6011 43.2407 19.1341C42.8951 18.6672 42.6327 18.1147 42.453 17.4902C42.2727 16.8661 42.1828 16.2073 42.1828 15.535C42.1828 14.8626 42.2727 14.2038 42.453 13.5797C42.6327 12.9555 42.8951 12.4037 43.2407 11.9364C43.5859 11.4694 44.0117 11.1011 44.5172 10.8317C45.0226 10.5623 45.5874 10.4277 46.2217 10.4277C46.8557 10.4277 47.4304 10.5623 47.964 10.8317C48.4975 11.1011 48.9506 11.4693 49.3255 11.9364C49.7 12.4037 49.9928 12.9555 50.2006 13.5797C50.4085 14.2038 50.5127 14.8626 50.5127 15.535C50.5127 16.2073 50.4083 16.8661 50.2006 17.4902Z" fill="currentColor"/>
                            <path d="M84 0H80.6174V23.5804H84V0Z" fill="currentColor"/>
                            <path d="M29.0156 23.5804H32.3982V11.152H38.2259V7.42823H29.0156V23.5804Z" fill="currentColor"/>
                            <path d="M67.5207 7.42822L63.2466 19.8102L58.9717 7.42822H55.5574L61.1166 23.5804H65.3766L70.935 7.42822H67.5207Z" fill="currentColor"/>
                            <path d="M78.3615 7.01423C74.2879 7.01423 70.9197 10.8232 70.9197 15.5352C70.9197 20.6987 74.181 24 78.7994 24C81.4181 24 83.0991 22.8889 85.1574 20.4632L82.8685 18.4862C82.867 18.489 81.1247 21.0126 78.5846 21.0126C75.5739 21.0126 74.3146 18.3252 74.3146 16.9233H85.5564C86.154 11.5819 82.9321 7.01423 78.3615 7.01423ZM74.3234 14.1014C74.3496 13.7984 74.7417 10.0165 78.349 10.0165C81.9559 10.0165 82.3814 13.7977 82.4073 14.1014H74.3234Z" fill="currentColor"/>
                        </svg>
                        <span class="ml-2 text-xl font-semibold text-black dark:text-white">Cloud Pricing</span>
                    </a>
                    <nav class="flex items-center space-x-6">
                        <a href="https://laravel.com/docs" target="_blank" class="text-zinc-600 dark:text-zinc-400 hover:text-black dark:hover:text-white transition-colors">
                            Documentation
                        </a>
                        <a href="https://app.laravel.cloud" target="_blank" class="rounded-md bg-[#F53003] dark:bg-[#F61500] px-4 py-2 text-white font-medium hover:bg-red-600 transition-colors">
                            Get Started
                        </a>
                    </nav>
                </div>
            </div>
        </header> --}}

        <main class="flex-1">
            @yield('content')
        </main>

        <footer class="py-8 border-t border-zinc-200 dark:border-neutral-800">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="mb-4 md:mb-0">
                        <p class="text-zinc-500 dark:text-zinc-400">
                            Not affiliate with Laravel. Built by <a href="https://x.com/abrudtkuhl" target="_blank" class="text-zinc-500 dark:text-zinc-400 hover:text-black dark:hover:text-white transition-colors">abrudtkuhl</a>
                        </p>
                    </div>
                    
                </div>
            </div>
        </footer>
    </div>
    
    @livewireScripts
</body>
</html> 