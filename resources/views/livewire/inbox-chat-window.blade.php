    <section class="relative max-h-full h-full bg-white rounded-lg w-full flex-col dark:bg-gray-900 lg:flex hidden">
        @if($selectedLead)
        <!-- head selected lead -->
        <div class="cursor-pointer px-10 bg-slate-100 dark:bg-slate-800">
            <div class="m-2 flex">
                <div class="mr-4 relative w-12 h-12 flex items-center justify-center bg-pink-400 border border-pink-400 rounded-full text-white font-bold text-lg">
                    @if($selectedLead->name)
                    <!-- Mostramos las iniciales del nombre con fondo rosado y letras blancas -->
                    <span>{{$selectedLead->getInitials(2)}}</span>
                    @else
                    <!-- Fallback para mostrar un avatar por defecto si no hay nombre -->
                    <img class="rounded-full w-full h-full" src="https://unavatar.io/sindresorhus@gmail.com" alt="Avatar">
                    @endif
                </div>
                <div class="flex flex-col flex-1">
                    <div class="flex justify-between items-center">
                        <div class="text-gray-800 text-base font-semibold dark:text-gray-300">@if($selectedLead){{ $selectedLead->name }} @endif</div>
                        <div class="text-gray-700 dark:text-gray-600 text-xs">@if($selectedLead){{ $selectedLead->created_at->format('H:i') }} @endif</div>
                    </div>
                    <div class="text-gray-400 text-sm dark:text-gray-600" id="status_selected_lead" x-text="height">
                        --
                    </div>
                </div>
            </div>
        </div>
        <!-- end selected lead -->
        @endif

        <!-- Contenedor de todos los mensajes -->
        <div class="flex-1 overflow-y-scroll p-5 bg-slate-50 dark:bg-slate-800 scrollbar-thumb-color dark:scrollbar-thumb-color-dark space-y-5" id="allmessages">
            <!-- Iterar sobre los mensajes -->
            @foreach ($messages as $message)
            <div class="flex {{ $message['is_outgoing'] ? 'justify-end' : 'justify-start' }}">
                @if(!$message['is_outgoing'])
                <!-- Avatar para los mensajes entrantes -->
                <div class="mr-4 relative w-12 h-12 flex items-center justify-center bg-pink-400 border border-pink-400 rounded-full text-white font-bold text-lg">
                    @if($selectedLead->name)
                    <!-- Mostramos las iniciales del nombre con fondo rosado y letras blancas -->
                    <span>{{ $selectedLead->getInitials(2) }}</span>
                    @else
                    <!-- Fallback para mostrar un avatar por defecto si no hay nombre -->
                    <img class="rounded-full w-full h-full" src="https://unavatar.io/sindresorhus@gmail.com" alt="Avatar">
                    @endif
                </div>
                @endif
                <div class="p-4 text-base rounded-lg inline-block max-w-lg {{ $message['is_outgoing'] ? 'bg-indigo-800 text-white rounded-l-lg dark:bg-indigo-900' : 'bg-gray-100 text-gray-900 rounded-r-lg dark:bg-gray-800 dark:text-white' }}">
                    {{ $message['content'] }}
                </div>
            </div>
            @endforeach
        </div>
        <!-- Fin de todos los mensajes -->

        <!-- Barra de envío de mensaje -->
        <div class="flex-none p-4 bg-slate-100 dark:bg-slate-800">
            <div class="relative flex items-center">
                <!-- Botón de ícono (opcional) -->
                <button class="inline-flex items-center justify-center rounded-full h-12 w-12 text-gray-500 hover:bg-gray-300 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 15.182a4.5 4.5 0 0 1-6.364 0M21 12a9 9 0 1 1-18 0 9 9 0 0 1-18 0ZM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Z" />
                    </svg>
                </button>

                <!-- Input de texto -->
                <div x-data="{ newMessageContent: @entangle('newMessageContent'), messages: @entangle('messages') }" class="flex-1 ml-3">
                    <input type="text"
                        x-model="newMessageContent"
                        @keydown.enter="if (newMessageContent.trim() !== '') { 
                        // Evitar duplicación: agregar mensaje solo si no está ya en la lista
                        messages.push({ content: newMessageContent, is_outgoing: true }); 
                        $wire.sendMessage().then(() => {
                            // Si ya está en la lista, evitar agregarlo otra vez cuando venga del servidor
                            newMessageContent = ''; // Limpiar el input después de enviar
                        });
                   }"
                        id="newMessageContent"
                        name="newMessageContent"
                        class="w-full h-12 focus:outline-none focus:placeholder-gray-400 text-gray-600 placeholder-gray-400 pl-4 bg-gray-100 dark:bg-gray-800 rounded-full"
                        placeholder="Type your message here...">
                </div>

                <!-- Botón para enviar -->
                <div class="ml-4">
                    <button wire:click="sendMessage" class="inline-flex items-center justify-center rounded-full h-12 w-12 bg-indigo-800 text-white hover:bg-indigo-600 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.125A59.769 59.769 0 0 1 21.485 12a59.768 59.768 0 0 1-18.215 8.875L5.999 12Zm0 0h7.5" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <!-- Fin de la barra de envío de mensaje -->
    </section>
