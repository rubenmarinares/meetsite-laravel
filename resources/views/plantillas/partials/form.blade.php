<form class="needs-validation" action="{{ $actionUrl }}" method="POST" novalidate autocomplete="off">
    @csrf
    @method($method)

    <div class="row mb-3 mt-3">
        <div class="col-md-6">
            <label for="nombre" class="form-label">Nombre *</label>            
            <input type="text" value="{{ old('nombre', $data['nombre'] ?? $plantilla->nombre) }}"  name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" autocomplete="off" placeholder="Nombre para la plantilla">
            @error('nombre')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        

    </div>
    <input type="hidden" value="{{ old('userid', $plantilla->userid ?? $data['userid']) }}"  name="userid" id="userid" class="form-control @error('nombre') is-invalid @enderror" autocomplete="off" placeholder="Creador de plantilla">
    <input type="hidden" value="{{ old('academiaid', $data['academiaid'] ?? $plantilla->academiaid) }}"  name="academiaid" id="academiaid" class="form-control @error('nombre') is-invalid @enderror" autocomplete="off">            
    <input type="hidden" value="{{ old('plantilla', $data['esplantilla'] ?? $plantilla->plantilla) }}"  name="plantilla" id="plantilla" class="form-control @error('nombre') is-invalid @enderror" autocomplete="off">            
    
    


    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">
            {{ $submitButtonText }}
        </button>
    </div>
  </form>
  