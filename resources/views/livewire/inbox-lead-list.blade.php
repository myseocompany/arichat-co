    <aside class="w-full lg:w-2/6 bg-white dark:bg-gray-900 rounded-lg">
        <div class="max-w-full h-full w-full flex flex-col">
            <div class="flex p-10 justify-between">
                <div class="text-2xl font-bold dark:text-white text-gray-900">Chats</div>
                <!-- switcher start -->
                <div>
                    <button id="theme-toggle" type="button" class="text-gray-500 text-sm p-2.5">
                        <svg id="theme-toggle-dark-icon" class="w-5 h-5 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
                        </svg>
                        <svg id="theme-toggle-light-icon" class="w-5 h-5 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2m0 14v2m8.66-8.66h-2M4.34 12H2m15.66 4.34l-1.42 1.42M6.76 6.76l-1.42-1.42m12.02 12.02l-1.42-1.42M6.76 17.24l-1.42 1.42M12 8a4 4 0 100 8 4 4 0 000-8z" />
                        </svg>
                    </button>
                </div>
                <!-- switcher end -->
            </div>
            <!-- user section start -->
            <div class="flex-1 overflow-y-scroll scrollbar-thumb-color dark:scrollbar-thumb-color-dark">
                <div class="w-full space-y-10">
                    @foreach ($leads as $lead)
                    <!-- LEAD -->
                    <div class="cursor-pointer flex px-5" wire:click="selectLead({{ $lead->id }})" wire:key="lead-{{ $lead->id }}">
                        <div class="mr-4 relative w-12 h-12 flex items-center justify-center bg-pink-400 border border-pink-400 rounded-full text-white font-bold text-lg">
                            @if($lead->name)
                            <!-- Mostramos las iniciales del nombre con fondo rosado y letras blancas -->
                            <span>{{ $lead->getInitials(2) }}</span>
                            @else
                            <!-- Fallback para mostrar un avatar por defecto si no hay nombre -->
                            <img class="rounded-full w-full h-full" src="https://unavatar.io/sindresorhus@gmail.com" alt="Avatar">
                            @endif
                            @if($lead->lastMessage && $lead->lastMessage->is_outgoing == 0)
                            <!-- Mostrar indicador de mensaje entrante -->
                            <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full"></span>
                            @else
                            <!-- Mostrar indicador de mensaje saliente -->
                            <span class="absolute bottom-0 right-0 w-3 h-3 bg-gray-500 rounded-full"></span>
                            @endif
                        </div>
                        <div class="flex flex-col flex-1">
                            <div class="flex justify-between items-center">
                                <div class="text-gray-800 text-base font-semibold dark:text-gray-300">{{ $lead->name }}</div>
                                <div class="text-gray-700 dark:text-gray-600 text-xs">
                                    @if($lead->lastMessage)
                                        {{ $lead->lastMessage->created_at->format('h:i a') }}
                                    @endif
                                </div>
                            </div>
                            <div class="text-gray-400 text-sm dark:text-gray-600">
                                @if($lead->lastMessage)
                                    {{ $lead->lastMessage->content }}
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- END LEAD -->
                    @endforeach
                </div>
            </div>
            <!-- user section end -->
        </div>
    </aside>
