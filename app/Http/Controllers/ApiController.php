<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Presupuesto;
use App\Models\User;
use App\Models\Servicio;
use App\Models\Articulos;
use App\Models\Evento;
use App\Models\Contrato;
use App\Models\Gastos;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getClients()
    {
        $data = Cliente::all();
        return response()->json($data);
    }
    public function getPresupuesto()
    {
        $data = Presupuesto::all();
        return response()->json($data);
    }
    public function getUsuarios()
    {
        $data = User::all();
        return response()->json($data);
    }

    public function getServicios()
    {
        $data = Servicio::all();
        return response()->json($data);
    }
    public function getArticulos()
    {
        $data = Articulos::all();
        return response()->json($data);
    }
    public function getContratos()
    {
        $data = Contrato::all();
        return response()->json($data);
    }
    public function getEventos()
    {
        $data = Evento::all();
        return response()->json($data);
    }
    public function getGastos()
    {
        $data = Gastos::all();
        return response()->json($data);
    }

}
