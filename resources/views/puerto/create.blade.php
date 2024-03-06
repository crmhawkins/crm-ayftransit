@extends('layouts.app')

@section('title', 'Crear Puerto')

@section('head')
    @vite(['resources/sass/productos.scss'])
    @vite(['resources/sass/alumnos.scss'])
@endsection

@section('content-principal')
<div>
    @livewire('puertos.create-component')
</div>
@endsection

