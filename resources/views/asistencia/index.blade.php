@php    
    $imenu1 = 10;
    $imenu2 = -1;
@endphp

@if(!$sidepanel)    
    <x-app-layout>    
        <x-slot name="sidemenu">@include('partials.sidemenu')</x-slot>
        <x-slot name="menu">@include('partials.menu')</x-slot>
            @include('asistencia._contenido',[])
    </x-app-layout>
@else
    @include('asistencia._contenido',[])
@endif