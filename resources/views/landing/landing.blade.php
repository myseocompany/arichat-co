<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Ari-Chat</title>
</head>

<body class="">
    <!-- Header -->
    <header class="bg-rosado w-full h-16 flex justify-between items-center px-4">
        <h1 class="text-white text-2xl">Ari-Chat</h1>
        <div class="text-white h-full w-10 flex items-center">
            <button class="w-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
        </div>
    </header>

    <!-- Main Content -->
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
                <figure class="flex-shrink-1">
                    <img class="h-32 md:h-60 transform scale-x-[-1]" src="{{ asset('images/Celular.webp') }}" alt="Imagen de un celular">
                </figure>
            </article>

            <!-- Description and Call to Action -->
            <article class="space-y-4">
                <div class="text-gray-800 text-sm md:text-base leading-relaxed text-center">
                    <p>Optimiza tus mensajes masivos en WhatsApp con un <span class="font-bold">sistema multiagente.</span></p>
                    <p>Nuestra app permite que <span class="font-bold">varios agentes gestionen y envíen mensajes simultáneamente</span>, mejorando la eficiencia y ahorrando tiempo. Ideal para <span class="font-bold">empresas y equipos que buscan mejorar su comunicación y llegar a más personas rápidamente.</span></p>
                    <p>Incluye funciones avanzadas como listas personalizadas, mensajes automáticos y seguimiento en tiempo real.</p>
                </div>

                <div class="w-full flex justify-center">
                    <button class="bg-rosado text-white rounded-xl px-4 py-3 text-xl">Suscríbete ahora</button>
                </div>
            </article>

            <!-- Features Section -->
            <article class="space-y-6">
                <div>
                    <h2 class="font-arista text-azul text-center text-3xl md:text-4xl leading-tight">Potencia tu <strong class="text-4xl md:text-5xl">WhatsApp</strong></h2>
                </div>
                <div class="text-gray-800 text-sm md:text-base leading-relaxed text-center">
                    <p>Con funciones avanzadas como listas <span class="font-bold"> personalizadas, mensajes automáticos y
                            seguimiento en tiempo real</span>. Todo en una interfaz simple y fácil de usar.
                    </p>
                </div>
                <div class="grid grid-cols-2 grid-rows-2 gap-4 font-arista">
                    <div class="bg-azul feature-card p-4 text-center text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mx-auto w-6 h-6 mb-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                        </svg>
                        <p>Envío de Mensajes</p>
                    </div>
                    <div class="bg-azul feature-card p-4 text-center text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mx-auto w-6 h-6 mb-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25" />
                        </svg>
                        <p>Integración CRM</p>
                    </div>
                    <div class="bg-azul feature-card p-4 text-center text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mx-auto w-6 h-6 mb-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                        </svg>
                        <p>Chat Multi-Agente</p>
                    </div>
                    <div class="bg-azul feature-card p-4 text-center text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mx-auto w-6 h-6 mb-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 3.75v4.5m0-4.5h-4.5m4.5 0-6 6m3 12c-8.284 0-15-6.716-15-15V4.5A2.25 2.25 0 0 1 4.5 2.25h1.372c.516 0 .966.351 1.091.852l1.106 4.423c.11.44-.054.902-.417 1.173l-1.293.97a1.062 1.062 0 0 0-.38 1.21 12.035 12.035 0 0 0 7.143 7.143c.441.162.928-.004 1.21-.38l.97-1.293a1.125 1.125 0 0 1 1.173-.417l4.423 1.106c.5.125.852.575.852 1.091V19.5a2.25 2.25 0 0 1-2.25 2.25h-2.25Z" />
                        </svg>
                        <p>Llamada por Voz IP</p>
                    </div>
                </div>
            </article>

            <!-- Planes Section -->
            <article class="text-center w-full px-5">
                <div>
                    <h2 class="text-azul font-arista text-center text-3xl md:text-4xl leading-tight">
                        Elige tu mejor <strong class="text-4xl md:text-5xl">plan</strong>
                    </h2>
                </div>
                <div class="flex text-white flex-col md:flex-row  justify-around gap-12 mt-8">
                    <!-- Plan Básico -->
                    <div class="bg-azul rounded-lg py-6 px-8 text-center shadow-md md:w-72">
                        <span class="text-xl font-bold">Básico</span>
                        <h2 class="text-4xl font-bold mt-2">$9.99<span class="text-lg">/mes</span></h2>
                        <div class="mt-4 text-sm text-gray-200">
                            <ul class="space-y-2">
                                <li>1 Usuario</li>
                                <li>Difusiones</li>
                                <li>10 plantillas</li>
                                <li>5 flujos de trabajo</li>
                            </ul>
                        </div>
                        <button class="bg-white text-azul p-3 my-5 rounded-xl">Suscribete</button>
                    </div>

                    <!-- Plan PRO -->
                    <div class="bg-azul rounded-lg py-6 px-8 text-center shadow-md md:w-72">
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
                        <button class="bg-white text-azul p-3 my-5 rounded-xl">Suscribete</button>
                    </div>
                </div>
            </article>
        </section>
    </main>
</body>
</html>