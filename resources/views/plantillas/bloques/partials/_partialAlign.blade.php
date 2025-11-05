
        <div class="col-lg-3 mt-3">
            <div class="card h-100">
                <div class="card-header py-2">
                    <h6 class="mb-0">Alineación</h6>
                </div>
                <div class="card-body d-flex justify-content-between align-items-center py-3">
                    <!-- Vertical Align -->
                    <div>
                        <div class="btn-group-vertical btn-group-sm" role="group" aria-label="Alineación vertical">
                            <input type="radio" class="btn-check" name="properties[format][verticalalign]" id="valign-top" value="Top" {{ ($properties['format']['verticalalign']=='Top' ? 'checked' : '') }}>
                            <label class="btn btn-outline-primary" for="valign-top" title="Arriba"><i class="fas fa-arrow-up fa-xs"></i></label>

                            <input type="radio" class="btn-check" name="properties[format][verticalalign]" id="valign-middle" value="Middle" {{ ($properties['format']['verticalalign']=='Middle' ? 'checked' : '') }}>
                            <label class="btn btn-outline-primary" for="valign-middle" title="Centro"><i class="fas fa-arrows-alt-v fa-xs"></i></label>

                            <input type="radio" class="btn-check" name="properties[format][verticalalign]" id="valign-bottom" value="Bottom" {{ ($properties['format']['verticalalign']=='Bottom' ? 'checked' : '') }}>
                            <label class="btn btn-outline-primary" for="valign-bottom" title="Abajo"><i class="fas fa-arrow-down fa-xs"></i></label>
                        </div>
                    </div>

                    <!-- Horizontal Align -->
                    <div>
                        <div class="btn-group btn-group-sm" role="group" aria-label="Alineación horizontal">
                            <input type="radio" class="btn-check" name="properties[format][horizantalalign]" id="halign-left" value="Left" {{ ($properties['format']['horizantalalign']=='Left' ? 'checked' : '') }}>
                            <label class="btn btn-outline-primary" for="halign-left" title="Izquierda"><i class="fas fa-arrow-left fa-xs"></i></label>

                            <input type="radio" class="btn-check" name="properties[format][horizantalalign]" id="halign-center" value="Center" {{ ($properties['format']['horizantalalign']=='Center' ? 'checked' : '') }}>
                            <label class="btn btn-outline-primary" for="halign-center" title="Centro"><i class="fas fa-arrows-alt-h fa-xs"></i></label>

                            <input type="radio" class="btn-check" name="properties[format][horizantalalign]" id="halign-right" value="Right" {{ ($properties['format']['horizantalalign']=='Right' ? 'checked' : '') }}>
                            <label class="btn btn-outline-primary" for="halign-right" title="Derecha"><i class="fas fa-arrow-right fa-xs"></i></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>    