<div>
    <!--
        https://www.youtube.com/watch?v=ivKl89Pzq98&t=39s
        -->
    <div class="bg-gray-100 dark:bg-gray-800">
        <div class="flex flex-1 overflow-hidden h-screen max-screen-2xl m-auto">
            <div class="p-12 lg:p-20 w-full">
                <div class="max-h-full h-full flex flex-row">
                    <!-- Left side bar start -->
                    <aside class="w-full lg:w-2/6 bg-white dark:bg-gray-900 rounded-lg mr-5">
                        <div class="max-w-full h-full w-full flex flex-col">
                            <div class="flex p-10 justify-between ">
                                <div class="text-4xl font-semibold dark:text-white text-gray-900">Chat</div>
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
                                    <!-- USER -->
                                    <div class="cursor-pointer flex px-10">
                                        <div class="mr-4 relative w-12">
                                            <img class="rounded-full w-full mr-2" src="https://unavatar.io/sindresorhus@gmail.com" alt="">
                                            <div class="w-3 h-3 bg-green-500 rounded-full absolute bottom-0 right-0"></div>
                                        </div>

                                        <div class="flex flex-col flex-1">
                                            <div class="flex justify-between items-center">
                                                <div class="text-gray-800 text-base font-semibold dark:text-gray-300">James Bond</div>
                                                <div class="text-gray-700 dark:text-gray-600 text-xs">17:31</div>
                                            </div>
                                            <div class="text-gray-400 text-sm dark:text-gray-600">
                                                Como estás?
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END USER -->

                                    <!-- USER -->
                                    <div class="cursor-pointer flex px-10">
                                        <div class="mr-4 relative w-12">
                                            <img class="rounded-full w-full mr-2" src="https://unavatar.io/sindresorhus@gmail.com" alt="">
                                            <div class="w-3 h-3 bg-green-500 rounded-full absolute bottom-0 right-0"></div>
                                        </div>

                                        <div class="flex flex-col flex-1">
                                            <div class="flex justify-between items-center">
                                                <div class="text-gray-800 text-base font-semibold dark:text-gray-300">James Bond</div>
                                                <div class="text-gray-700 dark:text-gray-600 text-xs">17:31</div>
                                            </div>
                                            <div class="text-gray-400 text-sm dark:text-gray-600">
                                                Como estás?
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END USER -->
                                    <!-- USER -->
                                    <div class="cursor-pointer flex px-10">
                                        <div class="mr-4 relative w-12">
                                            <img class="rounded-full w-full mr-2" src="https://unavatar.io/sindresorhus@gmail.com" alt="">
                                            <div class="w-3 h-3 bg-green-500 rounded-full absolute bottom-0 right-0"></div>
                                        </div>

                                        <div class="flex flex-col flex-1">
                                            <div class="flex justify-between items-center">
                                                <div class="text-gray-800 text-base font-semibold dark:text-gray-300">James Bond</div>
                                                <div class="text-gray-700 dark:text-gray-600 text-xs">17:31</div>
                                            </div>
                                            <div class="text-gray-400 text-sm dark:text-gray-600">
                                                Como estás?
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END USER -->


                                </div>
                            </div>


                            <!-- USER SECTION END -->

                        </div>
                    </aside>
                    <!-- Left side bar end -->
                </div>
                <!-- user section start -->
                <div
                    class="
                        flex-1
                        overflow-y-scroll
                        scrollbar-width
                        scrollbar-thumb-color
                        dark:scrollbar-thumb-color-dark
                    ">
                    <div class="w-full space-y-10">

                    </div>
                </div>
                <!-- user section end -->
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



        <h1>Inbox</h1>
        <ul>
            @foreach ($messages as $message)
            <li>{{ $message['body'] }} ({{ $message['created_at']->diffForHumans() }})</li>
            @endforeach
        </ul>
    </div>
</div>