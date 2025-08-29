@php    
    $imenu1 = 2;
    $imenu2 = 10;
@endphp

@if(!$sidepanel)    
    <x-app-layout>    
        <x-slot name="sidemenu">@include('partials.sidemenu')</x-slot>
        <x-slot name="menu">@include('partials.menu')</x-slot>
            @include('grupos._contenido',['grupos'=>$grupos])
    </x-app-layout>
@else
    @include('grupos._contenido',['grupos'=>$grupos])
@endif