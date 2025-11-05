<form class="needs-validation" action="{{ $actionUrl }}" method="POST" novalidate autocomplete="off" enctype="multipart/form-data">
    @csrf
    @method($method)

FORMULARIO BLOQUES

<small>id: {{ $block }}</small>
<small>type: {{ $typeblock }}</small>

<div class="row">
@switch($typeblock)
    @case("Divider")
        @include('plantillas.bloques.partials._partialDivider')        
        @break
    @case("Image")
        @include('plantillas.bloques.partials._partialImage')
        @include('plantillas.bloques.partials._partialBackground')
        @include('plantillas.bloques.partials._partialPadding')
        @include('plantillas.bloques.partials._partialAlign')
        @break
    @case("Title")
    @case("Button")
        @include('plantillas.bloques.partials._partialTexts')
        @if($typeblock=="Button")
            @include('plantillas.bloques.partials._partialButton')
        @endif
        @include('plantillas.bloques.partials._partialGeneric')
        @include('plantillas.bloques.partials._partialBackground')
        @include('plantillas.bloques.partials._partialAlign')
        @include('plantillas.bloques.partials._partialPadding')
        @break

    @case("Paragraph")
        @include('plantillas.bloques.partials._partialParagraph')
        @include('plantillas.bloques.partials._partialGeneric')
        @include('plantillas.bloques.partials._partialBackground')
        @include('plantillas.bloques.partials._partialAlign')
        @include('plantillas.bloques.partials._partialPadding')
        @break;
    @case('Footer')
        @include('plantillas.bloques.partials._partialFooter')
        @break;

    @default
        
@endswitch

</div>

        
    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">
            {{ $submitButtonText }}
        </button>
    </div>



</form>