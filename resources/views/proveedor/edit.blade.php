@extends('layouts.app')

@section('title', 'Editar Proveedor')

@section('head')
    @vite(['resources/sass/productos.scss'])
    @vite(['resources/sass/alumnos.scss'])
@endsection

@section('content-principal')
<div>
    @livewire('proveedores.edit-component', ['identificador'=>$id])
</div>
@endsection
