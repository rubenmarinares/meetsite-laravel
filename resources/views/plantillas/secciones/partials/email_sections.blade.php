@foreach($sections as $section)
    <div class="email-section" 
         data-idsection="{{ $section->id }}"
         id="contenedorSeccion-{{ $section->id }}"
         >
         
        <!--<h3>{{ $section->section->section }}</h3>-->
        <!--<small>Orden: {{ $section->order }}</small>
        <small>id: {{ $section->id }}</small>
        -->
        
        {{-- Aquí va el HTML procesado por renderRow() --}}
        {!! $section->rendered_html !!}
    </div>
@endforeach