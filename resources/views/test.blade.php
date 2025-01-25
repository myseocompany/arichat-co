<x-app-layout>
    <div style="display: flex; justify-content: center; align-items: center; height: 100vh; flex-direction: column;">
        <h1 style="margin-bottom: 20px; text-align: center; font-size: 24px; font-weight: bold;">
            Simulación de envío de mensajes
        </h1>

        <form id="myForm" style="width: 300px; text-align: center;">
            <div style="margin-bottom: 10px;">
                <label for="id">ID:</label><br>
                <input type="text" name="id" id="id" value="123" style="width: 100%; padding: 8px;">
            </div>

            <div style="margin-bottom: 10px;">
                <label for="type">Tipo:</label><br>
                <input type="text" name="type" id="type" value="text" style="width: 100%; padding: 8px;">
            </div>

            <div style="margin-bottom: 10px;">
                <label for="user">Usuario:</label><br>
                <input type="text" name="user" id="user" value="573244484504" style="width: 100%; padding: 8px;">
            </div>

            <div style="margin-bottom: 10px;">
                <label for="phone">Teléfono:</label><br>
                <input type="text" name="phone" id="phone" value="573244484504" style="width: 100%; padding: 8px;">
            </div>

            <div style="margin-bottom: 10px;">
                <label for="content">Contenido:</label><br>
                <input type="text" name="content" id="content" value="Hello, world!" style="width: 100%; padding: 8px;">
            </div>

            <div style="margin-bottom: 10px;">
                <label for="name">Nombre:</label><br>
                <input type="text" name="name" id="name" value="John Doe" style="width: 100%; padding: 8px;">
            </div>

            <div style="margin-bottom: 10px;">
                <label for="name2">Nombre Alternativo:</label><br>
                <input type="text" name="name2" id="name2" value="JohnD" style="width: 100%; padding: 8px;">
            </div>

            <div style="margin-bottom: 10px;">
                <label for="image">Imagen (URL):</label><br>
                <input type="text" name="image" id="image" value="http://example.com/image.jpg" style="width: 100%; padding: 8px;">
            </div>

            <div style="margin-bottom: 10px;">
                <label for="APIKEY">APIKEY:</label><br>
                <input type="text" name="APIKEY" id="APIKEY" value="pHPC9TbqDGWVAPRGpzX0VxxNGPJeuXj03uWqt0QQ9b1e9bdf" style="width: 100%; padding: 8px;" required>
            </div>

            <button type="submit" style="width: 100%; padding: 10px; background-color: #4CAF50; color: white; border: none; cursor: pointer;">
                Enviar Datos
            </button>
        </form>
    </div>

    <script>
        document.getElementById('myForm').addEventListener('submit', function (e) {
            e.preventDefault(); // Evita el envío normal del formulario

            // Crea un objeto FormData y lo convierte a JSON
            var formData = new FormData(this);
            var object = {};
            formData.forEach(function (value, key) {
                object[key] = value;
            });

            // Enviar los datos al endpoint
            fetch('http://127.0.0.1:8000/api/watoolbox', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(object)
            })
                .then(response => response.json())
                .then(data => console.log(data))
                .catch(error => console.error('Error:', error));
        });
    </script>
</x-app-layout>
