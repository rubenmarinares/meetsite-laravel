<x-app-layout>
    


    <div class="auth-main">
    <div class="auth-wrapper v1">
      <div class="auth-form">
        <div class="login-brand my-5">
            <img src="{{ asset('assets/images/logo-black.png') }}" class="img-fluid logo-lg" alt="logo" style="max-height:150px;">
        </div>
        <div class="card card-primary">
            <div class="card-body">
                <h2 class="h5 text-center mb-4" >Datos de acceso MEETSITE</h2>
                    <div class="row">

                    @if ($errors->any())
                        @foreach($errors->all() as $error)
                            <div class="" role="alert">
                                <strong class="font-bold">Error!</strong>
                                <span class="block sm:inline">{{ $error }}</span>
                            </div>
                        @endforeach
                    @endif
                    <form method="POST"  method="POST" action={{route('login')}}>
                @csrf
                <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" class="form-control" name="email" tabindex="1" required="" autofocus="" aria-invalid="false">
                <div class="invalid-feedback">
                    Please fill in your email
                </div>
                </div>
                <div class="form-group">
                    <div class="d-block">
                        <label for="password" class="control-label">Contraseña</label>
                        <input id="password" type="password" class="form-control" name="password" tabindex="2" required="" aria-invalid="false">
                        <!--<div class="float-right">
                        <a href="auth-forgot-password.html" class="text-small">
                            Forgot Password?
                        </a>
                        </div>-->
                    </div>    
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                        Acceder
                    </button>
                </div>
            </form>
        </div>
        </div>
    </div>    
    
    </div>    


</x-app-layout>