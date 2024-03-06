<?php

namespace App\Http\Livewire\Tarifas;

use App\Models\Tarifa;
use App\Models\CargosExtra;
use App\Models\Puerto;
use App\Models\Proveedor;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;


class EditComponent extends Component
{
    use LivewireAlert;
    public $identificador;
    public $tipo_mar_area_terr; //tipo de tarifa maritima aerea terrestre
    public $tipo_imp_exp; // Exportación o Importación
    public $tipo_cont_grup; // Contenedor o Gupage
    public $origen_id;
    public $destino_id;
    public $precio_contenedor_20;
    public $precio_contenedor_40;
    public $precio_contenedor_h4;
    public $destinoterrestre;
    public $precio_grupage;
    public $precio_terrestre;
    public $proveedor_id;
    public $dias;
    public $cargo= [];
    public $validez;
    public $Proveedores;
    public $Puertos;

    public function mount($identificador)
    {
        $tarifa = Tarifa::find($identificador);
        $this->Proveedores = Proveedor::all();
        $this->Puertos = Puerto::all();
        $this->identificador = $tarifa->id;
        $this->origen_id = $tarifa->origen_id;
        $this->destino_id = $tarifa->destino_id;
        $this->destinoterrestre = $tarifa->destinoterrestre;
        $this->precio_contenedor_20 = $tarifa->precio_contenedor_20;
        $this->precio_contenedor_40 = $tarifa->precio_contenedor_40;
        $this->precio_contenedor_h4 = $tarifa->precio_contenedor_h4;
        $this->precio_terrestre = $tarifa->precio_terrestre;
        $this->precio_grupage = $tarifa->precio_grupage;
        $this->tipo_imp_exp = $tarifa->tipo_imp_exp;
        $this->tipo_cont_grup = $tarifa->tipo_cont_grup;
        $this->tipo_mar_area_terr = $tarifa->tipo_mar_area_terr;
        $this->proveedor_id = $tarifa->proveedor_id;
        $this->dias = $tarifa->dias;
        $this->validez = $tarifa->validez;
        $this->cargo = $tarifa->cargosExtra->toArray();
    }
    public function render()
    {
        return view('livewire.tarifas.edit-component');
    }

    public function getListeners()
    {
        return [
            'confirmed',
            'alertaGuardar',
            'update'
        ];
    }

    public function agregarCargoExtra()
    {
        $this->cargo[] = ['concepto' => '', 'valor' => ''];
    }
    public function eliminarCargoExtra($index)
    {
        unset($this->cargo[$index]);
        $this->cargo = array_values($this->cargo); // Reindexa el arreglo después de eliminar un elemento
    }

    public function update()
    {
        $validatedData = $this->validate([
            'origen_id'=> 'nullable',
            'destino_id'=> 'nullable',
            'destinoterrestre'=> 'nullable',
            'precio_contenedor_20'=> 'nullable',
            'precio_contenedor_40'=> 'nullable',
            'precio_contenedor_h4'=> 'nullable',
            'precio_terrestre'=> 'nullable',
            'precio_grupage'=> 'nullable',
            'tipo_imp_exp'=> 'nullable',
            'tipo_cont_grup'=> 'nullable',
            'tipo_mar_area_terr'=> 'nullable',
            'proveedor_id'=> 'nullable',
            'dias'=> 'nullable',
            'validez'=> 'nullable',
        ]);
        $tarifa = Tarifa::find($this->identificador);

        $puertoTarifa = $tarifa->update([
            'tipo_mar_area_terr' => $this->tipo_mar_area_terr,
            'tipo_imp_exp' => $this->tipo_imp_exp,
            'proveedor_id' => $this->proveedor_id,
            'origen_id' => $this->origen_id,
            'destino_id' => $this->destino_id,
            'destinoterrestre' => $this->destinoterrestre,
            'precio_contenedor_20' => $this->precio_contenedor_20,
            'precio_contenedor_40' => $this->precio_contenedor_40,
            'precio_contenedor_h4' => $this->precio_contenedor_h4,
            'precio_terrestre' => $this->precio_terrestre,
            'precio_grupage' => $this->precio_grupage,
            'cargo' => $this->cargo,
            'tipo_cont_grup' => $this->tipo_cont_grup,
            'validez' => $this->validez,
        ]);

        $tarifa->cargosExtra()->delete();

        foreach ($this->cargo as $cargoExtra) {
            $tarifa->cargosExtra()->create([
                'concepto' => $cargoExtra['concepto'],
                'valor' => $cargoExtra['valor'],
            ]);
        }

        if ($puertoTarifa) {
            $this->alert('success', 'Tarifa actualizada correctamente!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'confirmed',
                'confirmButtonText' => 'Ok',
                'timerProgressBar' => true,
            ]);

        } else {
            $this->alert('error', '¡No se ha podido actualizar la tarifa!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
            ]);
        }
    }
    public function confirmed()
    {
        switch($this->tipo_mar_area_terr){
        case 1:
            return redirect()->route('tarifas.index-maritimo');
        case 2:
            return redirect()->route('tarifas.index-aereo');
        case 3:
            return redirect()->route('tarifas.index-terrestre');

        }
    }
}

