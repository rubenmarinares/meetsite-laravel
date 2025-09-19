<x-app-layout>
    <div class="auth-main">
        <div class="auth-wrapper v1">
            <div class="auth-form">
                <div class="login-brand my-5">
                    <img src="{{ asset('assets/images/logo-black.png') }}" class="img-fluid logo-lg" alt="logo" style="max-height:150px;">
                </div>
                    <div class="card card-primary">
                        <div class="card-body">
                            <h2 class="h5 text-center mb-4" >Recuperar contraseña</h2>
                                <div class="row">

                                @if ($errors->any())
                                    @foreach($errors->all() as $error)
                                        <div class="" role="alert">
                                            
                                            <span class="block sm:inline text-danger">{{ $error }}</span>
                                        </div>
                                    @endforeach
                                @endif

                                <form method="POST" action="{{ route('password.email') }}">
                                    @csrf

                                    <div class="form-group">
                                        <div class="d-block">
                                            <label for="email">Email</label>
                                            <input id="email" type="email" class="form-control" name="email" tabindex="1" required="" autofocus="" aria-invalid="false">                                        
                                            <div class="float-right mt-1">
                                                <a href="{{ route('login') }}" class="text-small ">
                                                    Volver
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--
                                        <input type="email" name="email" placeholder="Tu correo" required>
                                    <button type="submit">Enviar enlace</button>
                                    -->

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4" style="width:100%;">
                            Enviar
                        </button>
                </div>
            </form>
        </div>
        </div>
    </div>    
    
    </div>    
    
</x-app-layout>




