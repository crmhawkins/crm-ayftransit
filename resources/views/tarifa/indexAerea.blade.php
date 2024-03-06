
@extends('layouts.app')

@section('title', 'Ver Tarifas Aereas')

@section('head')
    @vite(['resources/sass/productos.scss'])
    @vite(['resources/sass/alumnos.scss'])
@endsection

@section('content-principal')
<div>
    @livewire('tarifas.index-aereo-component')
</div>
@endsection
