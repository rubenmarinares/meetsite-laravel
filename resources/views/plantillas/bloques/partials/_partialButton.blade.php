
        <div class="col-lg-12">
            <div class="card shadow-sm border-1">
                <div class="card-header py-2">
                    <h6 class="mb-0">Propiedades del Botón</h6>
                </div>

                <div class="card-body py-3">
                    <div class="row g-3 align-items-stretch pb-4">

                        <!-- COLUMNA IZQUIERDA -->
                        <div class="col-md-6 d-flex flex-column justify-content-between ">

                            <!-- Ancho -->
                            <div class="mb-3">
                                <label class="form-label"><i class="fas fa-arrows-alt-h me-1"></i> Ancho (%)</label>
                                <input type="number" class="form-control form-control-sm"
                                    name="properties[format][width]"
                                    value="{{ $properties['format']['width'] ?? '100' }}"
                                    min="10" max="100">
                            </div>

                            <!-- Alineación del botón -->
                            <div class="mb-3">
                                <label class="form-label"><i class="fas fa-align-left me-1"></i> Alineación</label>
                                <div class="btn-group btn-group-sm w-100" role="group">
                                    <input type="radio" class="btn-check" name="properties[format][float]" id="btn-left" value="left"
                                        {{ ($properties['format']['float']=='left' ? 'checked' : '') }}>
                                    <label class="btn btn-outline-primary" for="btn-left" title="Izquierda"><i class="fas fa-arrow-left"></i></label>

                                    <input type="radio" class="btn-check" name="properties[format][float]" id="btn-center" value="none"
                                        {{ ($properties['format']['float']=='none' ? 'checked' : '') }}>
                                    <label class="btn btn-outline-primary" for="btn-center" title="Centro"><i class="fas fa-align-center"></i></label>

                                    <input type="radio" class="btn-check" name="properties[format][float]" id="btn-right" value="right"
                                        {{ ($properties['format']['float']=='right' ? 'checked' : '') }}>
                                    <label class="btn btn-outline-primary" for="btn-right" title="Derecha"><i class="fas fa-arrow-right"></i></label>
                                </div>
                            </div>

                            <!-- Alineación del texto -->
                            <div>
                                <label class="form-label"><i class="fas fa-text-width me-1"></i> Alineación del Texto</label>
                                <div class="btn-group btn-group-sm w-100" role="group">
                                    <input type="radio" class="btn-check" name="properties[format][buttontextalign]" id="text-left" value="left"
                                        {{ (isset($properties['format']['buttontextalign']) && $properties['format']['buttontextalign']=='left' ? 'checked' : '') }}>
                                    <label class="btn btn-outline-primary" for="text-left" title="Izquierda"><i class="fas fa-align-left"></i></label>

                                    <input type="radio" class="btn-check" name="properties[format][buttontextalign]" id="text-center" value="center"
                                        {{ (isset($properties['format']['buttontextalign']) && $properties['format']['buttontextalign']=='center' ? 'checked' : '') }}>
                                    <label class="btn btn-outline-primary" for="text-center" title="Centro"><i class="fas fa-align-center"></i></label>

                                    <input type="radio" class="btn-check" name="properties[format][buttontextalign]" id="text-right" value="right"
                                        {{ (isset($properties['format']['buttontextalign']) && $properties['format']['buttontextalign']=='right' ? 'checked' : '') }}>
                                    <label class="btn btn-outline-primary" for="text-right" title="Derecha"><i class="fas fa-align-right"></i></label>
                                </div>
                            </div>
                        </div>

                        <!-- COLUMNA DERECHA (Padding) -->
                        <div class="col-md-6">
                            <label class="form-label"><i class="fas fa-expand-alt me-1"></i> Rellenos (px)</label>
                            <div class="h-100 p-3 border rounded bg-light">
                                <div class="text-center small fw-semibold mb-2">Padding</div>
                                <div class="d-grid gap-2 text-center h-100" style="grid-template-columns: 1fr 1fr 1fr;">
                                    <div></div>
                                    <div>
                                        <label class="form-label small mb-1">Top</label>
                                        <input type="number" class="form-control form-control-sm text-center"
                                            name="properties[format][buttonpaddingtop]" min="0"
                                            value="{{ $properties['format']['buttonpaddingtop'] ?? '10' }}">
                                    </div>
                                    <div></div>

                                    <div>
                                        <label class="form-label small mb-1">Left</label>
                                        <input type="number" class="form-control form-control-sm text-center"
                                            name="properties[format][buttonpaddingleft]" min="0"
                                            value="{{ $properties['format']['buttonpaddingleft'] ?? '0' }}">
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center fw-bold">
                                        Botón (px)
                                    </div>
                                    <div>
                                        <label class="form-label small mb-1">Right</label>
                                        <input type="number" class="form-control form-control-sm text-center"
                                            name="properties[format][buttonpaddingright]" min="0"
                                            value="{{ $properties['format']['buttonpaddingright'] ?? '0' }}">
                                    </div>

                                    <div></div>
                                    <div>
                                        <label class="form-label small mb-1">Bottom</label>
                                        <input type="number" class="form-control form-control-sm text-center"
                                            name="properties[format][buttonpaddingbottom]" min="0"
                                            value="{{ $properties['format']['buttonpaddingbottom'] ?? '10' }}">
                                    </div>
                                    <div></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-3">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label"><i class="fas fa-arrows-alt-h me-1"></i> Grosor Borde</label>
                            <select class="form-select form-select-sm" name="properties[format][buttonborderwidth]">
                                @foreach([0,1,2,3,4,5,8] as $w)
                                    <option value="{{ $w }}" {{ ($properties['format']['buttonborderwidth'] ?? 0) == $w ? 'selected' : '' }}>{{ $w }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label"><i class="fas fa-tint me-1"></i> Color Borde</label>
                            <input type="color" class="form-control form-control-color"
                                name="properties[format][buttonbordercolor]"
                                value="{{ $properties['format']['buttonbordercolor'] ?? '#000000' }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label"><i class="fas fa-border-style me-1"></i> Estilo Borde</label>
                            <select class="form-select form-select-sm" name="properties[format][buttonborderstyle]">
                                @foreach(['solid', 'dotted', 'dashed'] as $style)
                                    <option value="{{ $style }}" {{ ($properties['format']['buttonborderstyle'] ?? 'solid') == $style ? 'selected' : '' }}>
                                        {{ ucfirst($style) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label"><i class="fas fa-circle-notch me-1"></i> Bordes Redondeados</label>
                            <select class="form-select form-select-sm" name="properties[format][buttonborderradius]">
                                @foreach([0,1,2,3,4,5,8,20,25] as $r)
                                    <option value="{{ $r }}" {{ ($properties['format']['buttonborderradius'] ?? 0) == $r ? 'selected' : '' }}>
                                        {{ $r }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    