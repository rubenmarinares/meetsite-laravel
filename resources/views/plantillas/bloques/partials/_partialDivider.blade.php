
<div class="row g-3 mt-3">
    <div class="card mb-3">
        <div class="card-header py-2">
            <h6 class="mb-0">Divisor</h6>
        </div>
        <div class="card-body py-3">
            <div class="row g-3 mt-3">
                <div class="col-md-3">
                    <label class="form-label"><i class="fas fa-arrows-alt-h me-1"></i> Grosor Borde</label>
                    <select class="form-select form-select-sm" name="properties[format][dividerborderwidth]">
                        @foreach([0,1,2,3,4,5,8] as $w)
                            <option value="{{ $w }}" {{ ($properties['format']['dividerborderwidth'] ?? 0) == $w ? 'selected' : '' }}>{{ $w }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label"><i class="fas fa-tint me-1"></i> Color</label>
                    <input type="color" class="form-control form-control-color"
                        name="properties[format][dividercolor]"
                        value="{{ isset($properties['format']['dividercolor']) && !empty($properties['format']['dividercolor']) ? $properties['format']['dividercolor']:'#1E1E1E' }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label"><i class="fas fa-border-style me-1"></i> Estilo Borde</label>
                    <select class="form-select form-select-sm" name="properties[format][dividerbordertype]">
                        @foreach(['solid', 'dotted', 'dashed'] as $style)
                            <option value="{{ $style }}" {{ ($properties['format']['dividerbordertype'] ?? 'solid') == $style ? 'selected' : '' }}>
                                {{ ucfirst($style) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            
        </div>
    </div>
</div>