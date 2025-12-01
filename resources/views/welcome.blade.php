<x-guest-layout>
    <div class="max-w-2xl mx-auto py-24 px-6 text-center">
        <h1 class="text-3xl font-semibold text-gray-900">Task Weather App</h1>
        <p class="mt-3 text-gray-600">Welcome! Sign in to manage your tasks and view the current weather.</p>

        <div class="mt-8 flex items-center justify-center gap-4">
            <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">Log in</a>
            <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-md text-sm hover:bg-gray-50">Register</a>
        </div>
        <p class="mt-10 text-sm text-gray-400">Or go to your <a class="text-blue-600 hover:underline" href="{{ route('dashboard') }}">dashboard</a> if already signed in.</p>
    </div>
</x-guest-layout>

