
@extends('layouts.app')

@section('title', 'Ver Puertos')

@section('head')
    @vite(['resources/sass/productos.scss'])
    @vite(['resources/sass/alumnos.scss'])
@endsection

@section('content-principal')
<div>
    @livewire('puertos.index-component')
</div>
@endsection
