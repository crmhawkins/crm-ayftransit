<?php

namespace App\Http\Livewire\Presupuestos;

use App\Models\Cliente;
use App\Models\Proveedor;
use App\Models\Puerto;
use App\Models\Tarifa;
use App\Models\Presupuesto;
use Barryvdh\DomPDF\Facade\Pdf;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Str;
class EditComponent extends Component
{

    use LivewireAlert;
    public $identificador;
    public $clientes;
    public $proveedores;
    public $proveedoresterrestres;
    public $puertos;
    public $tarifas;
    public $terrestres = [];
    public $id_cliente;
    public $fechaEmision;
    public $estado = 'Pendiente';
    public $tipo_mar_area_terr; //tipo de tarifa maritima aerea terrestre
    public $tipo_imp_exp; // Exportación o Importación
    public $tipo_cont_grup; // Contenedor o Gupage
    public $destino;
    public $id_proveedorterrestre;
    public $tarifasSeleccionadas =[];
    public $cargo=[];
    public $notas=[];
    public $id_proveedor;
    public $origen_id;
    public $destino_id;
    public $precio_grupage;
    public $precio_contenedor_20;
    public $precio_contenedor_40;
    public $precio_contenedor_h4;
    public $precio_terrestre;
    public $validez;
    public $dias;
    public $tarifa_id;
    public $selectProveedorTarifa;
    public $TarifasProveedores;
    public $gastos_llegada_grupage;
    public $gastos_llegada_h4;
    public $gastos_llegada_40;
    public $gastos_llegada_20;

    public function mount()
    {
        $presupuesto = Presupuesto::find($this->identificador);
        $this->clientes = Cliente::all();
        $this->puertos = Puerto::all();
        $this->fechaEmision = Carbon::now()->format('Y-m-d');
        $this->proveedoresterrestres = Proveedor::whereHas('tarifas', function($query) {
            $query->where('tipo_mar_area_terr', 3);
        })->get();
        $this->proveedores = Proveedor::all();
        $this->tarifas = Tarifa::where('validez', '>', Carbon::now()->toDateString())
        ->where('efectividad', '<', Carbon::now()->toDateString())
        ->where('tipo_mar_area_terr',1)
        ->get();
        $this->id_cliente = $presupuesto->id_cliente;
        $this->estado = $presupuesto->estado;
        $this->fechaEmision = $presupuesto->fechaEmision;
        $this->tipo_imp_exp = $presupuesto->tipo_imp_exp;
        $this->tipo_cont_grup = $presupuesto->tipo_cont_grup;
        $this->tipo_mar_area_terr = $presupuesto->tipo_mar_area_terr;
        $this->id_proveedorterrestre = $presupuesto->id_proveedorterrestre;
        $this->destino = $presupuesto->destino;
        $this->gastos_llegada_grupage = $presupuesto->gastos_llegada_grupage;
        $this->precio_terrestre = $presupuesto->precio_terrestre;
        $this->gastos_llegada_h4 = $presupuesto->gastos_llegada_h4;
        $this->gastos_llegada_40 = $presupuesto->gastos_llegada_40;
        $this->gastos_llegada_20 = $presupuesto->gastos_llegada_20;
        $this->tarifasSeleccionadas = $presupuesto->Tarifas()->get()->toArray();
        $this->cargo = $presupuesto->cargosExtra()->get()->toArray();
        $this->notas = $presupuesto->notas()->get()->toArray();
        $this->TarifasProveedores = [];
        if(isset($this->id_proveedorterrestre)){
            $this->cambioProveedor();
        }

    }
    public function render()
    {
        return view('livewire.presupuestos.edit-component');
    }

    public function nombreProveedor($id)
    {
        $proveedor = Proveedor::find($id);
        return $proveedor ? $proveedor->nombre : 'Proveedor no encontrado';
    }
    public function nombrePuerto($id)
    {
        $puerto = Puerto::find($id);
        return $puerto ? $puerto->Nombre : 'Proveedor no encontrado';
    }

    public function agregarCargoExtra()
    {
        $this->cargo[] = ['concepto' => '', 'valor20' => '','valor40' => '','valorHQ' => '','Unidad' => ''];
    }
    public function eliminarCargoExtra($index)
    {
        unset($this->cargo[$index]);
        $this->cargo = array_values($this->cargo); // Reindexa el arreglo después de eliminar un elemento
    }
    public function agregarNota()
    {
        $this->notas[] = ['titulo' => '', 'descripcion' => ''];
    }
    public function eliminarNota($index)
    {
        unset($this->notas[$index]);
        $this->notas = array_values($this->notas); // Reindexa el arreglo después de eliminar un elemento
    }

