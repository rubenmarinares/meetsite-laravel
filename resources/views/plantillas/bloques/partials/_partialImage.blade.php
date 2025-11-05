<div class="card mb-3">
            <div class="card-header py-2">
                <h6 class="mb-0">Imagen</h6>
            </div>
            <div class="card-body py-3">


                <div class="row g-3 mt-3">
                    <div class="mb-3">
                    <label for="uploadfile" class="form-label">
                        <i class="fas fa-upload me-1"></i> Seleccionar archivo
                    </label>
                    <div class="input-group input-group-sm">
                        <input type="file" class="form-control form-control-sm" id="uploadfile" name="uploadfile">
                        <button class="btn btn-outline-secondary btn-sm" type="button" onclick="document.getElementById('uploadfile').value='';">
                        <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="form-text text-muted">Formatos: JPG, PNG, GIF — Máx: 4 MB</div>
                    </div>
                
                </div>
                <div class="row g-3 mt-3">
                    <div class="col-md-6">
                        <label for="properties[text]" class="form-label">Imagen</label>
                        <input type="text" 
                            value="{{ $properties['imageurl'] }}"  
                            name="properties[imageurl]" 
                            id="properties[imageurl]" 
                            class="form-control form-control-sm"
                            placeholder=""
                            autocomplete="off">
                    </div>
                    <div class="col-md-6">
                        <label for="properties[link]" class="form-label">Link</label>
                        <input type="text" 
                            value="{{ $properties['link'] ?? '' }}"  
                            name="properties[link]" 
                            id="properties[link]" 
                            class="form-control form-control-sm"
                            placeholder="Link opcional"
                            autocomplete="off">
                    </div>
                </div>
                <div class="row g-3 mt-3">
                    <div class="col-md-6">
                        <label for="properties[title]" class="form-label">Título</label>
                        <input type="text" 
                            value="{{ $properties['title'] }}"  
                            name="properties[title]" 
                            id="properties[title]" 
                            class="form-control form-control-sm"
                            placeholder="Título de la imagen"
                            autocomplete="off">
                    </div>
                    <div class="col-md-6">
                        <label for="properties[alt]" class="form-label">Alt</label>
                        <input type="text" 
                            value="{{ $properties['alt'] ?? '' }}"  
                            name="properties[alt]" 
                            id="properties[alt]" 
                            class="form-control form-control-sm"
                            placeholder="Texto alternativo"
                            autocomplete="off">
                    </div>
                </div>


                <div class="row g-3 mt-3">
                        <div class="col-md-3">
                            <label class="form-label"><i class="fas fa-arrows-alt-h me-1"></i> Grosor Borde</label>
                            <select class="form-select form-select-sm" name="properties[format][imageborderwidth]">
                                @foreach([0,1,2,3,4,5,8] as $w)
                                    <option value="{{ $w }}" {{ ($properties['format']['imageborderwidth'] ?? 0) == $w ? 'selected' : '' }}>{{ $w }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label"><i class="fas fa-tint me-1"></i> Color Borde</label>
                            <input type="color" class="form-control form-control-color"
                                name="properties[format][imagebordercolor]"
                                value="{{ isset($properties['format']['imagebordercolor']) && !empty($properties['format']['imagebordercolor']) ? $properties['format']['imagebordercolor']:'#FFFFFF' }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label"><i class="fas fa-border-style me-1"></i> Estilo Borde</label>
                            <select class="form-select form-select-sm" name="properties[format][imageborderstyle]">
                                @foreach(['solid', 'dotted', 'dashed'] as $style)
                                    <option value="{{ $style }}" {{ ($properties['format']['imageborderstyle'] ?? 'solid') == $style ? 'selected' : '' }}>
                                        {{ ucfirst($style) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label"><i class="fas fa-circle-notch me-1"></i> Bordes Redondeados</label>
                            <select class="form-select form-select-sm" name="properties[format][imageborderradius]">
                                @foreach([0,1,2,3,4,5,8,20,25] as $r)
                                    <option value="{{ $r }}" {{ ($properties['format']['imageborderradius'] ?? 0) == $r ? 'selected' : '' }}>
                                        {{ $r }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mt-3">
                        <div class="col-md-3">
                            <label class="form-label">Ancho Responsive</label>
                            <select class="form-select form-select-sm" name="properties[responsive][widthimage]">
                                    <option {{ (empty($properties["responsive"]["widthimage"])?'selected':'') }}>normal</option>
                                    <option value="m_banner" {{ ($properties["responsive"]["widthimage"]=='m_banner')?'selected':'' }}>full width</option>
                            </select>

                        </div>
                    </div>
                    

            </div>
        </div>