@php    
    $imenu1 = 2;
    $imenu2 = 1;
@endphp

@if(!$sidepanel)    
    <x-app-layout>    
        <x-slot name="sidemenu">@include('partials.sidemenu')</x-slot>
        <x-slot name="menu">@include('partials.menu')</x-slot>
            @include('profesores._contenido',['profesores'=>$profesores])
    </x-app-layout>
@else
    @include('profesores._contenido',['profesores'=>$profesores])
@endif