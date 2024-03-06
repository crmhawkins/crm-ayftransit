@extends('layouts.app')

@section('title', 'Editar Tarifas')

@section('head')
    @vite(['resources/sass/productos.scss'])
    @vite(['resources/sass/alumnos.scss'])
@endsection

@section('content-principal')
<div>
    @livewire('tarifas.edit-component', ['identificador'=>$id])
</div>
@endsection


