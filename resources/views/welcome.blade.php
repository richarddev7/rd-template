<x-layouts.landing>
    <x-landing.header />

    <section class="pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-8">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 dark:bg-blue-900/30 text-primary dark:text-blue-400 text-sm font-medium border border-blue-100 dark:border-blue-800">
                        <span class="flex h-2 w-2 rounded-full bg-primary animate-pulse"></span>
                        Confiado por más de 2,000 empresas en todo el mundo
                    </div>
                    <h1 class="text-5xl lg:text-7xl font-bold leading-[1.1] text-slate-900 dark:text-white">
                        Gestiona tu Negocio <br />
                        <span class="text-primary italic">con Facilidad.</span>
                    </h1>
                    <p class="text-lg text-slate-600 dark:text-slate-400 max-w-lg">
                        Optimiza tu flujo de trabajo, cierra tratos más rápido y fomenta relaciones más sólidas con los
                        clientes con nuestro CRM listo para empresas construido en Laravel.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('register') }}"
                            class="px-8 py-4 bg-primary text-white font-semibold rounded-xl hover:bg-blue-700 transition-all shadow-lg shadow-primary/25 flex items-center justify-center gap-2">
                            Empieza Gratis
                            <span class="material-symbols-rounded text-sm">arrow_forward</span>
                        </a>
                        <button
                            class="px-8 py-4 bg-white dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-200 dark:border-slate-700 font-semibold rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700 transition-all flex items-center justify-center gap-2">
                            <span class="material-symbols-rounded">play_circle</span>
                            Ver Demo
                        </button>
                    </div>
                    <div class="flex items-center gap-6 pt-4 grayscale opacity-60 dark:invert">
                        <img alt="Slack" class="h-6"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuD6feLIyAtQPKyK75LvoRMuatElM-m64_DleltaxqC2Puu1F4Wn7cF_maOyiA7PEobMn84pGhQxhl58CuzxQ5mV5hreFku3pRDkZJdTDVtRTPdF5BGEWrDHMKtNivordCldk8rpb5VM7AG-NwGXFhk54Re1dzCtaAiWmiOgHRbsydrmS60VCAGN7_zGXefDWloNyKPzx4MQ5Kj_Ac6FnJ5j_WfglFF9__wIXS56RkwU-5LvD1vWcA9g3bz440MaCCObgCvv32YCy8pY" />
                        <img alt="Stripe" class="h-6"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuC9oU5LSyZsYDGjSYoy3z-kjZTOF2eukBSdYbaEy_foojre-K0XbRUwYFejahKCUUF_J_qjn_naLOMmsur4bnpb_YQIP4wydjTxDamvG0LW3uA_lAZmapC3XQgYZRAQc7tcbxuHw4xKUXWGx3-nipbkgjsjy-GtsBnnNzJBKtruuPRgBMJCSbBCZiCAgY_DcWes3LwkwRh08XTYv3F26IAmNmRtkqJTTLkQAnc95eBf0QDh6xZC4W7QjLFVd_3Pvi3tQK_Ai_1AvogE" />
                        <img alt="Shopify" class="h-6"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuDh_8Qrb2B0Dk248CvMvODjhCbbywyKKgss78WrG1NGk7-N8Mxd6RpDSSn4LuROuTHFY66pa0WFWJtrERJZ9lQyiDj-YpiONiavRCbdi0tYAYLu7EyCCZTkDjIxLVYZS8xiYBE6Q9Rfdcr_DjEoTwUFIl1rxILNRkjO3MqirumYUfe8BJGYtUpqBDwhsL7YjU1GiB_iqmbAIVTOpaZkr-Mjtipe9WCJ0eb5wQk0R_7WyKsS1YJS-nsOncOksNx6xC83fvOoxoivOTh1" />
                    </div>
                </div>
                <div class="relative">
                    <div class="absolute -top-20 -right-20 w-72 h-72 bg-primary/10 rounded-full blur-3xl"></div>
                    <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-secondary/10 rounded-full blur-3xl"></div>
                    <div
                        class="relative bg-white dark:bg-slate-900 p-2 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 transform lg:rotate-2 hover:rotate-0 transition-transform duration-700">
                        <img alt="CRM Dashboard Preview" class="rounded-xl w-full shadow-inner"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuB-YA2bMwP2P7TDc9leEkb17omu8Fq-4D7DfsrTarP5LGwM8kQhIvUxcM93MaIMF88GQTSCsR5ljLHhF88PEeDhOO7IHduV2DsJi897dXjBl9EpBWk9flmWTBiKOmMKZRvcsyUyKrH2YfM2ojOSAdJ1ZJBkya3TwGBv8ZrRSPWPpO1FKGcS6CQodQ6mA5YyeJJqPHam0XWxtfl75M3UuuYce7JTzBAjNFEhzrXkbKbvgWBv2VW071Sn6fjLCxZOn2LZ4P4ViSpOtGSY" />
                        <div
                            class="absolute -bottom-6 -right-6 bg-white dark:bg-slate-800 p-4 rounded-xl shadow-xl border border-slate-100 dark:border-slate-700 max-w-[200px] hidden sm:block">
                            <div class="flex items-center gap-3 mb-2">
                                <div
                                    class="w-8 h-8 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                                    <span class="material-symbols-rounded text-green-600 text-sm">trending_up</span>
                                </div>
                                <span class="text-xs font-bold dark:text-white">+24% Crecimiento</span>
                            </div>
                            <div class="h-1 w-full bg-slate-100 dark:bg-slate-700 rounded-full overflow-hidden">
                                <div class="h-full bg-green-500 w-3/4"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-slate-50 dark:bg-slate-900/50" id="features">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-primary font-semibold uppercase tracking-widest text-sm mb-4">Capacidades Principales
                </h2>
                <h3 class="text-3xl lg:text-4xl font-bold text-slate-900 dark:text-white mb-6">Todo lo que necesitas
                    para escalar tus ingresos</h3>
                <p class="text-lg text-slate-600 dark:text-slate-400">Nuestro conjunto de herramientas está diseñado
                    para ayudarte a organizar datos, automatizar tareas repetitivas y concentrarte en lo que realmente
                    importa: tus clientes.</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div
                    class="p-8 bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 hover:shadow-xl transition-all group">
                    <div
                        class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 text-primary rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-rounded">group</span>
                    </div>
                    <h4 class="text-xl font-bold mb-3 dark:text-white">Gestión de Clientes Potenciales</h4>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed">Centraliza todos los datos de tus
                        prospectos y rastrea las interacciones desde el primer contacto hasta el apretón de manos final.
                    </p>
                </div>
                <div
                    class="p-8 bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 hover:shadow-xl transition-all group">
                    <div
                        class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 text-purple-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-rounded">insights</span>
                    </div>
                    <h4 class="text-xl font-bold mb-3 dark:text-white">Analítica Inteligente</h4>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed">Obtén conocimientos profundos sobre tu
                        canal de ventas con herramientas de informes y pronósticos en tiempo real.</p>
                </div>
                <div
                    class="p-8 bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 hover:shadow-xl transition-all group">
                    <div
                        class="w-12 h-12 bg-orange-100 dark:bg-orange-900/30 text-orange-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-rounded">bolt</span>
                    </div>
                    <h4 class="text-xl font-bold mb-3 dark:text-white">Automatización de Flujos de Trabajo</h4>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed">Activa acciones personalizadas y
                        correos electrónicos basados en el comportamiento del usuario para mantener tu canal en
                        movimiento mientras duermes.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 overflow-hidden" id="testimonials">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="bg-primary rounded-[2.5rem] p-8 lg:p-16 flex flex-col lg:flex-row items-center gap-12 relative overflow-hidden">
                <div class="absolute top-0 right-0 opacity-10">
                    <span class="material-symbols-rounded text-[20rem]">format_quote</span>
                </div>
                <div class="flex-1 z-10">
                    <div class="flex gap-1 mb-6">
                        <span class="material-symbols-rounded text-yellow-400">star</span>
                        <span class="material-symbols-rounded text-yellow-400">star</span>
                        <span class="material-symbols-rounded text-yellow-400">star</span>
                        <span class="material-symbols-rounded text-yellow-400">star</span>
                        <span class="material-symbols-rounded text-yellow-400">star</span>
                    </div>
                    <p class="text-2xl lg:text-3xl font-medium text-white leading-relaxed mb-8">
                        "Cambiarnos a NexusCRM fue la mejor decisión para nuestro equipo de ventas. La interfaz es
                        intuitiva y el backend de Laravel proporciona la velocidad y confiabilidad que necesitamos para
                        operaciones empresariales."
                    </p>
                    <div class="flex items-center gap-4">
                        <img alt="Sarah Johnson" class="w-12 h-12 rounded-full border-2 border-white/20"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuDaZD3vaqprGUBITpMr1S7HxVg_jTY54v9Q6AeOWMPhKkpUd3sfV9sCMl59jJ_jgkB6nD_QhH7ux8XBvOlJ3tzHfM48ZmySLTnipRQcoBfZIoW6RR1Q0PMOC2wKUOavd1MVkzdAh9N5HmYcJ-sLxtEhz__vYcWYs9ezztl-VcavyM2ARj2OimcuK15CPkSVsq6nBnggsgskfDbJE8toZ5FkKosUnjjrulEgluHCTmxOdsiJ7sq8iNG_tN3zNWEKOobg2xrLRQUA37mg" />
                        <div>
                            <div class="text-white font-bold">Alex Thompson</div>
                            <div class="text-blue-200 text-sm">CTO en TechFlow Systems</div>
                        </div>
                    </div>
                </div>
                <div class="flex-1 hidden lg:block z-10">
                    <img alt="Team collaborating" class="rounded-2xl shadow-2xl rotate-2"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuBy-8rz1D91DCMElOScP81Yuq8ty2CNBMs3scSJ8qCmjtEl6mj4YAfkfitlzsYnOTMLyBkm0GNSYAEUvYr6Bu2IU2DRsbqfgUwU6gQbFvraF3jeOmUUwF0pcBKtNaph_5X3hxEjUm0l2Uhyaj4fjmjgmMr_Qmv7L4G_TILNCqUhqYys16Xb61lMNRsBsUBMmiUFX7Wqt6QxC2rKi1-W_BanbnjTPwgd9wfpeL2EjoHlJDBWuySp3DzblRei87vNwLUC0-hk-JMZsGxN" />
                </div>
            </div>
        </div>
    </section>

    <section class="py-20">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-3xl lg:text-5xl font-bold mb-6 dark:text-white">¿Listo para elevar tu negocio?</h2>
            <p class="text-lg text-slate-600 dark:text-slate-400 mb-10">Únete a miles de empresas que crecen con nuestra
                plataforma. Comienza tu prueba gratuita de 14 días hoy. No se requiere tarjeta de crédito.</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('register') }}"
                    class="px-10 py-4 bg-primary text-white font-bold rounded-xl hover:bg-blue-700 shadow-xl shadow-primary/25 transition-all">Empieza
                    Gratis</a>
                <button
                    class="px-10 py-4 bg-transparent border-2 border-slate-200 dark:border-slate-800 dark:text-white font-bold rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">Contactar
                    Ventas</button>
            </div>
        </div>
    </section>

    <x-landing.footer />
</x-layouts.landing>