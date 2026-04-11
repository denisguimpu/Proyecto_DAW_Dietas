<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            Mi Espacio Nutricional
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <section class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-200 via-cyan-200 to-blue-200 p-8 md:p-12 text-slate-900 shadow-2xl">
                <div class="absolute -top-24 -right-16 h-64 w-64 rounded-full bg-white/20 blur-2xl"></div>
                <div class="absolute -bottom-20 -left-16 h-64 w-64 rounded-full bg-sky-200/20 blur-2xl"></div>

                <div class="relative grid gap-8 lg:grid-cols-2 items-center">
                    <div class="space-y-5">
                        <p class="inline-flex items-center gap-2 rounded-full bg-white/60 px-4 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-slate-900">
                            Tu rutina diaria
                        </p>
                        <h1 class="text-3xl md:text-5xl font-black leading-tight text-slate-900">
                            Organiza tus menus y lleva el control de tu alimentacion.
                        </h1>
                        <p class="text-slate-800 text-base md:text-lg max-w-xl">
                            Este panel esta pensado para ti: un resumen rapido de lo que tienes preparado para tu semana y acceso directo a lo que mas usas.
                        </p>

                        <div class="flex flex-wrap gap-3 pt-2">
                            <a href="{{ route('menus.create') }}" class="inline-flex items-center rounded-xl bg-white px-5 py-3 font-bold text-slate-900 shadow-lg transition hover:scale-[1.02] hover:bg-sky-50">
                                Crear menu
                            </a>
                            <a href="{{ route('ingredients.index') }}" class="inline-flex items-center rounded-xl border border-slate-500 px-5 py-3 font-bold text-slate-900 transition hover:bg-white/40">
                                Gestionar ingredientes
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3 md:gap-4">
                        <div class="rounded-2xl bg-white/70 backdrop-blur-md p-4 md:p-5 border border-slate-200">
                            <p class="text-xs uppercase tracking-[0.14em] text-slate-900">Ingredientes</p>
                            <p class="mt-2 text-3xl font-black text-slate-900">{{ $stats['ingredients'] }}</p>
                            <p class="mt-1 text-xs text-slate-700">Alimentos guardados</p>
                        </div>
                        <div class="rounded-2xl bg-white/70 backdrop-blur-md p-4 md:p-5 border border-slate-200">
                            <p class="text-xs uppercase tracking-[0.14em] text-slate-900">Menus</p>
                            <p class="mt-2 text-3xl font-black text-slate-900">{{ $stats['menus'] }}</p>
                            <p class="mt-1 text-xs text-slate-700">Planificaciones listas</p>
                        </div>
                        <div class="rounded-2xl bg-white/70 backdrop-blur-md p-4 md:p-5 border border-slate-200 col-span-2">
                            <p class="text-xs uppercase tracking-[0.14em] text-slate-900">Grupos de menus</p>
                            <p class="mt-2 text-3xl font-black text-slate-900">{{ $stats['foodGroups'] }}</p>
                            <p class="mt-1 text-xs text-slate-700">Organizacion de tus bloques semanales</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="grid gap-6 md:grid-cols-1">
                <article class="rounded-2xl border border-emerald-100 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-extrabold text-slate-800">Enfoque de hoy</h3>
                    <p class="mt-3 text-sm leading-6 text-slate-700">
                        Mantener tu plan simple ayuda a cumplirlo. Define menus realistas, revisa macros y ajusta solo lo necesario.
                    </p>
                    <div class="mt-5">
                        <a href="{{ route('menus.index') }}" class="inline-flex rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-bold text-white transition hover:bg-emerald-700">
                            Ver mis menus
                        </a>
                    </div>
                </article>
            </section>
        </div>
    </div>
</x-app-layout>
