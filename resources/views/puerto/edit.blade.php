@extends('layouts.app')

@section('title', 'Editar Puerto')

@section('head')
    @vite(['resources/sass/productos.scss'])
    @vite(['resources/sass/alumnos.scss'])
@endsection

@section('content-principal')
<div>
    @livewire('puertos.edit-component', ['identificador'=>$id])
</div>
@endsection


