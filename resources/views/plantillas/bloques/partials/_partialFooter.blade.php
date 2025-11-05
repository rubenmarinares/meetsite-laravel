<div class="col-lg-12">
    <div class="card mb-3">
        <div class="card-header py-2">
            <h6 class="mb-0">Textos Footer</h6>
        </div>
        <div class="card-body py-3">
            <div class="row g-3">
                <div class="col-md-12">
                    <label for="properties[nombreacademia]" class="form-label">Nombre academia</label>
                    <input type="text" 
                        value="{{ isset($properties['nombreacademia']) ? $properties['nombreacademia']: '' }}"  
                        name="properties[nombreacademia]" 
                        id="properties[nombreacademia]" 
                        class="form-control form-control-sm"
                        placeholder="Nombre Academia"
                        autocomplete="off">
                </div>
            </div>
            <div class="row g-3 mt-3">
                <div class="col-md-12">
                    <label for="properties[direccionacademia]" class="form-label">Dirección academia</label>
                    <input type="text" 
                        value="{{ isset($properties['direccionacademia']) ? $properties['direccionacademia']: '' }}"  
                        name="properties[direccionacademia]" 
                        id="properties[direccionacademia]" 
                        class="form-control form-control-sm"
                        placeholder="C/ Ejemplo 123, 28000 Madrid, España"
                        autocomplete="off">
                </div>
            </div>

            <div class="row g-3 mt-3">
                <div class="col-md-12">
                    <label for="properties[telefonoacademia]" class="form-label">Teléfono academia</label>
                    <input type="text" 
                        value="{{ isset($properties['telefonoacademia']) ? $properties['telefonoacademia']: '' }}"  
                        name="properties[telefonoacademia]" 
                        id="properties[telefonoacademia]" 
                        class="form-control form-control-sm"
                        placeholder="+34 900 123 456"
                        autocomplete="off">
                </div>
            </div>

            <div class="row g-3 mt-3">
                <div class="col-md-12">
                    <label for="properties[emailacademia]" class="form-label">Email academia</label>
                    <input type="text" 
                        value="{{ isset($properties['emailacademia']) ? $properties['emailacademia']: '' }}"  
                        name="properties[emailacademia]" 
                        id="properties[emailacademia]" 
                        class="form-control form-control-sm"
                        placeholder="info@meetsite.es"
                        autocomplete="off">
                </div>
            </div>
        </div>
    </div>
</div>


<div class="col-lg-12">
    <div class="card mb-3">
        <div class="card-header py-2">
            <h6 class="mb-0">Estilos Footer</h6>
        </div>
        <div class="card-body py-3">
            <div class="row g-3 mt-3">
                <div class="col-md-3">
                    <label class="form-label"><i class="fas fa-arrows-alt-h me-1"></i> Grosor Borde</label>
                    <select class="form-select form-select-sm" name="properties[format][footerborderwidth]">
                        @foreach([0,1,2,3,4,5,8] as $w)
                            <option value="{{ $w }}" {{ ($properties['format']['footerborderwidth'] ?? 0) == $w ? 'selected' : '' }}>{{ $w }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label"><i class="fas fa-tint me-1"></i> Color Borde</label>
                    <input type="color" class="form-control form-control-color"
                        name="properties[format][footerbordercolor]"
                        value="{{ isset($properties['format']['footerbordercolor']) && !empty($properties['format']['footerbordercolor']) ? $properties['format']['footerbordercolor']:'#FFFFFF' }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label"><i class="fas fa-border-style me-1"></i> Estilo Borde</label>
                    <select class="form-select form-select-sm" name="properties[format][footerborderstyle]">
                        @foreach(['solid', 'dotted', 'dashed'] as $style)
                            <option value="{{ $style }}" {{ ($properties['format']['footerborderstyle'] ?? 'solid') == $style ? 'selected' : '' }}>
                                {{ ucfirst($style) }}
                            </option>
                        @endforeach
                    </select>
                </div>                
            </div>           
        </div>
    </div>
</div>