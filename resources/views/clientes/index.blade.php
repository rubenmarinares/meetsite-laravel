@php    
    $imenu1 = 2;
    $imenu2 = 5;
@endphp

@if(!$sidepanel)    
    <x-app-layout>    
        <x-slot name="sidemenu">@include('partials.sidemenu')</x-slot>
        <x-slot name="menu">@include('partials.menu')</x-slot>
            @include('clientes._contenido',['clientes'=>$clientes])
    </x-app-layout>
@else
    @include('clientes._contenido',['clientes'=>$clientes])
@endif