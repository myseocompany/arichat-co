<x-app-layout>
    <form id="myForm">
        <br><input type="text" name="id" value="123">
        <br><input type="text" name="type" value="text">
        <br><input type="text" name="user" value="573244484504">
        <br><input type="text" name="phone" value="573244484504">
        <br><input type="text" name="content" value="Hello, world!">
        <br><input type="text" name="name" value="John Doe">
        <br><input type="text" name="name2" value="JohnD">
        <br><input type="text" name="image" value="http://example.com/image.jpg">
        <br>
        <button type="submit">Send Data</button>
    </form>
    <script>
        document.getElementById('myForm').addEventListener('submit', function(e) {
            e.preventDefault();  // Evita el envío normal del formulario

            // Crea un objeto FormData y usa fetch para enviar los datos como JSON
            var formData = new FormData(this);
            var object = {};
            formData.forEach(function(value, key){
                object[key] = value;
            });

            fetch('http://localhost:8000/api/watoolbox', {
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
