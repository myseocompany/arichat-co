<nav x-data="{ openSettings: false, openTeams: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 h-screen relative">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex flex-col justify-between">
        <div>
            <!-- Logo -->
            <div class="shrink-0 flex items-center py-4">
                <a href="{{ route('dashboard') }}">
                    <x-application-mark class="block h-9 w-auto" />
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="space-y-4 mt-4">
                <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-nav-link>
            </div>
        </div>

        <!-- Dropdowns al fondo del sidebar -->
        <div class="absolute bottom-0 w-full px-2">
            <div class="flex flex-col-reverse">

                <!-- Settings Dropdown -->
                <div class="relative mb-2 w-full" x-data="{ open: false }">
                    <button @click="open = ! open" class="flex items-center text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition w-full">
                        <img class="h-8 w-8 rounded-full object-cover mr-2" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                        <span class="text-gray-700 dark:text-gray-300">{{ Auth::user()->name }}</span>
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

                <!-- Teams Dropdown -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                <div class="relative mb-2 w-full" x-data="{ open: false }">
                    <button @click="open = ! open" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150 w-full">
                        {{ Auth::user()->currentTeam->name }}

                        <svg class="ms-2 -me-0.5 h-4 w-4 ml-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
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

                        <!-- Team Management -->
                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Manage Team') }}
                        </div>

                        <a href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-900">
                            {{ __('Team Settings') }}
                        </a>

                        @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                            <a href="{{ route('teams.create') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-900">
                                {{ __('Create New Team') }}
                            </a>
                        @endcan

                        @if (Auth::user()->allTeams()->count() > 1)
                            <div class="border-t border-gray-200 dark:border-gray-600"></div>

                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Switch Teams') }}
                            </div>

                            @foreach (Auth::user()->allTeams() as $team)
                                <a href="{{ route('teams.show', $team->id) }}" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-900">
                                    {{ $team->name }}
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</nav>
