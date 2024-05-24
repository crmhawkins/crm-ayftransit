<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Presupuesto;
use App\Models\Proveedor;
use App\Models\Puerto;
use App\Models\Tarifa;
use Illuminate\Http\Request;

class PresupuestoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = '';
        // $user = Auth::user();

        return view('presupuesto.index', compact('response'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('presupuesto.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('presupuesto.edit', compact('id'));

    }
    public function generales()
    {
        return view('presupuesto.editCampos');

    }
    public function pdf()
    {
        $identificador = 6;
        $presupuesto = Presupuesto::find($identificador);
        return view('livewire.presupuestos.pdf-presupuesto', [
            'identificador' => $identificador,
            'presupuesto' =>$presupuesto,
            'clientes' => Cliente::all(),
            'puertos' => Puerto::all(),
            'proveedores' => Proveedor::all(),
            'tarifas'=> Tarifa::all(),
            'tarifasSeleccionadas' => $presupuesto->Tarifas()->get()->toArray(),
            'cargo' => $presupuesto->cargosExtra()->get()->toArray(),
            'notas' => $presupuesto->notas()->get()->toArray(),
            'servicios' => $presupuesto->servicios()->get()->toArray(),
            'generales' => $presupuesto->generales()->get()->toArray(),]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
