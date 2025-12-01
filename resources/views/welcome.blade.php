<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Task Weather App') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-white text-gray-800 dark:bg-gray-950 dark:text-gray-100">
        <header class="border-b border-gray-200 dark:border-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <a href="/" class="font-semibold text-lg">{{ config('app.name', 'Task Weather App') }}</a>
                <nav class="flex items-center gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white">Sign in</a>
                        <a href="{{ route('register') }}" class="inline-flex items-center rounded-md bg-blue-600 px-3 py-1.5 text-sm font-semibold text-white shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Get started</a>
                    @endauth
                </nav>
            </div>
        </header>

        <main>
            <section class="relative overflow-hidden">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
                    <div class="grid lg:grid-cols-2 gap-12 items-center">
                        <div>
                            <h1 class="text-4xl sm:text-5xl font-bold tracking-tight">Tasks that stay on track with the current weather</h1>
                            <p class="mt-4 text-lg text-gray-600 dark:text-gray-300">Manage your to-dos, see local weather after login, and keep focused with a fast, responsive interface built with Laravel and Tailwind.</p>
                            <div class="mt-8 flex items-center gap-3">
                                @auth
                                    <a href="{{ route('dashboard') }}" class="inline-flex items-center rounded-md bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Go to Dashboard</a>
                                @else
                                    <a href="{{ route('register') }}" class="inline-flex items-center rounded-md bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Create an account</a>
                                    <a href="{{ route('login') }}" class="inline-flex items-center rounded-md border border-gray-300 dark:border-gray-700 px-5 py-2.5 text-sm font-semibold hover:bg-gray-50 dark:hover:bg-gray-900">Sign in</a>
                                @endauth
                            </div>
                        </div>
                        <div class="lg:justify-self-end">
                            <div class="rounded-xl border border-gray-200 dark:border-gray-800 p-6 bg-white dark:bg-gray-900 shadow-sm">
                                <dl class="grid grid-cols-2 gap-6">
                                    <div>
                                        <dt class="text-sm text-gray-500 dark:text-gray-400">Task Management</dt>
                                        <dd class="mt-1 font-semibold">CRUD with validation</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm text-gray-500 dark:text-gray-400">Weather on Login</dt>
                                        <dd class="mt-1 font-semibold">OpenWeather API</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm text-gray-500 dark:text-gray-400">Secure APIs</dt>
                                        <dd class="mt-1 font-semibold">OAuth 2.0 protected</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm text-gray-500 dark:text-gray-400">Responsive UI</dt>
                                        <dd class="mt-1 font-semibold">Tailwind CSS</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="border-t border-gray-200 dark:border-gray-800 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-sm text-gray-500 dark:text-gray-400">
                &copy; {{ date('Y') }} {{ config('app.name', 'Task Weather App') }}
            </div>
        </footer>
    </body>
    </html>

