<div id="messages-body"
    x-data="{
        height:0, 
        conversationElement:document.getElementById('allmessages'),
        scroll: () => { $el.scrollTo(0, $el.scrollHeight); },
        reload: () => {
            conversationElement = document.getElementById('allmessages');
            height = conversationElement.scrollHeight;
            document.getElementById('status_selected_lead').innerHTML = conversationElement.scrollTop;
            console.log('reload height:' + height + ', scrollTop:' + conversationElement.scrollTop);
            $nextTick(()=>{
                conversationElement.scrollTop = height;
                console.log('nextTick reload height:' + height + ', scrollTop:' + conversationElement.scrollTop);
                document.getElementById('status_selected_lead').innerHTML = conversationElement.scrollTop;

                setTimeout(() => {
                    conversationElement.scrollTop = conversationElement.scrollHeight;
                    console.log('nextTick with timeout, height:', conversationElement.scrollHeight, 'scrollTop:', conversationElement.scrollTop);
                }, 100);
            });
        }
    }"
    x-init="
        reload();
        Echo.channel('chat')
            .listen('MessageReceived', (e) => {
                console.log('MessageReceived channel chat');
                reload();
            })
    "
    @scrollbottom.window="$nextTick(()=>reload());">

    <div class="bg-gray-100 dark:bg-gray-800">
        <div class="flex flex-1 overflow-hidden h-screen max-screen-2xl m-auto">
            <div class="p-0 lg:p-0 w-full">
                <div class="max-h-full h-full flex flex-row gap-0">
                    <!-- left navigation -->
                    @livewire('inbox-navigation')
                    <!-- left navigation end -->

                    <!-- Left side bar start -->
                    @livewire('inbox-lead-list',  ['leads' => $leads ])
                    <!-- Left side bar end -->

                    <!-- right section -->
                    @livewire('inbox-chat-window',  ['selectedLead' => $selectedLead , 'messages' => $messages])
                    <!-- right section end -->
                </div>
            </div>
        </div>
    </div>

    <!-- Script-->
    <script>
        function scroll() {
            conversationElement = document.getElementById('allmessages');
            height = conversationElement.scrollHeight;
            conversationElement.scrollTop = height;
            console.log('scroll height:' + height + ', scrollTop:' + conversationElement.scrollTop);
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
