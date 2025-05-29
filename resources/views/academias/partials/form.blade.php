<form class="needs-validation" action="{{ $actionUrl }}" method="POST" novalidate>
    @csrf
    @method($method)

    <div class="row mb-3 mt-3">
        <div class="col-md-8">
            <label for="academia" class="form-label">{{ __('academia.nombre')}}</label>
            <input type="text" value="{{ old('academia', $academia->academia) }}" name="academia" id="academia" class="form-control @error('academia') is-invalid @enderror">
            @error('academia')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4">
            <label class="form-label d-block">{{ __('academia.estado')}}</label>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" id="statusActivo" value="1" {{ old('status', $academia->status) ? 'checked' : '' }}>
                <label class="form-check-label" for="statusActivo">{{ __('academia.activo')}}</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" id="statusInactivo" value="0" {{ old('status', $academia->status) ? '' : 'checked' }}>
                <label class="form-check-label" for="statusInactivo">{{ __('academia.inactivo')}}</label>
            </div>
        </div>
    </div>
    <div class="row mb-3 mt-3">
        <div class="col-md-6">
            <label for="direccion" class="form-label">{{ __('academia.direccion')}}</label>
            <textarea name="direccion" id="direccion" rows="5" class="form-control @error('direccion') is-invalid @enderror">{{ old('direccion', $academia->direccion) }}</textarea>
            @error('direccion')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <label for="localidad" class="form-label">{{ __('academia.localidad')}}</label>
            <input name="localidad" id="localidad" class="form-control @error('localidad') is-invalid @enderror" value="{{ old('localidad', $academia->localidad) }}">
            @error('localidad')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>

    

    <div class="row mb-3 mt-3">
        @foreach($properties as $clave => $valor)
            <div class="col-md-6">
                <label for="{{ $clave }}" class="form-label">{{ __('academia.'. strtolower($clave))}}</label>

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

    

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">
            {{ __('academia.'. $submitButtonText)}}
        </button>
    </div>
</form>