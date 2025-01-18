<div id="messages-body"
    x-data="{
        height: 0,
        conversationElement: null,
        currentView: 'contacts',
        init() {
            this.conversationElement = document.getElementById('allmessages');
            this.reload();
            Echo.channel('chat').listen('MessageReceived', () => {
                this.reload();
            });
        },
        scroll() {
            this.conversationElement.scrollTop = this.conversationElement.scrollHeight;
        },
        reload() {
            this.height = this.conversationElement.scrollHeight;
            document.getElementById('status_selected_lead').innerHTML = this.conversationElement.scrollTop;
            this.$nextTick(() => {
                this.conversationElement.scrollTop = this.height;
                document.getElementById('status_selected_lead').innerHTML = this.conversationElement.scrollTop;
                setTimeout(() => {
                    this.conversationElement.scrollTop = this.conversationElement.scrollHeight;
                }, 100);
            });
        },
        selectChat() {
            this.currentView = 'chat';
        },
        backToContacts() {
            this.currentView = 'contacts';
        }
    }"
    x-init="init()"
    @scrollbottom.window="$nextTick(() => reload())">

    <div class="bg-gray-100 dark:bg-gray-800">
        <div class="flex flex-1 overflow-hidden h-screen max-screen-2xl m-auto">
            <div class="p-0 lg:p-0 w-full">
                <div class="max-h-full h-full flex flex-row gap-0">
                    <!-- left navigation -->
                    @livewire('inbox-navigation')
                    <!-- left navigation end -->

                    <!-- Left side bar start -->
                    <aside class="w-full lg:w-2/6 bg-white dark:bg-gray-900 rounded-lg lg:block" :class="{'hidden lg:block': currentView === 'chat', 'block': currentView === 'contacts'}">
                        <div class="max-w-full h-full w-full flex flex-col">
                            <div class="flex p-10 justify-between">
                                <div class="text-2xl font-bold dark:text-white text-gray-900">Chats {{$viewMode}}</div>
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
                            <div class="flex p-10 justify-between">
                                <button wire:click="setViewMode('team')">Mensajes del equipo</button>
                                <button wire:click="setViewMode('user')">Mis mensajes</button>
                            </div>
                            <!-- user section start -->
                            <div class="flex-1 overflow-y-scroll scrollbar-thumb-color dark:scrollbar-thumb-color-dark">
                                <div class="w-full space-y-10">
                                    @foreach ($leads as $lead)
                                    <!-- LEAD -->
                                    <div class="cursor-pointer flex px-5" wire:click="selectLead({{ $lead->id }})" wire:key="lead-{{ $lead->id }}" @click="selectChat">
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

                    <!-- Left side bar end -->

                    <!-- right section -->
                    <section class="relative max-h-full h-full bg-white rounded-lg w-full flex-col dark:bg-gray-900 lg:flex lg:w-4/6" :class="{'hidden lg:block': currentView === 'contacts', 'block': currentView === 'chat'}">
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
                                <button @click="backToContacts" class="ml-auto text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 lg:hidden">
                                    Volver a contactos
                                </button>
                            </div>
                        </div>
                        <!-- end selected lead -->
                        @endif

                        <!-- Contenedor de todos los mensajes, incluyendo el audio y la imagen -->
                        <!-- Contenedor de todos los mensajes, incluyendo el audio y la imagen -->
                        <div class="flex-1 flex flex-col overflow-y-scroll p-5 bg-slate-50 dark:bg-slate-800 scrollbar-thumb-color dark:scrollbar-thumb-color-dark space-y-5" id="allmessages" style="height: 100%; max-height: 100%;">
                            <!-- Iterar sobre los mensajes -->
                            @foreach ($messages as $message)
                            <div class="flex {{ $message['is_outgoing'] ? 'justify-end' : 'justify-start' }} mb-3">
                                @if(!$message['is_outgoing'])
                                <!-- Avatar para los mensajes entrantes -->
                                <div class="mr-4 relative w-12 h-12 flex items-center justify-center bg-pink-400 border border-pink-400 rounded-full text-white font-bold text-lg">
                                    @if($selectedLead->name)
                                    <span>{{ $selectedLead->getInitials(2) }}</span>
                                    @else
                                    <img class="rounded-full w-full h-full" src="https://unavatar.io/sindresorhus@gmail.com" alt="Avatar">
                                    @endif
                                </div>
                                @endif
                        
                                <!-- Contenido del mensaje -->
                                <div class="py-1 px-2 text-base rounded-lg inline-block max-w-lg {{ $message['is_outgoing'] ? 'bg-indigo-800 text-white rounded-l-lg dark:bg-indigo-900' : 'bg-gray-100 text-gray-900 rounded-r-lg dark:bg-gray-800 dark:text-white' }}">
                                    <div>{{ $message['content'] }}</div>
                                    <div class="text-xs text-gray-200 mt-1">
                                        {{ $message['time'] ?? '' }} <!-- Mostrar la hora del mensaje -->
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        
                            <!-- Audio para reproducción -->
                            <div class="flex justify-end">
                                <audio id="audioPlayback" controls class="block"></audio>
                            </div>
                        
                            <!-- Marco con la imagen -->
                            <div class="flex justify-end">
                                <div id="marco" class="flex flex-col items-center bg-blue-800 w-[220px] h-[240px] rounded-[15px] p-2 hidden">
                                    <img src="" alt="" id="imagen" class="max-w-[200px] max-h-[200px] cursor-pointer rounded-[15px]">
                                    <p class="text-white text-left self-start w-full pl-2">{{ $message['time'] ?? '' }}</p>
                                </div>
                            </div>
                        </div>


                        <!-- Fin de todos los mensajes -->

                        <!-- barra que se despliega para mandar audios e imagenes -->
                        <div id="mediaContainer" class="media-container flex flex-row items-center justify-between px-6 w-full h-[80px] bg-gray-100">
                            <h2 class="text-blue-800 font-bold font-montserrat text-[25px]">Comparte tus archivos multimedia</h2>
                            <div class="buttons-container flex flex-row items-center gap-3">
                                <!-- Botón de cámara -->
                                <div id="cameraButton" class="flex flex-row items-center">
                                    <!-- Línea separadora entre camara y texto-->
                                    <div class="h-[45px] w-[1px] bg-gray-300 mx-2"></div>
                                    <div class="camera-container w-[45px] h-[45px] bg-blue-800 flex items-center justify-center rounded-full mx-3 cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-camera-fill" viewBox="0 0 16 16">
                                            <path d="M10.5 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>
                                            <path d="M2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4zm.5 2a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1m9 2.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0"/>
                                        </svg>
                                    </div>
                                    <!-- Línea separadora entre camara y microfono-->
                                    <div class="h-[45px] w-[1px] bg-gray-300"></div>
                                </div>
                                <!-- input file para seleccionar los archivos -->
                                <input type="file" id="fileInput" accept="image/*" class="hidden">

                                <!-- Botón de micrófono -->
                                <div id="microphoneButton" class="flex flex-row items-center">
                                    <div class="microphone-container w-[45px] h-[45px] bg-blue-800 flex items-center justify-center rounded-full mx-2 cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-mic-fill" viewBox="0 0 16 16">
                                            <path d="M5 3a3 3 0 0 1 6 0v5a3 3 0 0 1-6 0z"/>
                                            <path d="M3.5 6.5A.5.5 0 0 1 4 7v1a4 4 0 0 0 8 0V7a.5.5 0 0 1 1 0v1a5 5 0 0 1-4.5 4.975V15h3a.5.5 0 0 1 0 1h-7a.5.5 0 0 1 0-1h3v-2.025A5 5 0 0 1 3 8V7a.5.5 0 0 1 .5-.5"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>  
                        </div>
                        <!-- fin de la barra para mandar audios e imagenes -->

                        <!-- Barra de envío de mensaje -->
                        <div class="flex-none p-4 bg-slate-100 dark:bg-slate-800 fixed bottom-0 left-0 right-0 lg:relative lg:bottom-auto lg:left-auto lg:right-auto">
                            <div class="relative flex items-center max-w-2xl mx-auto">
                                <!-- Botón de abrir multimedia -->
                                <button id="toggleButton" class="inline-flex items-center justify-center rounded-full h-12 w-12 text-gray-500 hover:bg-gray-300 focus:outline-none">
                                   <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-paperclip" viewBox="0 0 16 16">
                                        <path d="M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0z"/>
                                    </svg>
                                </button>
                                <!-- fin de boton de abrir multimedia -->

                                <!-- Input de texto -->
                                <div x-data="{ newMessageContent: @entangle('newMessageContent'), messages: @entangle('messages') }" class="flex-1 ml-3">
                                    <input type="text"
                                        x-model="newMessageContent"
                                        @keydown.enter="if (newMessageContent.trim() !== '') { 
                                            messages.push({ content: newMessageContent, is_outgoing: true }); 
                                            $wire.sendMessage().then(() => {
                                                newMessageContent = ''; // Limpiar el input después de enviar
                                            });
                                        }"
                                        id="newMessageContent"
                                        name="newMessageContent"
                                        class="w-full h-12 focus:outline-none focus:placeholder-gray-400 text-gray-600 placeholder-gray-400 pl-4 bg-gray-100 dark:bg-gray-800 rounded-full"
                                        placeholder="Escribe tu mensaje aquí...">
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

                    <!-- right section end -->
                </div>
            </div>
        </div>
    </div>

    <!-- script para imagen -->
    <script>
        // Referencias a los elementos
        const cameraButton = document.getElementById('cameraButton');
        const fileInput = document.getElementById('fileInput');
        const image = document.getElementById('imagen');
        const marco = document.getElementById('marco')

        // Evento para abrir el input file al hacer clic en el botón de la cámara
        cameraButton.addEventListener('click', () => {
            fileInput.click();
        });

        // Evento para mostrar la imagen seleccionada
        fileInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    // Mostrar la imagen seleccionada
                    image.src = e.target.result;
                    image.classList.remove('hidden');
                    marco.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });
    </script>

    <!-- Script para enviar el audio -->
    
    <script>
        let mediaRecorder;
        let audioChunks = [];
        const microphoneButton = document.getElementById("microphoneButton");
        const audioPlayback = document.getElementById("audioPlayback");
    
        // Solicitar permisos para usar el micrófono
        navigator.mediaDevices.getUserMedia({ audio: true })
            .then((stream) => {
                // Inicializar MediaRecorder con el stream del micrófono
                mediaRecorder = new MediaRecorder(stream);
            
                // Evento que se dispara cuando hay datos disponibles
                mediaRecorder.ondataavailable = (event) => {
                    audioChunks.push(event.data);
                };
            
                // Evento que se dispara al detener la grabación
                mediaRecorder.onstop = () => {
                    // Crear un blob a partir de los datos grabados
                    const audioBlob = new Blob(audioChunks, { type: "audio/webm" });
                    audioChunks = []; // Reiniciar el arreglo para futuras grabaciones
                
                    // Crear una URL para reproducir el blob
                    const audioURL = URL.createObjectURL(audioBlob);
                    audioPlayback.src = audioURL; // Mostrar el audio en la etiqueta <audio>
                    audioPlayback.style.display = "block"; // Mostrar el reproductor
                };
            
                // Alternar grabación al hacer clic en el botón de micrófono
                let isRecording = false;
                microphoneButton.addEventListener("click", () => {
                    if (!isRecording) {
                        mediaRecorder.start();
                        microphoneButton.querySelector("svg").style.fill = "#FF0000"; // Cambiar el color del icono
                        console.log("Grabación iniciada...");
                    } else {
                        mediaRecorder.stop();
                        microphoneButton.querySelector("svg").style.fill = "#FFFFFF"; // Restaurar el color del icono
                        console.log("Grabación detenida.");
                    }
                    isRecording = !isRecording;
                });
            })
            .catch((error) => {
                console.error("Error al acceder al micrófono:", error);
                alert("No se pudo acceder al micrófono. Por favor, verifica los permisos.");
            });
    </script>

    <!-- script para mostrar y ocultar el div de contenedor de multimedia -->
    <script>
        // Selección del botón y el contenedor
        const toggleButton = document.getElementById('toggleButton');
        const mediaContainer = document.getElementById('mediaContainer');

        // Ocultar inicialmente el contenedor
        mediaContainer.style.opacity = "0"; // Inicia transparente
        mediaContainer.style.height = "0"; // Altura inicial 0
        mediaContainer.style.overflow = "hidden"; // Evita mostrar contenido al inicio
        mediaContainer.style.transition = "opacity 0.3s ease, height 0.3s ease"; // Transición suave

        // Variable para el estado del contenedor
        let isVisible = false;

        // Añadir evento de clic al botón
        toggleButton.addEventListener('click', () => {
            if (isVisible) {
                // Ocultar el contenedor con transición
                mediaContainer.style.opacity = "0";
                mediaContainer.style.height = "0"; // Altura a 0 para ocultar
            } else {
                // Mostrar el contenedor con transición
                mediaContainer.style.opacity = "1";
                mediaContainer.style.height = "80px"; // Ajusta la altura que necesita
            }
            isVisible = !isVisible; // Alternar el estado
        });
    </script>


    <!-- Script-->
    <script>
        function scroll() {
            const conversationElement = document.getElementById('allmessages');
            const height = conversationElement.scrollHeight;
            conversationElement.scrollTop = height;
        }
        scroll();
    </script>

    <style>
        .scrollbar-width::-webkit-scrollbar {
            width: 0.25rem;
            height: 0.25rem;
        }

        .scrollbar-thumb-color::-webkit-scrollbar-thumb {
            --bg-opacity: 1;
            background-color: #edf2f7;
            background-color: rgba(237, 242, 247, var(--bg-opacity));
            border-radius: 0.25rem;
        }

        .dark .dark\:scrollbal-thumb-color-dark::-webkit-scrollbar-thumb {
            --bg-opacity: 1;
            background-color: #1f2937;
            background-color: rgba(31, 41, 55, var(--bg-opacity));
            border-radius: 0.25rem;
        }
    </style>

    <script>
        if (
            localStorage["color-theme"] === "dark" ||
            (!("color-theme" in localStorage) &&
                window.matchMedia("(prefers-color-scheme: dark)").matches)
        ) {
            document.documentElement.classList.add("dark")
        } else {
            document.documentElement.classList.remove("dark")
        }
    </script>

    <script>
        var themeToggleDarkIcon = document.getElementById("theme-toggle-dark-icon");
        var themeToggleLightIcon = document.getElementById("theme-toggle-light-icon");

        // Cambiar los íconos según la configuración previa
        function updateIcons() {
            if (document.documentElement.classList.contains('dark')) {
                themeToggleDarkIcon.classList.add('hidden');
                themeToggleLightIcon.classList.remove('hidden');
            } else {
                themeToggleDarkIcon.classList.remove('hidden');
                themeToggleLightIcon.classList.add('hidden');
            }
        }

        updateIcons();

        var themeToggleBtn = document.getElementById("theme-toggle");
        themeToggleBtn.addEventListener("click", function() {
            // Alternar los íconos dentro del botón
            document.documentElement.classList.toggle('dark');
            if (document.documentElement.classList.contains('dark')) {
                localStorage.setItem('color-theme', 'dark');
            } else {
                localStorage.setItem('color-theme', 'light');
            }
            updateIcons();
        });
    </script>
</div>