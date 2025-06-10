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
            <label for="nombre" class="form-label">Nombre *</label>
            <input type="text" value="{{ old('nombre', $cliente->nombre) }}" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" autocomplete="off" placeholder="Nombre del Cliente">
            @error('nombre')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <label for="apellidos" class="form-label">Apellidos *</label>
            <input type="text" value="{{ old('apellidos', $cliente->apellidos) }}" name="apellidos" id="apellidos" class="form-control @error('apellidos') is-invalid @enderror" autocomplete="off" placeholder="Apellidos del Cliente">
            @error('apellidos')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="row mb-3 mt-3">
        <div class="col-md-6">
            <label for="email" class="form-label">email *</label>
            <input type="email" value="{{ old('email', $cliente->email) }}" name="email" id="email" class="form-control @error('email') is-invalid @enderror" autocomplete="off" placeholder="email@cliente.com">
            @error('email')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>
    
    <div class="row mb-3 mt-3">        
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

        <!--ALUMNOS SELECCIONADOS-->      
        <div class="col-md-6">
            <label for="alumnos" class="form-label">Alumnos asociados </label>
            <select name="alumnos[]" id="alumnos" multiple  class="form-control select2" style="height:47px !important;">
                @foreach ($alumnosSelected as $alumno)
                <option value="{{ $alumno->id }}" {{ $alumno->clienteid==$cliente->id ?  'selected' : '' }}>
                    {{ $alumno->nombre }} {{ $alumno->apellidos }} 
                </option>
                @endforeach
            </select> 
            @error('academias')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror            
        </div>
    </div>
    
    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">
            {{ $submitButtonText }}
        </button>
    </div>
  </form>
  