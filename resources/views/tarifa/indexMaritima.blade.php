
@extends('layouts.app')

@section('title', 'Ver Tarifas Maritimas')

@section('head')
    @vite(['resources/sass/productos.scss'])
    @vite(['resources/sass/alumnos.scss'])
@endsection

@section('content-principal')
<div>
    @livewire('tarifas.index-maritimo-component')
</div>
@endsection
