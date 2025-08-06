<form class="needs-validation" action="{{ $actionUrl }}" method="POST" novalidate autocomplete="off">
    @csrf
    @method($method)

    <div class="row mb-3 mt-3">
        <div class="col-md-6">
            <label for="nombre" class="form-label">Nombre *</label>            
            <input type="text" value="{{ old('nombre', $data['nombre'] ?? $alumno->nombre) }}"  name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" autocomplete="off" placeholder="Nombre del Alumno">
            @error('nombre')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <label for="apellidos" class="form-label">Apellidos *</label>
            <input type="text" value="{{ old('apellidos', $data['apellidos'] ?? $alumno->apellidos) }}" name="apellidos" id="apellidos" class="form-control @error('apellidos') is-invalid @enderror" autocomplete="off" placeholder="Apellidos del Alumno">
            @error('apellidos')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="row mb-3 mt-3">
        <div class="col-md-6">
            <label for="email" class="form-label">email *</label>
            <input type="email" value="{{ old('email', $data['email'] ?? $alumno->email) }}" name="email" id="email" class="form-control @error('email') is-invalid @enderror" autocomplete="off" placeholder="email@alumno.com">
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
    </div>


    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">
            {{ $submitButtonText }}
        </button>
    </div>
  </form>
  