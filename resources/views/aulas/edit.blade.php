

    @php
        $imenu1 = 2;
        $imenu2 = 4;
    @endphp

    @if(!$sidepanel)    
    <x-app-layout>    
        <x-slot name="sidemenu">@include('partials.sidemenu')</x-slot>
        <x-slot name="menu">@include('partials.menu')</x-slot>        
            @include('aulas.partials.form')
    </x-app-layout>
@else
    <div class="card mb-3">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h4 class="card-title"><i class="{{$menuitems[$imenu1]['submenu'][$imenu2]['icon']}}"></i>&nbsp;Edición {{$menuitems[$imenu1]['submenu'][$imenu2]['label']}}</h4>
            <div class="card-header-action">
                <a href="#" class="btn btn-sm btn-outline-danger close-ajax-sidepanel"><i class="fa-solid fa-ban"></i>&nbsp;Cancelar</a>
            </div>
        </div>        
        <div class="card-body ">
            @include('aulas.partials.form')
        </div>

    </div>    
@endif




