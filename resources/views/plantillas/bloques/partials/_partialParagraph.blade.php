

<div class="card mb-3">
        <div class="card-header py-2">
            <h6 class="mb-0">Párrafo</h6>
        </div>
        <div class="card-body py-3">

        <textarea class="summernote" name="properties[text]">{{($properties["text"] ?? 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla accumsan varius volutpat. Integer at mattis justo, ac volutpat mi.')}}</textarea>
        <script>
            $('.summernote').summernote({
            height: 150,
            lang: 'es-ES',
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol']],
                ['insert', ['link']],
                ['view', ['codeview']]
                ],
            placeholder: 'Escribe aquí...',
            dialogsInBody: true,
            disableDragAndDrop: true,
            dialogsFade: true
        });
        
        </script>
    </div>
</div>