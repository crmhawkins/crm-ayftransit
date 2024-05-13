@extends('layouts.app')

@section('title', 'Subida de  Tarifas')

@section('head')
    @vite(['resources/sass/productos.scss'])
    @vite(['resources/sass/alumnos.scss'])
@endsection

@section('content-principal')
<div>
    @livewire('tarifas.subida-component')
</div>
@endsection

