<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use App\Models\TipoEvento;
use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\Gastos;
use App\Models\Presupuesto;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;



class HomeController extends Controller
{
    // /**
    //  * Create a new controller instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     $middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $presupuestosPendientes = Presupuesto::Where('estado', 'Pendiente')->orderBy('fechaEmision', 'ASC')->get();
        $presupuestosAceptados = Presupuesto::where('estado', 'Aceptado')->orderBy('fechaEmision', 'ASC')->get();
        // $categorias = TipoEvento::all();

        // $inicioSemana = Carbon::now()->startOfWeek();  // Lunes de esta semana
        // $finSemana = Carbon::now()->endOfWeek();  // Domingo de esta semana
        // $inicioMes = Carbon::now()->startOfMonth()->startOfWeek();  // Lunes de esta semana
        // $finMes = Carbon::now()->endOfMonth()->endOfWeek();  // Domingo de esta semana
        // $inicioMesPasado = Carbon::now()->startOfMonth()->startOfWeek()->subMonth();  // Lunes de esta semana
        // $finMesPasado = Carbon::now()->endofMonth()->endofWeek()->subMonth();  // Domingo de esta semana
        // $ingresos_mensuales = (float) ($presupuestos->whereBetween('fechaEmision', [$inicioMes, $finMes])->sum('precioFinal') - $presupuestos->whereBetween('fechaEmision', [$inicioMes, $finMes])->sum('adelanto'));
        // $ingresos_mensuales_pasado = (float) ($presupuestos->whereBetween('fechaEmision', [$inicioMesPasado, $finMesPasado])->sum('precioFinal') - $presupuestos->whereBetween('fechaEmision', [$inicioMesPasado, $finMesPasado])->sum('adelanto'));
        // $porcentaje_ingresos_mensuales = $ingresos_mensuales_pasado > 0 ? round(($ingresos_mensuales / $ingresos_mensuales_pasado) * 100) : 0;
        // $pendiente = (float) ($presupuestos->where('estado', '!=', 'Facturado')->whereBetween('fechaEmision', [$inicioMes, $finMes])->sum('precioFinal') - $presupuestos->where('estado', '!=', 'Facturado')->whereBetween('fechaEmision', [$inicioMes, $finMes])->sum('adelanto'));

        // $user = $request->user();
        // $eventos = Evento::whereBetween('diaEvento', [$inicioSemana, $finSemana])->orderBy('diaEvento', 'ASC')->get();
        // $presupuestosMes = Presupuesto::where('estado', 'Facturado')->whereBetween('fechaEmision', [$inicioMes, $finMes])->get();


        return view('home', compact('presupuestosPendientes', 'presupuestosAceptados', ));
    }
}