    public function agregarTarifa()
    {
        $tarifa = Tarifa::find($this->tarifa_id);
        $this->tarifasSeleccionadas [] = [
            'id_proveedor' => $tarifa->proveedor_id ?? null,
            'tarifa_id' => $tarifa->tarifa_id ?? null,
            'origen_id' => $tarifa->origen_id ?? null,
            'destino_id' => $tarifa->destino_id ?? null,
            'precio_grupage' => $tarifa->precio_grupage ?? null,
            'precio_contenedor_20' => $tarifa->precio_contenedor_20 ?? null,
            'precio_contenedor_40' => $tarifa->precio_contenedor_40 ?? null,
            'precio_contenedor_h4' => $tarifa->precio_contenedor_h4 ?? null,
            'dias' => $tarifa->dias ?? null,
            'validez' => $tarifa->validez ?? null
        ];
        $this->gastos_llegada_grupage = $this->proveedores->find($this->id_proveedor)->first()->gastos_llegada_grupage;
        $this->gastos_llegada_20 = $this->proveedores->find($this->id_proveedor)->first()->gastos_llegada_20;
        $this->gastos_llegada_40 = $this->proveedores->find($this->id_proveedor)->first()->gastos_llegada_40;
        $this->gastos_llegada_h4 = $this->proveedores->find($this->id_proveedor)->first()->gastos_llegada_h4;
        $this->origen_id= null;
        $this->destino_id = null;
        $this->id_proveedor = null;
        $this->selectProveedorTarifa = null;
        $this->TarifasProveedores =[];
    }

    public function eliminarTarifa($index)
    {
        unset($this->tarifasSeleccionadas [$index]);
        $this->tarifasSeleccionadas  = array_values($this->tarifasSeleccionadas ); // Reindexa el arreglo después de eliminar un elemento
    }

    public function updatedSelectProveedorTarifa($value)
    {
        if (!empty($value)) {
            list($proveedorId, $tarifaId) = explode('-', $value);

            $this->id_proveedor = $proveedorId;
            $this->tarifa_id = $tarifaId;
        }

        if ($this->tarifa_id) {
            $tarifaflitrada=$this->tarifas->find($this->tarifa_id);
            $this->precio_grupage = $tarifaflitrada->precio_grupage ?? null;
            $this->precio_contenedor_20 = $tarifaflitrada->precio_contenedor_20 ?? null;
            $this->precio_contenedor_40 = $tarifaflitrada->precio_contenedor_40 ?? null;
            $this->precio_contenedor_h4 = $tarifaflitrada->precio_contenedor_h4 ?? null;
            $this->dias= $tarifaflitrada->dias ?? null;
            $this->validez = $tarifaflitrada->validez ?? null;
        }
    }

    public function cambioProveedor(){
        $this->terrestres = Tarifa::where('validez', '>', Carbon::now()->toDateString())
        ->where('efectividad', '<', Carbon::now()->toDateString())
        ->where('tipo_mar_area_terr', 3)
        ->where('proveedor_id',$this->id_proveedorterrestre)
        ->get();
    }

    public function cambioDestino(){
        $this->precio_terrestre = Tarifa::find($this->destino)->precio_terrestre;
    }

    public function actualizarProveedores()
    {
        $this->TarifasProveedores = Tarifa::where('origen_id', $this->origen_id)
        ->where('destino_id', $this->destino_id)
        ->where('tipo_mar_area_terr', $this->tipo_mar_area_terr)
        ->where('tipo_imp_exp', $this->tipo_imp_exp)
        ->where('tipo_cont_grup', $this->tipo_cont_grup)
        ->where('validez', '>', Carbon::now()->toDateString())
        ->where('efectividad', '<', Carbon::now()->toDateString())
        ->whereHas('proveedor', function ($query) {
            // Aquí podrías añadir filtros adicionales para el proveedor si es necesario
        })
        ->with('proveedor')
        ->get();

        // Ordenar todas las tarifas por el precio de contenedor 20, como ejemplo.
        $this->TarifasProveedores = $this->TarifasProveedores->sortBy('precio_contenedor_20')->values();
    }

    public function updated()
    {
        if ($this->origen_id && $this->destino_id) {
             $this->actualizarProveedores();
        }
    }

