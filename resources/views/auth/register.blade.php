
<h2>Registro</h2>
    @if ($errors->any())
        @foreach($errors->all() as $error)
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ $error }}</span>
            </div>
        @endforeach
@endif

<form method="POST" action="{{ route('register') }}">
    @csrf
    <input type="text" name="name" value="" placeholder="Nombre" >
    <input type="email" name="email" placeholder="Correo electrónico" >
    <input type="password" name="password" placeholder="Contraseña" >
    <input type="password" name="password_confirmation" placeholder="Repetir contraseña" >
    <button type="submit">Registrarse</button>
</form>

<a href="{{ route('login') }}">¿Ya tienes cuenta? Inicia sesión aquí</a>