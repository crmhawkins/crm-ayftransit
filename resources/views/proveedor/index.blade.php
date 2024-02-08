
@extends('layouts.app')

@section('title', 'Ver Proveedores')

@section('head')
    @vite(['resources/sass/productos.scss'])
    @vite(['resources/sass/alumnos.scss'])
@endsection

@section('content-principal')
<div>
    @livewire('proveedores.index-component')
</div>
@endsection