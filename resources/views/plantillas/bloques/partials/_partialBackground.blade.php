<div class="col-lg-3 mt-3">
            <div class="card h-100">
                <div class="card-header py-2">
                    <h6 class="mb-0">Fondo / Dimensiones</h6>
                </div>
                <div class="card-body py-3">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Color de fondo {{$properties['format']['backgroundcolor']}}</label>
                            <input type="color" class="form-control form-control-color"
                                name="properties[format][backgroundcolor]"
                                value="{{ !empty($properties['format']['backgroundcolor']) ? $properties['format']['backgroundcolor'] : '#FFFFFF' }}"
                                >

                        </div>
                        <div class="col-12">
                            <label class="form-label"><i class="fas fa-arrows-alt-v me-1"></i> Altura (px)</label>
                            <input type="number"
                                class="form-control form-control-sm"
                                name="properties[format][height]"
                                value="{{ $properties['format']['height'] ?? '' }}"
                                min="10" max="1000">
                        </div>
                    </div>
                </div>
            </div>
        </div>