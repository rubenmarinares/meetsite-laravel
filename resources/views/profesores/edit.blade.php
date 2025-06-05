<x-app-layout>

    @php
        $imenu1 = 2;
        $imenu2 = 1;
    @endphp
    
    <x-slot name="sidemenu">
        @include('partials.sidemenu')             
    </x-slot>

    <x-slot name="menu">
        @include('partials.menu')             
    </x-slot>


    <div class="card mb-3">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h4 class="card-title"><i class="fas fa-school"></i>&nbsp;Edición Profesor</h4>
            <div class="card-header-action">
                <a href="{{route('profesores.create')}}" class="btn btn-sm btn-primary ajax-sidepanel"><i class="fa fa-users"></i>&nbsp;Nuevo</a>
            </div>
        </div>

        <div class="card-body ">
            @include('profesores.partials.form')
        </div>

    </div>




</x-app-layout>