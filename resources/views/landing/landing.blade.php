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

    <main>
        <section class="p-2 space-y-4">
            <div class="">
                <img class="h-52 w-full rounded-xl" src="{{ asset('images/main_image.webp') }}"
                    alt="Descripción de la imagen">
            </div>

            <div class="flex justify-between items-center space-x-4">
                <div class="flex-1">
                    <h2 class="text-rosado text-2xl font-arista">
                        Eleva el<br>
                        potencial de tu<br>
                        <strong class="text-5xl">WhatsApp</strong>
                    </h2>
                </div>
                <div class="">
                    <img class="h-32 transform scale-x-[-1]" src="{{ asset('images/celular.webp') }}" alt="">
                </div>
            </div>
        </section>
    </main>
</body>

</html>