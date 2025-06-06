<form class="needs-validation" action="{{ $actionUrl }}" method="POST" novalidate autocomplete="off">
    @csrf
    @method($method)

    <div class="row mb-3 mt-3">
        <div class="col-md-6">
            <label for="asignatura" class="form-label">Asignatura *</label>
            <input type="text" value="{{ old('asignatura', $asignatura->asignatura) }}" name="asignatura" id="asignatura" class="form-control @error('asignatura') is-invalid @enderror" autocomplete="off" placeholder="Nombre de Asignatura">
            @error('asignatura')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>        

                
    </div>
    
    
    <div class="row mb-3 mt-3">
        <div class="col-md-6">
            <label for="descripcion" class="form-label">Descripción</label>
            
            <textarea name="descripcion" id="descripcion" rows="5" class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion', $asignatura->descripcion) }}</textarea>
            @error('descripcion')
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


    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">
            {{ $submitButtonText }}
        </button>
    </div>
  </form>
  