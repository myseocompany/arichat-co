<div>
    <!--
        https://www.youtube.com/watch?v=ivKl89Pzq98&t=39s
        -->
    <div class="bg-gray-100 dark:bg-gray-800">
        <div class="flex flex-1 overflow-hidden h-screen max-screen-2xl m-auto">
            <div class="p-0 lg:p-0 w-full">
                <div class="max-h-full h-full flex flex-row">
                    <!-- Left side bar start -->
                    <aside class="w-full lg:w-2/6 bg-white dark:bg-gray-900 rounded-lg mr-5">
                        <div class="max-w-full h-full w-full flex flex-col">
                            <div class="flex p-10 justify-between ">
                                <div class="text-4xl font-semibold dark:text-white text-gray-900">Chat</div>
                                <div>{{$selectedLeadId}}</div>
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
                                    <!-- USER -->
                                    <div class="cursor-pointer flex px-10" wire:click="selectLead({{ $lead->id }})">
                                        <div class="mr-4 relative w-12">
                                            <img class="rounded-full w-full mr-2" src="https://unavatar.io/sindresorhus@gmail.com" alt="{{ $lead->name }}">
                                            <div class="w-3 h-3 bg-green-500 rounded-full absolute bottom-0 right-0"></div>
                                        </div>
                                        <div class="flex flex-col flex-1">
                                            <div class="flex justify-between items-center">
                                                <div class="text-gray-800 text-base font-semibold dark:text-gray-300">{{ $lead->name }}</div>
                                                <div class="text-gray-700 dark:text-gray-600 text-xs">{{ $lead->created_at->format('H:i') }}</div>
                                            </div>
                                            <div class="text-gray-400 text-sm dark:text-gray-600">
                                                Como estás?
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END USER -->
                                    @endforeach

                                </div>
                            </div>
                            <!-- user section end -->
                        </div>
                    </aside>
                    <!-- Left side bar end -->


                    <!-- right section -->
                    <section class="relative max-h-full h-full bg-white rounded-lg w-full flex-col dark:bg-gray-900 lg:flex hidden">
                        <div id="allmessages" class="flex-1 overflow-y-scroll p-5 scrollbar-thumb-color dark:scrollbar-thumb-color-dark scrollbar-widht space-y-5">

                            <!-- Message section -->
                            @foreach ($messages as $message)

                            <div class="flex {{ $message->is_outgoing ? 'justify-end' : 'justify-start' }}">
                                @if(!$message->is_outgoing)
                                <!-- Avatar for incoming messages -->
                                <div class="w-14 mr-5">
                                    <img class="rounded-full w-full mr-2" src="https://unavatar.io/sindresorhus@gmail.com" alt="Avatar of ">
                                </div>
                                @endif
                                <div class="p-5 text-base rounded-lg inline-block max-w-xl
                   {{ $message->is_outgoing ? 'bg-indigo-800 text-white rounded-l-lg dark:bg-indigo-900' : 'bg-gray-100 text-gray-900 rounded-r-lg dark:bg-gray-800 dark:text-white' }}">
                                    {{ $message->content }}
                                </div>
                            </div>
                            @endforeach

                            <div
                                x-data="{
                            messages: [],

                            broadcastMessage () {
                                fetch(`/broadcast`, { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' } })
                            }
                        }"
                                x-init="
                            Echo.channel('global')
                                .listen('.Message', (e) => {
                                    messages.push(e.body)
                                })
                        ">
                                <div>
                                    <button x-on:click="broadcastMessage">Broadcast a message</button>

                                    <div class="mt-6" x-show="messages.length">
                                        <template x-for="message in messages">
                                            <div x-text="message"></div>
                                        </template>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <!-- ALL MESSAGES -->
                        <div class="flex-none p-5">


                            <div class="">
                                <div class="relative flex">
                                    <span class="absolute inset-y-0 flex items-center">
                                        <button class="inline-flex items-center justify-center rounded-full h-12 w-12 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none " type="button">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 15.182a4.5 4.5 0 0 1-6.364 0M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Z" />
                                            </svg>
                                        </button>
                                    </span>

                                    <input type="text" class="w-full focus:outline-none focus:placeholder-gray-400 text-gray-600 placeholder-gray-400 pl-12 bg-gray-100 dark:bg-gray-800 rounded-full py-3 pr-5">

                                    <div class="ml-5">
                                        <button class="inline-flex items-center justify-center rounded-full h-12 w-12 transition duration-500 ease-in-out text-white bg-indigo-800 hover:bg-indigo-600 focus:outline-none ">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                                            </svg>

                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </section>
                    <!-- right section end -->
                </div>

            </div>
        </div>
        <!-- Script-->
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
            if (
                localStorage.getItem("color-theme") === "dark" ||
                (!("color-theme" in localStorage) &&
                    window.matchMedia("(prefers-color-scheme: dark)").matches)
            ) {
                themeToggleLightIcon.classList.remove("hidden");
            } else {
                themeToggleDarkIcon.classList.remove("hidden");
            }
            var themeToggleBtn = document.getElementById("theme-toggle");
            themeToggleBtn.addEventListener("click", function() {
                // Alternar los íconos dentro del botón
                themeToggleDarkIcon.classList.toggle("hidden");
                themeToggleLightIcon.classList.toggle("hidden");
                console.log(document.documentElement.classList);
                // Si está configurado en el almacenamiento local
                if (localStorage.getItem("color-theme")) {
                    if (localStorage.getItem("color-theme") === "light") {
                        document.documentElement.classList.add("dark");
                        localStorage.setItem("color-theme", "dark");
                    } else {
                        document.documentElement.classList.remove("dark");
                        localStorage.setItem("color-theme", "light");
                    }
                } else {
                    if (document.documentElement.classList.contains("dark")) {
                        document.documentElement.classList.remove("dark");
                        localStorage.setItem("color-theme", "light");
                    } else {
                        document.documentElement.classList.add("dark");
                        localStorage.setItem("color-theme", "dark");
                    }
                }
            });
        </script>

    </div>
</div>