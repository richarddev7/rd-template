<nav class="fixed top-0 w-full z-50 glass-effect border-b border-slate-200 dark:border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center text-white font-bold">C</div>
                <span class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">Nexus<span
                        class="text-primary">CRM</span></span>
            </div>
            <div class="hidden md:flex items-center space-x-8">
                <a class="text-sm font-medium text-slate-600 hover:text-primary dark:text-slate-300 dark:hover:text-white transition-colors"
                    href="#features">Características</a>
                <a class="text-sm font-medium text-slate-600 hover:text-primary dark:text-slate-300 dark:hover:text-white transition-colors"
                    href="#testimonials">Casos de Éxito</a>
                <a class="text-sm font-medium text-slate-600 hover:text-primary dark:text-slate-300 dark:hover:text-white transition-colors"
                    href="#pricing">Precios</a>
            </div>
            <div class="flex items-center gap-4">
                <button
                    class="p-2 rounded-lg text-slate-500 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800"
                    id="theme-toggle">
                    <span class="material-symbols-rounded block dark:hidden">dark_mode</span>
                    <span class="material-symbols-rounded hidden dark:block">light_mode</span>
                </button>
                @auth
                    <a class="text-sm font-medium text-slate-700 dark:text-slate-200 hover:text-primary transition-colors"
                        href="{{ route('dashboard') }}">Panel de Control</a>
                @else
                    <a class="text-sm font-medium text-slate-700 dark:text-slate-200 hover:text-primary transition-colors"
                        href="{{ route('login') }}">Iniciar Sesión</a>
                    @if (Route::has('register'))
                        <a class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-primary rounded-lg hover:bg-blue-700 transition-all shadow-sm shadow-primary/20"
                            href="{{ route('register') }}">Registrarse</a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</nav>