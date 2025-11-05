<div class="col-lg-12">
    <div class="card mb-3">
        <div class="card-header py-2">
            <h6 class="mb-0">Textos</h6>
        </div>
        <div class="card-body py-3">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="properties[text]" class="form-label">Texto</label>
                    <input type="text" 
                        value="{{ $properties['text'] ?? 'Introduce un título...' }}"  
                        name="properties[text]" 
                        id="properties[text]" 
                        class="form-control form-control-sm"
                        placeholder="Título"
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
        </div>
    </div>
</div>