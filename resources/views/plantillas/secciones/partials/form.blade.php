<form class="needs-validation" action="{{ $actionUrl }}" method="POST" novalidate autocomplete="off">
    @csrf
    @method($method)

    FOrmulario de edición de sección {{ $section }}
    <!-- === ALINEACIÓN === -->

    <div class="row">
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-header">
                <h6 class="mb-0">Alineación</h6>
                </div>
                <div class="card-body d-flex flex-wrap align-items-center gap-4">
                
                    <!-- Vertical Align -->
                    <div>
                        <!--<label class="form-lfabel fw-bold mb-2">Vertical</label>-->                        
                        <div class="btn-group-vertical btn-group-sm" role="group" aria-label="Alineación vertical">
                            <input type="radio" class="btn-check" name="properties[format][verticalalign]" id="valign-top" value="Top" autocomplete="off" {{ ($properties["format"]["verticalalign"]=='Top' ? 'checked' : '') }} >
                            <label class="btn btn-outline-primary" for="valign-top" title="Top">
                                <i class="fas fa-arrow-up"></i> 
                            </label>

                            <input type="radio" class="btn-check" name="properties[format][verticalalign]" id="valign-middle" value="Middle" autocomplete="off" {{ ($properties["format"]["verticalalign"]=='Middle' ? 'checked' : '') }}>
                            <label class="btn btn-outline-primary" for="valign-middle" title="Middle">
                                <i class="fas fa-arrows-alt-v"></i>
                            </label>

                            <input type="radio" class="btn-check" name="properties[format][verticalalign]" id="valign-bottom" value="Bottom" autocomplete="off" {{ ($properties["format"]["verticalalign"]=='Bottom' ? 'checked' : '') }}>
                            <label class="btn btn-outline-primary" for="valign-bottom" title="Bottom">
                                <i class="fas fa-arrow-down"></i> 
                            </label>
                        </div>
                    </div>

                    <!-- Horizontal Align -->
                    <div>
                        <!--<label class="form-label fw-bold mb-2">Horizontal</label>-->
                        <div class="btn-group btn-group-sm" role="group" aria-label="Alineación horizontal">
                            <input type="radio" class="btn-check" name="properties[format][horizontalalign]" id="halign-left" value="Left" autocomplete="off" {{ ($properties["format"]["horizontalalign"]=='Left' ? 'checked' : '') }}>
                            <label class="btn btn-outline-primary" for="halign-left" title="Left">
                                <i class="fas fa-arrow-left"></i>
                            </label>

                            <input type="radio" class="btn-check" name="properties[format][horizontalalign]" id="halign-center" value="Center" autocomplete="off" {{ ($properties["format"]["horizontalalign"]=='Center' ? 'checked' : '') }}>
                            <label class="btn btn-outline-primary" for="halign-center" title="Center">
                                <i class="fas fa-arrows-alt-h"></i> 
                            </label>

                            <input type="radio" class="btn-check" name="properties[format][horizontalalign]" id="halign-right" value="Right" autocomplete="off" {{ ($properties["format"]["horizontalalign"]=='Right' ? 'checked' : '') }}>
                            <label class="btn btn-outline-primary" for="halign-right" title="Right">
                                <i class="fas fa-arrow-right"></i>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($numcols>1)
        <div class="col-md-4">
            <!--
            Colformat  
                2 columns
                    50%-50%
                    40%-60%
                    60%-40%
                3 columns
                    33%-33%
                4 Columns
                    25%
                    25/75%-25/75%
            -->

            <div class="card mb-4">
                <div class="card-header">
                <h6 class="mb-0">Formato de columna</h6>
                </div>
                <div class="card-body d-flex flex-wrap align-items-center gap-4">
                                    
                    @if($numcols==2)
                    <!-- Col Format -->
                    <div>                        
                        <div class="btn-group btn-group-sm" role="group" aria-label="Formato columna">
                            <input type="radio" class="btn-check" name="properties[format][colformat]" id="colformat-50" value="50%-50%" autocomplete="off" {{ ($properties["format"]["colformat"]=='50%-50%' ? 'checked' : '') }}>
                            <label class="btn btn-outline-primary" for="colformat-50" title="50%">
                                50%-50%
                            </label>

                            <input type="radio" class="btn-check" name="properties[format][colformat]" id="colformat-40" value="40%-60%" autocomplete="off" {{ ($properties["format"]["colformat"]=='40%-60%' ? 'checked' : '') }}>
                            <label class="btn btn-outline-primary" for="colformat-40" title="40%-60%">
                                40%-60%
                            </label>

                            <input type="radio" class="btn-check" name="properties[format][colformat]" id="colformat-60" value="60%-40%" autocomplete="off" {{ ($properties["format"]["colformat"]=='60%-40%' ? 'checked' : '') }}>
                            <label class="btn btn-outline-primary" for="colformat-60" title="60%-40%">
                                60%-40%
                            </label>

                            
                        </div>
                    </div>
                    @endif
                    @if($numcols==3)
                    <!-- Col Format -->
                    <div>                        
                        <div class="btn-group btn-group-sm" role="group" aria-label="Formato columna">
                            <input type="radio" class="btn-check" name="properties[format][colformat]" id="colformat-33" value="33%" autocomplete="off" {{ ($properties["format"]["colformat"]=='33%' ? 'checked' : '') }}>
                            <label class="btn btn-outline-primary" for="colformat-33" title="33%">
                                33%
                            </label>
                            <input type="radio" class="btn-check" name="properties[format][colformat]" id="colformat-50-25" value="50%-25%-25%" autocomplete="off" {{ ($properties["format"]["colformat"]=='50%-25%-25%' ? 'checked' : '') }}>
                            <label class="btn btn-outline-primary" for="colformat-50-25" title="50%-25%-25%">
                                50%-25%-25%
                            </label>
                            <input type="radio" class="btn-check" name="properties[format][colformat]" id="colformat-25-50" value="25%-25%-50%" autocomplete="off" {{ ($properties["format"]["colformat"]=='25%-25%-50%' ? 'checked' : '') }}>
                            <label class="btn btn-outline-primary" for="colformat-25-50" title="25%-25%-50%">
                                25%-25%-50%
                            </label>

                            
                        </div>
                    </div>
                    @endif

                    @if($numcols==4)
                    <!-- Col Format -->
                    <div>                        
                        <div class="btn-group btn-group-sm" role="group" aria-label="Formato columna">
                            <input type="radio" class="btn-check" name="properties[format][colformat]" id="colformat-25" value="25%" autocomplete="off" {{ ($properties["format"]["colformat"]=='25%' ? 'checked' : '') }}>
                            <label class="btn btn-outline-primary" for="colformat-25" title="25%">
                                25%
                            </label>                            
                            <input type="radio" class="btn-check" name="properties[format][colformat]" id="colformat-2575" value="25/75%-25/75%" autocomplete="off" {{ ($properties["format"]["colformat"]=='25/75%-25/75%' ? 'checked' : '') }}>
                            <label class="btn btn-outline-primary" for="colformat-2575" title="25/75%-25/75%">
                                25/75%-25/75%
                            </label>                            

                            
                        </div>
                    </div>
                    @endif
                </div>
            </div>


                


        </div>
        @endif

        
    </div>

    <div class="row">
        <div class="col-md-8">
            <!-- === BACKGROUND === -->
            <div class="card mb-4">
                <div class="card-header">
                <h6 class="mb-0">Fondo y Dimensiones</h6>
                </div>
                <div class="card-body row g-3 align-items-center">

                    <div class="col-md-3">
                        <label class="form-label">Color de fondo (Sección)</label>                        
                        <input type="color" class="form-control form-control-color" 
                            name="properties[format][sectionbackgroundcolor]" 
                            
                            value="{{ !empty($properties['format']['sectionbackgroundcolor']) ? $properties['format']['sectionbackgroundcolor'] : '#FFFFFF' }}"
                            title="Color de fondo de la sección"
                            
                            >   
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Color de fondo (Interior)</label>
                        
                            <input type="color" class="form-control form-control-color"
                            name="properties[format][backgroundcolor]"                             
                            value="{{ !empty($properties['format']['backgroundcolor']) ? $properties['format']['backgroundcolor'] : '#FFFFFF' }}"
                            title="Color de fondo interior"
                            >
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Ancho (px)</label>
                        <div class="input-group input-group-sm">
                            <input type="number" class="form-control" 
                            name="properties[format][width]" min="0" max="600" value="{{ ($properties["format"]["width"] ?? '600') }}">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Ancho interior (px)</label>
                        <div class="input-group input-group-sm">
                            <input type="number" class="form-control" 
                                name="properties[format][widthinner]" min="0" max="600" value="{{ ($properties["format"]["widthinner"] ?? '600') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

  



  <!-- === PADDINGS === -->
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Rellenos (Padding)</h6>
                </div>
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
                                Contenido
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

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Responsive</h6>
                </div>
                <div class="card-body">
                    <label for="widthresponsive" class="form-label">Ancho </label>
                    <div class="input-group input-group-sm">
                        <select name="properties[responsive][width]" id="widthresponsive" class="form-control">
                            <option value=""></option>
                            <option value="m_width90" {{ ($properties["responsive"]["width"]=='m_width90'?'selected':'') }}>m_width90</option>  
                        </select> 
                    </div>
                    

                </div>
            </div>
        </div>


    </div>

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">
            {{ $submitButtonText }}
        </button>
    </div>


</form>