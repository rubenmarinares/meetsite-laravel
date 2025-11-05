
@php    
    $imenu1 = 20;
    $imenu2 = 0;
@endphp


@if(!$sidepanel)    
    <x-app-layout>    
        <x-slot name="sidemenu">@include('partials.sidemenu')</x-slot>
        <x-slot name="menu">@include('partials.menu')</x-slot>
            @include('plantillas._contenido',[])
    </x-app-layout>
@else
    @include('plantillas._contenido',[])
@endif