<div class="col-lg-6 mt-3">
            <div class="card h-100">
                <div class="card-header py-2">
                    <h6 class="mb-0">Rellenos (Padding)</h6>
                </div>
                <div class="card-body py-3">
                    <div class="card-body text-center">
                    <div class="p-3 border rounded bg-light d-inline-block">
                        <div class="d-grid gap-2" style="grid-template-columns: 1fr 1fr 1fr;">
                            <div></div>
                            <div>
                                <label class="form-label small mb-1">Padding Top</label>
                                <div class="input-group input-group-sm">
                                    <input type="number" class="form-control text-center" name="properties[format][paddingtop]" min="0" value="{{ ($properties["format"]["paddingtop"] ?? '10') }}">
                                </div>
                            </div>
                            <div></div>
                            <div>
                                <label class="form-label small mb-1">Left</label>
                                <div class="input-group input-group-sm">
                                    <input type="number" class="form-control text-center" name="properties[format][paddingleft]" min="0" value="{{ ($properties["format"]["paddingleft"] ?? '0') }}">
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-center fw-bold">
                                Contenido (px)
                            </div>
                            <div>
                                <label class="form-label small mb-1">Right</label>
                                <div class="input-group input-group-sm">
                                    <input type="number" class="form-control text-center" name="properties[format][paddingright]" min="0" value="{{ ($properties["format"]["paddingright"] ?? '0') }}">
                                </div>
                            </div>
                            <div></div>
                            <div>
                                <label class="form-label small mb-1">Bottom</label>
                                <div class="input-group input-group-sm">
                                    <input type="number" class="form-control text-center" name="properties[format][paddingbottom]" min="0" value="{{ ($properties["format"]["paddingbottom"] ?? '10') }}">
                                </div>
                            </div>
                            <div></div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>