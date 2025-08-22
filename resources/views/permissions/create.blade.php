<x-app-layout>

    @php
        $imenu1 = 2;
        $imenu2 = 9;
    @endphp
    
    <x-slot name="sidemenu">
        @include('partials.sidemenu')             
    </x-slot>

    <x-slot name="menu">
        @include('partials.menu')             
    </x-slot>


    <div class="card mb-3">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h4 class="card-title"><i class="{{$menuitems[$imenu1]['submenu'][$imenu2]['icon']}}"></i>&nbsp;Nuevo {{$menuitems[$imenu1]['submenu'][$imenu2]['label']}}</h4>
            <div class="card-header-action">
                <a href="{{route('permissions.index')}}" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-ban"></i>&nbsp;Cancelar</a>
            </div>
        </div>

        <div class="card-body ">
            @include('permissions.partials.form')
        </div>

    </div>




</x-app-layout>