<?php

namespace App\Http\Livewire\Presupuestos;

use App\Mail\PresupuestoMailable;
use App\Models\Cliente;
use App\Models\Proveedor;
use App\Models\Puerto;
use App\Models\Tarifa;
use App\Models\Presupuesto;
use Barryvdh\DomPDF\Facade\Pdf;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
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
    public $servicios=[];
    public $generales=[];
    public $clienteNotas = [];
    public $clienteGastos = [];
    public $tarifasTerrestres;
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
        $this->proveedoresterrestres = Proveedor::whereHas('tarifas', function($query) {
            $query->where('tipo_mar_area_terr', 3);
        })->get();
        $this->proveedores = Proveedor::all();
        $this->tarifas = Tarifa::where('validez', '>', Carbon::now()->toDateString())
        ->where('efectividad', '<', Carbon::now()->toDateString())
        ->where('tipo_mar_area_terr',1)
        ->get();
        $this->id_cliente = $presupuesto->id_cliente;
        if(isset($this->id_cliente)){
            $clienteseleccionado = $this->clientes->find($this->id_cliente);
            $this->clienteNotas = $clienteseleccionado->notas()->get()->toArray();
            $this->clienteGastos = $clienteseleccionado->gastosAduanas()->get()->toArray();
            $this->tarifasTerrestres = $clienteseleccionado->tarifasTerrestres()->get();
        }
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
        $this->servicios = $presupuesto->servicios()->get()->toArray();
        $this->generales = $presupuesto->generales()->get()->toArray();
        $this->TarifasProveedores = [];
        if(isset($this->id_proveedorterrestre)){
            $this->cambioProveedor();
        }

    }
    public function render()
    {
        return view('livewire.presupuestos.edit-component');
    }

    public function updatedIdCliente(){

        $clienteseleccionado = $this->clientes->find($this->id_cliente);
        $this->clienteNotas = $clienteseleccionado->notas()->get()->toArray();
        $this->clienteGastos = $clienteseleccionado->gastosAduanas()->get()->toArray();
        $this->tarifasTerrestres = $clienteseleccionado->tarifasTerrestres()->get();
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
    public function agregarServicio()
    {
        $this->servicios[] = ['titulo' => '', 'descripcion' => ''];
    }
    public function eliminarServicio($index)
    {
        unset($this->servicios[$index]);
        $this->servicios = array_values($this->servicios); // Reindexa el arreglo después de eliminar un elemento
    }
    public function agregarGenerales()
    {
        $this->generales[] = ['titulo' => '', 'descripcion' => ''];
    }
    public function eliminarGenerales($index)
    {
        unset($this->generales[$index]);
        $this->generales = array_values($this->generales); // Reindexa el arreglo después de eliminar un elemento
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
            'validez' => $tarifa->validez ?? null,
            'efectividad' => $tarifa->efectividad ?? null
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
        $precio = null;
        $tarifaSeleccionada = $this->tarifasTerrestres->find($this->destino);
        $precio= isset($tarifaSeleccionada) ? $tarifaSeleccionada->precio : null;
        $this->precio_terrestre = $precio;
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

        $presupuesto->servicios()->delete();
        foreach ($this->servicios as $servicio) {
            $presupuesto->servicios()->create([
                'titulo' => $servicio['titulo'],
                'descripcion' => $servicio['descripcion'],
            ]);
        }
        $presupuesto->generales()->delete();
        foreach ($this->generales as $general) {
            $presupuesto->generales()->create([
                'titulo' => $general['titulo'],
                'descripcion' => $general['descripcion'],
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

    public function nuevoPresupuesto()
    {
        $presupuesto = Presupuesto::create([
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
        $presupuesto->servicios()->delete();
        foreach ($this->servicios as $servicio) {
            $presupuesto->servicios()->create([
                'titulo' => $servicio['titulo'],
                'descripcion' => $servicio['descripcion'],
            ]);
        }
        $presupuesto->generales()->delete();
        foreach ($this->generales as $general) {
            $presupuesto->generales()->create([
                'titulo' => $general['titulo'],
                'descripcion' => $general['descripcion'],
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

        if ($presupuesto) {
            $this->alert('success', 'Presupuesto registrado correctamente!', [
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
            'confirmDelete',
            'nuevoPresupuesto',
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

    public function downloadPdf()
    {
        $pdf=$this->crearPdf();
        return response()->streamDownload(
        fn () => print($pdf->output()),
        'presupuesto-' . $this->identificador . '.pdf'
    );
    }
    public function crearPdf()
    {
        $presupuesto = Presupuesto::find($this->identificador);
        return $pdf = PDF::loadView('livewire.presupuestos.pdf-presupuesto', [
            'identificador' => $this->identificador,
            'presupuesto' =>$presupuesto,
            'clientes' => Cliente::all(),
            'puertos' => Puerto::all(),
            'proveedores' => Proveedor::all(),
            'tarifas'=> Tarifa::all(),
            'clienteGastos'=> $this->clienteGastos,
            'clienteNotas'=>  $this->clienteNotas,
            'tarifasSeleccionadas' => $presupuesto->Tarifas()->get()->toArray(),
            'cargo' => $presupuesto->cargosExtra()->get()->toArray(),
            'notas' => $presupuesto->notas()->get()->toArray(),
            'servicios' => $presupuesto->servicios()->get()->toArray(),
            'generales' => $presupuesto->generales()->get()->toArray(),
        ]);
    }
    public function enviarCorreo()
    {
        $presupuesto = Presupuesto::find($this->identificador);
        $cliente = Cliente::find($this->id_cliente);
        $pdf = $this->crearPdf()->output();

        Mail::to($cliente->email)->send(new PresupuestoMailable($cliente, $pdf));

        $this->alert('success', 'Correo enviado correctamente!', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => 'confirmed',
            'confirmButtonText' => 'Ok',
        ]);
    }
}
