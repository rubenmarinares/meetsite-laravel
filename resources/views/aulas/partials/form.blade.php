<form class="needs-validation" action="{{ $actionUrl }}" method="POST" novalidate autocomplete="off">
    @csrf
    @method($method)

    <div class="row mb-3 mt-3">
        <div class="col-md-6">
            <label for="asignatura" class="form-label">Aula *</label>
            <input type="text" value="{{ old('aula', $aula->aula) }}" name="aula" id="aula" class="form-control @error('aula') is-invalid @enderror" autocomplete="off" placeholder="Nombre de Aula">
            @error('asignatura')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>        
    </div>

    <div class="row mb-3 mt-3">
        @foreach($properties as $clave => $valor)
            <div class="col-md-6">
                <label for="{{ $clave }}" class="form-label">{{ $clave }}</label>

                @if($clave == 'tipo')
                    <select name="properties[{{ $clave }}]" id="{{ $clave }}" class="form-select @error("properties.$clave") is-invalid @enderror" >
                        <option value=""></option>
                        @foreach($tipos as $clavetipo => $valortipo)
                            <option value="{{ $clavetipo }}" @if($clavetipo == old("properties.$clave", $valor)) selected @endif>{{ $valortipo }}</option>
                        @endforeach
                    </select>
                @else
                    <input type="text" value="{{ old("properties.$clave", $valor) }}" name="properties[{{ $clave }}]" id="{{ $clave }}" class="form-control @error("properties.$clave") is-invalid @enderror">
                @endif

                @error("properties.$clave")
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        @endforeach

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
  