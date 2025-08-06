@php    
    $imenu1 = 2;
    $imenu2 = 2;
@endphp

@if(!$sidepanel)    
    <x-app-layout>    
        <x-slot name="sidemenu">@include('partials.sidemenu')</x-slot>
        <x-slot name="menu">@include('partials.menu')</x-slot>
            @include('alumnos._contenido',['alumnos'=>$alumnos])
    </x-app-layout>
@else
    @include('alumnos._contenido',['alumnos'=>$alumnos])
@endif