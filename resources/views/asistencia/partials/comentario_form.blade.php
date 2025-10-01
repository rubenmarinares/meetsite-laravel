<form id="comentarioForm">

    
    <div class="row">
        <div class="col-md-6">
            <span class="badge bg-primary">{{ $fechaEditada }}</span>
        </div>
        <div class="col-md-6">
            <div class="d-flex justify-content-end mb-2">
            @if(isset($asistencia->estado))
                @if($asistencia->estado == 1)
                    <span class="badge bg-success">Asistió</span>
                @elseif($asistencia->estado==2)
                    <span class="badge bg-danger">No asistió</span>
                @endif
            @endif
             </div>

        </div>

    <input type="hidden" name="grupo" value="{{ $grupo }}">
    <input type="hidden" name="alumno" value="{{ $alumno }}">
    <input type="hidden" name="fecha" value="{{ $fecha }}">

    <div class="mb-3 mt-2">
        <!--<label for="comentarioTexto" class="form-label">Comentario</label>-->
        <textarea placeholder="Añadir algún comentario de asistencia..." class="form-control" name="comentario" id="comentarioTexto" rows="2">{{ $comentario ?? '' }}</textarea>
    </div>

    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-primary btn-sm" id="guardarComentario">Guardar</button>
        </div>
    </div>
</form>