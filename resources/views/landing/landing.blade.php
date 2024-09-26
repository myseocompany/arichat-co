<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Ari-Chat</title>
</head>

<body>
    <header class="bg-rosado w-full h-16 flex justify-between items-center">
        <h1 class="text-white text-2xl">Ari-Chat</h1>
        <div class="text-white h-full w-10 flex items-center">
            <button class="w-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
        </div>

    </header>

    <main class="p-4">
        <section class="space-y-6">
            <article class="rounded-xl overflow-hidden">
                <img class="h-52 w-full object-cover" src="{{ asset('images/main_image.webp') }}" alt="Descripción de la imagen">
            </article>

            <article class="flex flex-row justify-between items-center space-x-4">
                <div class="flex-1">
                    <h2 class="text-rosado text-3xl md:text-4xl font-arista leading-tight">
                        Eleva el<br>
                        potencial de tu<br>
                        <strong class="text-5xl md:text-6xl">WhatsApp</strong>
                    </h2>
                </div>
                <figure class="flex-shrink-0">
                    <img class="h-32 md:h-44 transform scale-x-[-1]" src="{{ asset('images/celular.webp') }}" alt="Imagen de un celular">
                </figure>
            </article>


            <article>
                <div class="text-gray-800 text-xs leading-relaxed text-center">
                    <p class="">Optimiza tus mensajes masivos en WhatsApp con un <span class="font-bold">sistema multiagente.</span></p>
                    <p>Nuestra app permite que <span class="font-bold">varios agentes gestionen y envíen mensajes simultáneamente</span>, mejorando la eficiencia y ahorrando tiempo. Ideal para <span class="font-bold">empresas y equipos que buscan mejorar su comunicación y llegar a más personas rápidamente.</span></p>
                    <p>Incluye funciones avanzadas como listas personalizadas, mensajes automáticos y seguimiento en tiempo real.</p>
                    </div>

            </article>
        </section>
    </main>
</body>

</html>