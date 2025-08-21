@php    
    $imenu1 = 2;
    $imenu2 = 3;
@endphp

@if(!$sidepanel)    
    <x-app-layout>    
        <x-slot name="sidemenu">@include('partials.sidemenu')</x-slot>
        <x-slot name="menu">@include('partials.menu')</x-slot>
            @include('asignaturas._contenido',['asignaturas'=>$asignaturas])
    </x-app-layout>
@else
    @include('asignaturas._contenido',['asignaturas'=>$asignaturas])
@endif