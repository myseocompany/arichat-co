<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Ari-Chat</title>
</head>

<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-rosado w-full h-16 flex justify-between items-center px-4">
        <div class="h-full w-16">
            <img src="{{ asset('images/ari-logo.png') }}" alt="Logo de Ari-Chat">
        </div>
        <div class="text-white h-full w-10 flex items-center">
            <button id="menu-button" class="w-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
        </div>
    </header>

    <!-- Menu lateral -->
    <div id="sidebar" class="fixed top-0 left-0 w-full h-full bg-gray-800 bg-opacity-75 text-white transform -translate-x-full transition-transform duration-300 flex items-center justify-center">
        <button id="close-button" class="absolute top-4 right-4 text-white">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <ul class="text-center">
            <li><a href="/" class="block p-4 text-2xl">Inicio</a></li>
            <li><a href="/login" class="block p-4 text-2xl">Login</a></li>
            <!-- <li><a href="#" class="block p-4 text-2xl">Servicios</a></li>
            <li><a href="#" class="block p-4 text-2xl">Contacto</a></li> -->
        </ul>
    </div>

    <main class="p-4 max-w-screen-lg mx-auto">
        <section class="space-y-6">
            <!-- Main Image -->
            <article class="rounded-xl overflow-hidden">
                <img class="h-52 w-full object-cover" src="{{ asset('images/main_image.webp') }}" alt="Descripción de la imagen">
            </article>

            <!-- Text and Image Section -->
            <article class="flex flex-col lg:flex-row justify-between items-center space-y-4 lg:space-y-0 lg:space-x-4 font-arista">
                <div class="flex-1 text-center lg:text-left">
                    <h2 class="text-rosado text-3xl md:text-4xl leading-tight">
                        Eleva el<br>
                        potencial de tu<br>
                        <strong class="text-5xl md:text-6xl">WhatsApp</strong>
                    </h2>
                </div>
                <figure class="">
                    <img class="h-32 md:h-60" src="{{ asset('images/Celular.webp') }}" alt="Imagen de un celular">
                </figure>
            </article>
        </section>

        <!-- Description and Call to Action -->
        <section class="space-y-4 text-center">
            <div class="text-gray-800 text-sm md:text-base leading-relaxed">
                <p>Optimiza tus mensajes masivos en WhatsApp con un <span class="font-bold">sistema multiagente.</span></p>
                <p>Nuestra app permite que <span class="font-bold">varios agentes gestionen y envíen mensajes simultáneamente</span>, mejorando la eficiencia y ahorrando tiempo. Ideal para <span class="font-bold">empresas y equipos que buscan mejorar su comunicación y llegar a más personas rápidamente.</span></p>
                <p>Incluye funciones avanzadas como listas personalizadas, mensajes automáticos y seguimiento en tiempo real.</p>
            </div>
            <div class="w-full flex justify-center">
                <a href="https://wa.me/+573004410097">
                    <button class="bg-rosado text-white rounded-xl px-4 py-3 text-xl">Suscríbete ahora</button>
                </a>
            </div>
        </section>

        <!-- Features Section -->
        <section class="space-y-6 text-center">
            <div>
                <h2 class="font-arista text-azul text-3xl md:text-4xl leading-tight">Potencia tu <strong class="text-4xl md:text-5xl">WhatsApp</strong></h2>
            </div>
            <div class="text-gray-800 text-sm md:text-base leading-relaxed">
                <p>Con funciones avanzadas como listas <span class="font-bold">personalizadas, mensajes automáticos y seguimiento en tiempo real</span>. Todo en una interfaz simple y fácil de usar.</p>
            </div>
            <div class="grid grid-cols-2 gap-4 font-arista">
                <div class="feature-card">
                    <div class="mini-feature">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                        </svg>
                    </div>
                    <p class="leading-none">Envío de Mensajes</p>
                </div>
                <div class="feature-card">
                    <div class="mini-feature">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25" />
                        </svg>
                    </div>
                    <p class="leading-none">Integración CRM</p>
                </div>
                <div class="feature-card">
                    <div class="mini-feature">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                        </svg>
                    </div>
                    <p class="leading-none">Chat Multi-Agente</p>
                </div>
                <div class="feature-card">
                    <div class="mini-feature">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 3.75v4.5m0-4.5h-4.5m4.5 0-6 6m3 12c-8.284 0-15-6.716-15-15V4.5A2.25 2.25 0 0 1 4.5 2.25h1.372c.516 0 .966.351 1.091.852l1.106 4.423c.11.44-.054.902-.417 1.173l-1.293.97a1.062 1.062 0 0 0-.38 1.21 12.035 12.035 0 0 0 7.143 7.143c.441.162.928-.004 1.21-.38l.97-1.293a1.125 1.125 0 0 1 1.173-.417l4.423 1.106c.5.125.852.575.852 1.091V19.5a2.25 2.25 0 0 1-2.25 2.25h-2.25Z" />
                        </svg>
                    </div>
                    <p class="leading-none">Llamada por Voz IP</p>
                </div>
            </div>
        </section>

        <!-- Planes Section -->
        <section class="text-center w-full px-5">
            <div>
                <h2 class="text-azul font-arista text-3xl md:text-4xl leading-tight">
                    Elige tu mejor <strong class="text-4xl md:text-5xl">plan</strong>
                </h2>
            </div>
            <div class="flex flex-col md:flex-row justify-around gap-12 mt-8">
                <!-- Plan Básico -->
                <div class="bg-azul rounded-lg py-6 px-8 text-center shadow-md md:w-72 text-gray-200">
                    <span class="text-xl font-bold">Básico</span>
                    <h2 class="text-4xl font-bold mt-2">$9.99<span class="text-lg">/mes</span></h2>
                    <div class="mt-4 text-sm ">
                        <ul class="space-y-2">
                            <li>1 Usuario</li>
                            <li>Difusiones</li>
                            <li>10 plantillas</li>
                            <li>5 flujos de trabajo</li>
                        </ul>
                    </div>
                    <a href="https://wa.me/+573004410097">
                        <button class="bg-white text-azul p-3 my-5 rounded-xl">Suscríbete</button>
                    </a>
                </div>

                <!-- Plan PRO -->
                <div class="bg-azul rounded-lg py-6 px-8 text-center shadow-md md:w-72 text-gray-200">
                    <span class="text-xl font-bold">PRO</span>
                    <h2 class="text-4xl font-bold mt-2">$19.99<span class="text-lg">/mes</span></h2>
                    <div class="mt-4 text-sm text-gray-200">
                        <ul class="space-y-2">
                            <li>5 Usuarios</li>
                            <li>Difusiones</li>
                            <li>30 plantillas</li>
                            <li>15 flujos de trabajo</li>
                            <li>Herramientas de grupo</li>
                        </ul>
                    </div>
                    <a href="https://wa.me/+573004410097">
                        <button class="bg-white text-azul p-3 my-5 rounded-xl">Suscríbete</button>
                    </a>
                </div>
            </div>
        </section>
    </main>

    <!-- WhatsApp Widget -->
    <div class="fixed bottom-4 right-4 z-50">
        <button id="whatsapp-button" class="block w-16 h-16 bg-green-500 rounded-full shadow-lg flex items-center justify-center">
            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.125 1.61 5.91L0 24l6.09-1.61A11.94 11.94 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm6.18 17.82c-.26.73-1.52 1.35-2.1 1.44-.56.08-1.24.11-2-.12-.46-.14-1.06-.34-1.82-.67-3.2-1.32-5.28-4.56-5.46-4.78-.18-.22-1.3-1.73-1.3-3.3 0-1.56.82-2.33 1.12-2.66.3-.33.66-.41.88-.41.22 0 .44.01.63.01.2 0 .47-.08.74.56.28.64.95 2.22 1.03 2.38.08.16.14.35.03.56-.1.21-.15.34-.3.52-.15.18-.31.4-.44.54-.15.15-.3.31-.13.6.18.3.78 1.28 1.67 2.07 1.15 1.02 2.12 1.34 2.42 1.49.3.15.47.13.64-.08.17-.22.74-.86.94-1.16.2-.3.4-.25.67-.15.28.1 1.77.84 2.08.99.3.15.5.22.57.34.08.12.08.73-.18 1.44z" />
            </svg>
        </button>
        <div id="whatsapp-form" class="hidden fixed bottom-20 right-4 bg-white p-4 rounded-lg shadow-lg w-80">
            <button id="close-whatsapp-form" class="absolute top-2 right-2 text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <form id="contact-form" action="" method="post">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700">Nombre:</label>
                    <input type="text" id="name" name="name" class="w-full px-3 py-2 border rounded-lg" required>
                </div>
                <div class="mb-4">
                    <label for="phone" class="block text-gray-700">Teléfono:</label>
                    <input type="text" id="phone" name="phone" class="w-full px-3 py-2 border rounded-lg" required>
                </div>
                <div class="mb-4">
                    <label for="message" class="block text-gray-700">Mensaje:</label>
                    <textarea id="message" name="message" class="w-full px-3 py-2 border rounded-lg" required></textarea>
                </div>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg">Enviar</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('menu-button').addEventListener('click', function() {
            var sidebar = document.getElementById('sidebar');
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
            } else {
                sidebar.classList.add('-translate-x-full');
            }
        });

        document.getElementById('close-button').addEventListener('click', function() {
            var sidebar = document.getElementById('sidebar');
            sidebar.classList.add('-translate-x-full');
        });

        document.getElementById('whatsapp-button').addEventListener('click', function() {
            var form = document.getElementById('whatsapp-form');
            form.classList.toggle('hidden');
        });

        document.getElementById('close-whatsapp-form').addEventListener('click', function() {
            var form = document.getElementById('whatsapp-form');
            form.classList.add('hidden');
        });
    </script>
</body>

</html>