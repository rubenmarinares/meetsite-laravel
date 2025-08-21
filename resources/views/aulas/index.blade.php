@php    
    $imenu1 = 2;
    $imenu2 = 4;
@endphp

@if(!$sidepanel)    
    <x-app-layout>    
        <x-slot name="sidemenu">@include('partials.sidemenu')</x-slot>
        <x-slot name="menu">@include('partials.menu')</x-slot>
            @include('aulas._contenido',['aulas'=>$aulas])
    </x-app-layout>
@else
    @include('aulas._contenido',['aulas'=>$aulas])
@endif