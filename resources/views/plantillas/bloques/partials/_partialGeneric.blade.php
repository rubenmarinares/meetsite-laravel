<div class="col-lg-6 mt-3">
            <div class="card h-100">
                <div class="card-header py-2">
                    <h6 class="mb-0">Propiedades de Fuente</h6>
                </div>
                <div class="card-body py-3">
                    <div class="row g-3 align-items-end">
                        <!-- Font Size -->
                        <div class="col-6 col-md-4">
                            <label class="form-label"><i class="fas fa-text-height me-1"></i> Tamaño (px)</label>
                            <input type="number"
                                class="form-control form-control-sm"
                                name="properties[format][fontsize]"
                                value="{{ $properties['format']['fontsize'] ?? '24' }}"
                                min="8" max="56">
                        </div>

                        <!-- Line Height -->
                        <div class="col-6 col-md-4">
                            <label class="form-label"><i class="fas fa-arrows-alt-v me-1"></i> Interlineado (px)</label>
                            <input type="number"
                                class="form-control form-control-sm"
                                name="properties[format][lineheight]"
                                value="{{ $properties['format']['lineheight'] ?? '28' }}"
                                min="10" max="64">
                        </div>

                        <!-- Lines -->
                        <div class="col-6 col-md-4">
                            <label class="form-label"><i class="fas fa-align-justify me-1"></i> Líneas</label>
                            <select class="form-select form-select-sm"
                                    name="properties[format][lines]">
                                <option value="0" {{ ($properties['format']['lines']=='0'?'selected':'') }}>Any</option>
                                <option value="1" {{ ($properties['format']['lines']=='1'?'selected':'') }}>1</option>
                                <option value="2" {{ ($properties['format']['lines']=='2'?'selected':'') }}>2</option>
                                <option value="3" {{ ($properties['format']['lines']=='3'?'selected':'') }}>3</option>
                            </select>
                        </div>

                        <!-- Colors -->
                        <div class="col-6 col-md-4">
                            <label class="form-label">Color de fuente</label>
                            <input type="color" class="form-control form-control-color"
                                name="properties[format][color]"
                                value="{{ $properties['format']['color'] ?? '#1E1E1E' }}">
                        </div>
                        <div class="col-6 col-md-4">
                            <label class="form-label">Color del link</label>
                            <input type="color" class="form-control form-control-color"
                                name="properties[format][linkcolor]"
                                value="{{ $properties['format']['linkcolor'] ?? '#1E1E1E' }}">
                        </div>

                        <!-- Family & Style -->
                        <div class="col-6 col-md-4">
                            <label class="form-label">Fuente</label>
                            <select class="form-select form-select-sm" name="properties[format][fontfamily]">
                                @foreach($fontFamily as $family)
                                    <option value="{{ $family }}" {{ ($properties['format']['fontfamily']==$family ? 'selected':'') }}>
                                        {{ $family }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-6 col-md-4">
                            <label class="form-label">Estilo</label>
                            <select class="form-select form-select-sm" name="properties[format][fontstyle]">
                                @foreach($fontStyle as $style)
                                    <option value="{{ $style }}" {{ ($properties['format']['fontstyle']==$style ? 'selected':'') }}>
                                        {{ $style }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>