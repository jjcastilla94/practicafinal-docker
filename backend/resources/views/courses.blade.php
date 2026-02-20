<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Cursos</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <courses></courses>
        <div class="mt-4 text-center">
            <a href="/students" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Ir a Estudiantes</a>
            <a href="/" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Volver al Inicio</a>
        </div>
    </div>
</body>
</html>