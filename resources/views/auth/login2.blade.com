<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        darkBg: '#1a202c',
                        darkCard: '#2d3748',
                        darkText: '#e2e8f0'
                    }
                }
            }
        };
    </script>
</head>
<body class="flex items-center justify-center h-screen bg-gray-100 dark:bg-darkBg">
    <div class="w-full max-w-md bg-white dark:bg-darkCard p-8 rounded-2xl shadow-lg">
        
        @if ($errors->any())
            @foreach($errors->all() as $error)
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ $error }}</span>
                </div>
            @endforeach
        @endif
        <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-darkText mb-6">Iniciar sesión</h2>
        <form class="max-w-sm mx-auto" method="POST" action={{route('login')}}>
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-gray-700 dark:text-darkText">Correo Electrónico</label>
                <input type="email" id="email" name="email" 
                    class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700 dark:text-darkText">Contraseña</label>
                <input type="password" id="password" name="password" 
                    class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex items-center justify-between">
                <label class="flex items-center">
                    <input type="checkbox" class="form-checkbox text-blue-500">
                    <span class="ml-2 block text-gray-700 dark:text-darkText">Recordarme</span>
                </label>
                <a href="#" class="text-blue-500 hover:underline">¿Olvidaste tu contraseña?</a>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg mt-6 hover:bg-blue-600">Iniciar sesión</button>
        </form>
        <p class="text-center text-gray-600 mt-4">¿No tienes una cuenta? <a href="/register" class="text-blue-500 hover:underline">Regístrate</a></p>
    </div>
</body>
</html>
