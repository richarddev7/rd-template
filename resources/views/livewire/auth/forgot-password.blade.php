<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>{{ __('Forgot Password') }} - Modern CRM</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet" />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body
    class="bg-[#F9FAFB] dark:bg-[#111827] min-h-screen flex flex-col items-center justify-center p-6 transition-colors duration-300">

    <!-- Dark Mode Toggle -->
    <button
        class="fixed top-6 right-6 p-2 rounded-full bg-white dark:bg-gray-800 shadow-md text-gray-600 dark:text-gray-300 hover:text-[#FF2D20] transition-all"
        onclick="document.documentElement.classList.toggle('dark')">
        <span class="material-icons-outlined">dark_mode</span>
    </button>

    <div class="w-full max-w-md">
        <!-- Header -->
        <div class="flex flex-col items-center mb-10">
            <div
                class="w-12 h-12 bg-[#FF2D20] flex items-center justify-center rounded-xl mb-4 shadow-lg shadow-[#FF2D20]/20">
                <span class="material-icons-outlined text-white text-3xl">shield</span>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Modern CRM</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-2">{{ __('Secure access to your dashboard') }}</p>
        </div>

        <!-- Main Card -->
        <div
            class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl shadow-xl p-8 transition-colors duration-300">
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">{{ __('Forgot Password?') }}</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                    {{ __('No worries! Enter the email address associated with your account and we\'ll send you a link to reset your password.') }}
                </p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div
                    class="mb-4 p-4 rounded-xl bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400 text-sm font-medium">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="email">
                        {{ __('Email Address') }}
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <span class="material-icons-outlined text-xl">mail</span>
                        </span>
                        <input
                            class="block w-full pl-10 pr-3 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#FF2D20] focus:border-transparent transition-all"
                            id="email" name="email" value="{{ old('email') }}" placeholder="name@company.com" required
                            autofocus type="email" />
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-[#FF2D20] dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <button
                    class="w-full flex items-center justify-center py-3 px-4 rounded-xl text-sm font-semibold text-white bg-[#FF2D20] hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#FF2D20] transition-all shadow-lg shadow-[#FF2D20]/20"
                    type="submit">
                    {{ __('Send Reset Link') }}
                    <span class="material-icons-outlined ml-2 text-lg">arrow_forward</span>
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-800 text-center">
                <a class="inline-flex items-center text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-[#FF2D20] dark:hover:text-[#FF2D20] transition-colors"
                    href="{{ route('login') }}">
                    <span class="material-icons-outlined text-lg mr-2">arrow_back</span>
                    {{ __('Back to Login') }}
                </a>
            </div>
        </div>

        <!-- Decorative Elements -->
        <div class="mt-12 opacity-50 dark:opacity-20 flex justify-center overflow-hidden pointer-events-none">
            <svg fill="none" height="100" viewBox="0 0 400 100" width="400" xmlns="http://www.w3.org/2000/svg">
                <rect fill="#FF2D20" fill-opacity="0.8" height="20" width="80" x="0" y="20"></rect>
                <rect fill="#FBBF24" fill-opacity="0.6" height="10" width="120" x="20" y="45"></rect>
                <rect fill="#111827" fill-opacity="0.1" height="40" width="60" x="100" y="10"></rect>
                <path d="M150 60L200 10L250 60" stroke="#FF2D20" stroke-width="2"></path>
                <circle cx="300" cy="40" r="30" stroke="#FBBF24" stroke-width="1"></circle>
                <rect fill="#FF2D20" fill-opacity="0.05" height="40" width="40" x="280" y="20"></rect>
            </svg>
        </div>

        <footer class="mt-12 text-center">
            <p class="text-xs text-gray-400 dark:text-gray-600">
                © {{ date('Y') }} Modern CRM. All rights reserved. <br />
                Powered by <span class="text-[#FF2D20] font-medium">Laravel</span> &amp; <span
                    class="text-[#FF2D20] font-medium">Tailwind CSS</span>.
            </p>
        </footer>
    </div>

</body>

</html>