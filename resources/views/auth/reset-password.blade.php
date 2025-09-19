<x-app-layout>
    <div class="auth-main">
    <div class="auth-wrapper v1">
      <div class="auth-form">
        <div class="login-brand my-5">
            <img src="{{ asset('assets/images/logo-black.png') }}" class="img-fluid logo-lg" alt="logo" style="max-height:150px;">
        </div>
        <div class="card card-primary">
            <div class="card-body">
                <h2 class="h5 text-center mb-4" >Restablecer contraseña</h2>
                    <div class="row">

                    @if ($errors->any())
                        @foreach($errors->all() as $error)
                            <div class="" role="alert">                                
                                <span class="block sm:inline text-danger">{{ $error }}</span>
                            </div>
                        @endforeach
                    @endif
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->token }}">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email', $request->email) }}" required> 
                    </div>
                    <div class="form-group">
                        <label for="password">Nueva Contraseña</label>
                        <input id="password" type="password" class="form-control" name="password"  required> 
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Repite Contraseña</label>
                        <input id="password_confirmation" type="password" class="form-control" name="password_confirmation"  required> 
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4" style="width:100%;">
                            Acceder
                        </button>
                    </div>
                </form>
            </div>
            </div>
        </div>    
        
        </div>    
                    <!--
                    <input type="hidden" name="token" value="{{ $request->token }}">
                    <input type="email" name="email" value="{{ old('email', $request->email) }}" required>
                    <input type="password" name="password" placeholder="Nueva contraseña" required>
                    <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" required>
                    <button type="submit">Restablecer</button>
                    -->
</x-app-layout>