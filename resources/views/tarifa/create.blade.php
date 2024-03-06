@extends('layouts.app')

@section('title', 'Crear Tarifas')

@section('head')
    @vite(['resources/sass/productos.scss'])
    @vite(['resources/sass/alumnos.scss'])
@endsection

@section('content-principal')
<div>
    @livewire('tarifas.create-component')
</div>
@endsection

