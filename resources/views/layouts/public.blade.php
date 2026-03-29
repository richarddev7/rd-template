<!DOCTYPE html>
<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Solicitud Legal | LegalCRM' }}</title>

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet" />

    <!-- Tailwind Configuration -->
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#FF2D20", // Laravel red for brand identity
                        "background-light": "#F9FAFB",
                        "background-dark": "#111827",
                    },
                    fontFamily: {
                        display: ["Inter", "sans-serif"],
                    },
                    borderRadius: {
                        DEFAULT: "0.75rem",
                    },
                },
            },
        };
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .mesh-gradient {
            background-image: radial-gradient(at 0% 0%, rgba(255, 45, 32, 0.05) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(255, 45, 32, 0.05) 0px, transparent 50%);
        }
    </style>
    @livewireStyles
</head>

<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 min-h-screen transition-colors duration-300 mesh-gradient">
    <!-- Dark Mode Toggle -->
    <button aria-label="Alternar modo oscuro"
        class="fixed top-6 right-6 p-2 rounded-full bg-white dark:bg-slate-800 shadow-sm border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all focus:outline-none z-50"
        onclick="document.documentElement.classList.toggle('dark')">
        <span class="material-icons-round text-slate-600 dark:text-slate-400 block dark:hidden">dark_mode</span>
        <span class="material-icons-round text-yellow-400 hidden dark:block">light_mode</span>
    </button>

    <!-- Simplified Header -->
    <header class="flex items-center justify-center py-8">
        <div class="flex items-center gap-4 text-primary">
            <div
                class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-white dark:bg-slate-800 shadow-xl border border-slate-100 dark:border-slate-700 transition-transform hover:scale-105">
                <span class="material-icons-round text-primary text-3xl">dashboard_customize</span>
            </div>
            <h2 class="text-slate-900 dark:text-white text-2xl font-bold tracking-tight">LegalCRM</h2>
        </div>
    </header>

    <main class="max-w-[1000px] mx-auto py-6 px-6 md:px-10">
        {{ $slot }}

        <!-- Footer -->
        <footer class="mt-12 flex flex-col sm:flex-row items-center justify-between px-2 gap-4 pb-10">
            <div class="flex items-center space-x-2 text-xs font-medium text-slate-500 dark:text-slate-500">
                <span class="flex h-2 w-2 rounded-full bg-emerald-500"></span>
                <span>Todos los sistemas operativos</span>
            </div>
            <div class="flex items-center space-x-4">
                <a class="text-xs text-slate-500 dark:text-slate-500 hover:text-slate-800 dark:hover:text-slate-300"
                    href="#">Política de Privacidad</a>
                <a class="text-xs text-slate-500 dark:text-slate-500 hover:text-slate-800 dark:hover:text-slate-300"
                    href="#">Seguridad</a>
                <a class="text-xs text-slate-500 dark:text-slate-500 hover:text-slate-800 dark:hover:text-slate-300"
                    href="#">Soporte</a>
            </div>
        </footer>
    </main>

    <!-- Background Gradient Blobs -->
    <div class="fixed top-0 left-0 -z-10 w-full h-full overflow-hidden pointer-events-none opacity-40 dark:opacity-20">
        <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] rounded-full bg-primary/20 blur-[120px]"></div>
        <div class="absolute -bottom-[10%] -right-[10%] w-[40%] h-[40%] rounded-full bg-orange-400/20 blur-[120px]">
        </div>
    </div>

    @livewireScripts
</body>

</html>