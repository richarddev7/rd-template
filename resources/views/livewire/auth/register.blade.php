<!DOCTYPE html>
<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>CRM Registro | Crear Cuenta</title>
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#FF2D20", // Classic Laravel red for brand identity
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
</head>

<body
    class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 min-h-screen flex items-center justify-center p-4 transition-colors duration-300 mesh-gradient">
    <button aria-label="Alternar modo oscuro"
        class="fixed top-6 right-6 p-2 rounded-full bg-white dark:bg-slate-800 shadow-sm border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all focus:outline-none"
        onclick="document.documentElement.classList.toggle('dark')">
        <span class="material-icons-round text-slate-600 dark:text-slate-400 block dark:hidden">dark_mode</span>
        <span class="material-icons-round text-yellow-400 hidden dark:block">light_mode</span>
    </button>
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div
                class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white dark:bg-slate-800 shadow-xl border border-slate-100 dark:border-slate-700 mb-4 transition-transform hover:scale-105">
                <span class="material-icons-round text-primary text-4xl">person_add</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Crear una cuenta</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-2">Ingresa tus datos para comenzar</p>
        </div>
        <div
            class="bg-white dark:bg-slate-800/50 dark:backdrop-blur-xl rounded-3xl shadow-2xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-slate-700/50 overflow-hidden">
            <div class="p-8 md:p-10">
                <form action="{{ route('register.store') }}" class="space-y-6" method="POST">
                    @csrf

                    <!-- Name -->
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300 ml-1" for="name">Nombre
                            Completo</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span
                                    class="material-icons-round text-slate-400 group-focus-within:text-primary transition-colors text-xl">badge</span>
                            </div>
                            <input
                                class="block w-full pl-11 pr-4 py-3 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none @error('name') border-red-500 ring-red-500/20 @enderror"
                                id="name" name="name" value="{{ old('name') }}" placeholder="Juan Pérez" required=""
                                type="text" autofocus autocomplete="name" />
                        </div>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300 ml-1" for="email">Correo
                            electrónico</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span
                                    class="material-icons-round text-slate-400 group-focus-within:text-primary transition-colors text-xl">mail_outline</span>
                            </div>
                            <input
                                class="block w-full pl-11 pr-4 py-3 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none @error('email') border-red-500 ring-red-500/20 @enderror"
                                id="email" name="email" value="{{ old('email') }}" placeholder="nombre@empresa.com"
                                required="" type="email" autocomplete="username" />
                        </div>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300 ml-1"
                            for="password">Contraseña</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span
                                    class="material-icons-round text-slate-400 group-focus-within:text-primary transition-colors text-xl">lock_open</span>
                            </div>
                            <input
                                class="block w-full pl-11 pr-4 py-3 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none @error('password') border-red-500 ring-red-500/20 @enderror"
                                id="password" name="password" placeholder="••••••••" required="" type="password"
                                autocomplete="new-password" />
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300 ml-1"
                            for="password_confirmation">Confirmar Contraseña</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span
                                    class="material-icons-round text-slate-400 group-focus-within:text-primary transition-colors text-xl">lock_outline</span>
                            </div>
                            <input
                                class="block w-full pl-11 pr-4 py-3 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none"
                                id="password_confirmation" name="password_confirmation" placeholder="••••••••"
                                required="" type="password" autocomplete="new-password" />
                        </div>
                    </div>

                    <button
                        class="w-full flex items-center justify-center px-6 py-3.5 border border-transparent text-base font-bold rounded-2xl text-white bg-primary hover:bg-red-600 focus:outline-none focus:ring-4 focus:ring-primary/30 active:scale-[0.98] transition-all shadow-lg shadow-red-500/25"
                        type="submit">
                        Crear cuenta
                    </button>
                </form>
                <div class="mt-8 pt-8 border-t border-slate-100 dark:border-slate-700 text-center">
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        ¿Ya tienes una cuenta?
                        <a class="font-semibold text-primary hover:text-red-600 transition-colors"
                            href="{{ route('login') }}">Iniciar Sesión</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="mt-8 flex flex-col sm:flex-row items-center justify-between px-2 gap-4">
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
        </div>
    </div>
    <div class="fixed top-0 left-0 -z-10 w-full h-full overflow-hidden pointer-events-none opacity-40 dark:opacity-20">
        <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] rounded-full bg-primary/20 blur-[120px]"></div>
        <div class="absolute -bottom-[10%] -right-[10%] w-[40%] h-[40%] rounded-full bg-orange-400/20 blur-[120px]">
        </div>
    </div>
</body>

</html>