    public function update()
    {
        $presupuesto = Presupuesto::find($this->identificador);
        $updated=$presupuesto->update([
            'id_cliente'=> $this->id_cliente,
            'estado' => $this->estado,
            'fechaEmision' => $this->fechaEmision,
            'tipo_imp_exp' => $this->tipo_imp_exp,
            'tipo_cont_grup' => $this->tipo_cont_grup,
            'tipo_mar_area_terr' => $this->tipo_mar_area_terr,
            'id_proveedorterrestre' => $this->id_proveedorterrestre,
            'destino' => $this->destino,
            'precio_terrestre' => $this->precio_terrestre,
            'gastos_llegada_20'=> $this->gastos_llegada_20,
            'gastos_llegada_40'=> $this->gastos_llegada_40,
            'gastos_llegada_h4'=> $this->gastos_llegada_h4,
            'gastos_llegada_grupage'=> $this->gastos_llegada_grupage
        ]);

        $presupuesto->cargosExtra()->delete();
        foreach ($this->cargo as $cargoExtra) {
            $presupuesto->cargosExtra()->create([
                'concepto' => $cargoExtra['concepto'],
                'valor20' => $cargoExtra['valor20'],
                'valor40' => $cargoExtra['valor40'],
                'valorHQ' => $cargoExtra['valorHQ'],
                'Unidad' => $cargoExtra['Unidad'],
            ]);
        }

        $presupuesto->notas()->delete();
        foreach ($this->notas as $nota) {
            $presupuesto->notas()->create([
                'titulo' => $nota['titulo'],
                'descripcion' => $nota['descripcion'],
            ]);
        }

        $presupuesto->Tarifas()->delete();
        foreach ($this->tarifasSeleccionadas as $tarifa) {
            $presupuesto->Tarifas()->create([
                'tarifa_id' => $tarifa['tarifa_id'],
                'origen_id' => $tarifa['origen_id'],
                'destino_id' => $tarifa['destino_id'],
                'id_proveedor' => $tarifa['id_proveedor'],
                'precio_grupage' => $tarifa['precio_grupage'],
                'precio_contenedor_20' => $tarifa['precio_contenedor_20'],
                'precio_contenedor_40' => $tarifa['precio_contenedor_40'],
                'precio_contenedor_h4' => $tarifa['precio_contenedor_h4'],
                'dias' => $tarifa['dias'],
                'validez' => $tarifa['validez'],
            ]);
        }

        if ($updated) {
            $this->alert('success', 'Presupuesto actualizado correctamente!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'confirmed',
                'confirmButtonText' => 'Ok',
            ]);

        } else {
            $this->alert('error', '¡No se ha podido registrar el presupuesto!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
            ]);
        }
    }

    public function getListeners()
    {
        return [
            'confirmed',
            'update',
            'cambioProveedor',
            'confirmDelete'
        ];
    }

    public function confirmed()
    {
        // Redirección tras confirmar, ajusta según tu lógica de navegación
        return redirect()->route('presupuestos.index');
    }

    public function confirmDelete()
    {
        $presupuesto = Presupuesto::find($this->identificador);

        $presupuesto->delete();
        $this->alert('success', 'Presupuesto eliminado correctamente.', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
            'showConfirmButton' => false,
        ]);
        return redirect()->route('presupuestos.index');
    }

    // public function imprimirPresupuesto()
    // {
    //     $presupuesto = Presupuesto::find($this->identificador);
    //     $cliente = Cliente::where('id', $presupuesto->id_cliente)->first();
    //     $evento = Evento::where('id', $presupuesto->id_evento)->first();
    //     $listaServicios = [];
    //     $listaPacks = [];
    //     $packs = ServicioPack::all();

    //     foreach ($presupuesto->servicios()->get() as $servicio) {
    //         $listaServicios[] = ['id' => $servicio->id, 'numero_monitores' => $servicio->pivot->numero_monitores, 'precioFinal' => $servicio->pivot->precio_final, 'tiempo' => $servicio->pivot->tiempo, 'hora_inicio' => $servicio->pivot->hora_inicio, 'hora_finalizacion' => $servicio->pivot->hora_finalizacion, 'existente' => 1];
    //     }

    //     foreach ($presupuesto->packs()->get() as $pack) {
    //         $listaPacks[] = ['id' => $pack->id, 'numero_monitores' => json_decode($pack->pivot->numero_monitores, true), 'precioFinal' => $pack->pivot->precio_final, 'existente' => 1];
    //     }

    //     $nombreEvento = TipoEvento::find($evento->eventoNombre);

    //     $datos =  [
    //         'presupuesto' => $presupuesto, 'cliente' => $cliente, 'id_presupuesto' => $presupuesto->id, 'fechaEmision' => $this->fechaEmision, 'fechaVencimiento' => $this->fechaVencimiento,
    //         'evento' => $evento, 'listaServicios' => $listaServicios, 'listaPacks' => $listaPacks, 'packs' => $packs, 'observaciones' => '','nombreEvento' => $nombreEvento->nombre, 'servicios' => Servicio::all(),
    //     ];

    //     $pdf = Pdf::loadView('livewire.presupuestos.contract-component', $datos)->setPaper('a4', 'vertical')->output(); //
    //     return response()->streamDownload(
    //         fn () => print($pdf),
    //         'export_protocol.pdf'
    //     );
    // }
}
