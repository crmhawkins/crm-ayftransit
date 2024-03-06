
@extends('layouts.app')

@section('title', 'Ver Tarifas Terrestes')

@section('head')
    @vite(['resources/sass/productos.scss'])
    @vite(['resources/sass/alumnos.scss'])
@endsection

@section('content-principal')
<div>
    @livewire('tarifas.index-terrestre-component')
</div>
@endsection
