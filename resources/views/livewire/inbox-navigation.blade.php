<div>
    <div class="bg-black w-auto h-full">
        <nav x-data="{ openSettings: false, openTeams: false }" class="bg-slate-100 dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 h-screen relative">
            <!-- Primary Navigation Menu -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex flex-col justify-between items-center">
                <div>
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center py-4">
                        <a href="{{ route('dashboard') }}">
                            <x-application-mark class="block h-9 w-auto" />
                        </a>
                    </div>

                    <!-- Navigation Links -->
                    <!-- Leads Prioritarios -->
                    <div class="space-y-4 mt-4 relative group">
                        <a href="#" wire:click.prevent="$emit('loadAllConversations')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-gray-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                            </svg>
                        </a>
                        <!-- Tooltip -->
                        <div class="absolute top-0 left-full ml-2 transform -translate-y-1/2 bg-gray-800 text-white text-xs rounded py-1 px-3 whitespace-nowrap shadow-lg z-10 hidden group-hover:block">
                            Conversaciones
                        </div>
                    </div>

                    <a href="#" wire:click.prevent="$emit('testEvent')">
                        Emit Test Event
                    </a>



                    <!-- Leads Prioritarios -->
                    <div class="space-y-4 mt-4 relative group">
                        <!-- Ícono -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                        </svg>

                        <!-- Tooltip  derecha -->
                        <div class="absolute top-0 left-full ml-2 transform -translate-y-1/2 bg-gray-800 text-white text-xs rounded py-1 px-3 whitespace-nowrap shadow-lg z-10 hidden group-hover:block">
                            Leads Prioritarios
                        </div>
                    </div>



                    <!-- Seguimientos Pendientes -->
                    <div class="space-y-4 mt-4 relative group">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-gray-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                        </svg>
                        <!-- Tooltip  derecha -->
                        <div class="absolute top-0 left-full ml-2 transform -translate-y-1/2 bg-gray-800 text-white text-xs rounded py-1 px-3 whitespace-nowrap shadow-lg z-10 hidden group-hover:block">
                            Seguimientos Pendientes
                        </div>
                    </div>

                    <!-- Productos más vendidos / precios -->
                    <div class="space-y-4 mt-4 relative group">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-gray-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                        </svg>
                        <!-- Tooltip  derecha -->
                        <div class="absolute top-0 left-full ml-2 transform -translate-y-1/2 bg-gray-800 text-white text-xs rounded py-1 px-3 whitespace-nowrap shadow-lg z-10 hidden group-hover:block">
                            Productos
                        </div>
                    </div>

                    <!-- Reportes -->
                    <div class="space-y-4 mt-4 relative group">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-gray-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                        </svg>
                        <!-- Tooltip  derecha -->
                        <div class="absolute top-0 left-full ml-2 transform -translate-y-1/2 bg-gray-800 text-white text-xs rounded py-1 px-3 whitespace-nowrap shadow-lg z-10 hidden group-hover:block">
                            Reportes
                        </div>

                    </div>

                    <div class="space-y-4 mt-4 relative group">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-gray-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                        </svg>
                        <!-- Tooltip  derecha -->
                        <div class="absolute top-0 left-full ml-2 transform -translate-y-1/2 bg-gray-800 text-white text-xs rounded py-1 px-3 whitespace-nowrap shadow-lg z-10 hidden group-hover:block">
                            Nuevo mensaje
                        </div>

                    </div>


                    <div class="space-y-4 mt-4 relative group">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-gray-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        <!-- Tooltip  derecha -->
                        <div class="absolute top-0 left-full ml-2 transform -translate-y-1/2 bg-gray-800 text-white text-xs rounded py-1 px-3 whitespace-nowrap shadow-lg z-10 hidden group-hover:block">
                            Configuración
                        </div>


                    </div>
                </div>

                <!-- Settings Dropdown -->
                <div class="relative mb-2 w-full" x-data="{ open: false }">
                    <button @click="open = ! open" class="flex items-center text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition w-full">
                        <img class="h-8 w-8 rounded-full object-cover mr-2" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                        <span class="text-gray-700 dark:text-gray-300"></span>
                        <svg class="ms-2 -me-0.5 h-4 w-4 ml-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>



                    <div x-show="open"
                        @click.away="open = false"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-95"
                        class="absolute bottom-10 left-0 z-50 w-full max-w-full py-2 bg-white dark:bg-gray-800 shadow-lg rounded-lg">

                        <!-- Account Management -->
                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Manage Account') }}
                        </div>

                        <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-900">
                            {{ __('Profile') }}
                        </a>

                        @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                        <a href="{{ route('api-tokens.index') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-900">
                            {{ __('API Tokens') }}
                        </a>
                        @endif

                        <div class="border-t border-gray-200 dark:border-gray-600"></div>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}" x-data>
                            @csrf
                            <a href="{{ route('logout') }}" @click.prevent="$root.submit();" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-900">
                                {{ __('Log Out') }}
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</div>