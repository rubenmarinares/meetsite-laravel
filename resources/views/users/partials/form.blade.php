<form class="needs-validation" action="{{ $actionUrl }}" method="POST" novalidate autocomplete="off">
    @csrf
    @method($method)

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="row mb-3 mt-3">
        <div class="col-md-6">
            <label for="name" class="form-label">Nombre *</label>
            <input type="text" value="{{ old('name', $usuario->name) }}" name="name" id="name" class="form-control @error('name') is-invalid @enderror" autocomplete="off" placeholder="Nombre de usuario">
            @error('name')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <label for="email" class="form-label">Email *</label>
            <input type="email" value="{{ old('email', $usuario->email) }}" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="email">
            @error('email')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>

    


    <div class="row mb-3 mt-3">
        <!--ROLES RELATED-->
        <div class="col-md-6">
            <label for="roles" class="form-label">Roles</label>
            <select name="roles[]" id="roles" multiple  class="form-control select2">
                @foreach ($roles as $role)
                <option value="{{ $role->name }}"
                    {{ in_array($role->id, $rolesSeleccionados) ? 'selected' : '' }}
                    >
                    {{ $role->name }} 
                </option>
                @endforeach
            </select>
            @error('roles')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror         
        </div>

        <!--ACADEMIAS RELATED-->
        <div class="col-md-6">
            <label for="academias" class="form-label">Academias </label>
            <select name="academias[]" id="academias" multiple  class="form-control select2" style="height:47px !important;">
                @foreach ($academias as $academia)
                <option value="{{ $academia->id }}" {{ in_array($academia->id, $academiasSeleccionadas) ? 'selected' : '' }}>
                    {{ $academia->academia }} 
                </option>
                @endforeach
            </select> 
            @error('academias')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror            
        </div>
    </div>


    <div class="row mb-3 mt-3">
        <div class="col-md-6">
            <label for="password" class="form-label">{{ $labelPassword }}</label>
            <input type="password"  name="password" id="password"  autocomplete="new-password" class="form-control @error('password') is-invalid @enderror">
            @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <label for="password_confirmation" class="form-label">{{ $labelPasswordConfirm }}</label>
            <input type="password"  name="password_confirmation" id="password_confirmation" class="form-control @error('password') is-invalid @enderror">            
        </div>
    </div>


    

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">
            {{ $submitButtonText }}
        </button>
    </div>
  </form>
  