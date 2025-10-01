<form id="comentarioForm">
    <input type="hidden" name="grupo" value="{{ $grupo }}">
    <input type="hidden" name="alumno" value="{{ $alumno }}">
    <input type="hidden" name="fecha" value="{{ $fecha }}">

    <div class="mb-3">
        <label for="comentarioTexto" class="form-label">Comentario</label>
        <textarea class="form-control" name="comentario" id="comentarioTexto" rows="3">{{ $comentario ?? '' }}</textarea>
    </div>

    <button type="button" class="btn btn-primary btn-sm" id="guardarComentario">Guardar</button>
</form>