<?php

namespace App\Http\Livewire\Tarifas;

use App\Models\Tarifa;
use App\Models\Puerto;
use App\Models\Proveedor;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class CreateComponent extends Component
{
    use LivewireAlert;
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

    public function render()
    {
        return view('livewire.tarifas.create-component');
    }
    public function mount()
    {
        $this->Proveedores = Proveedor::all();
        $this->Puertos = Puerto::all();

    }
    public function getListeners()
    {
        return [
            'confirmed',
            'alertaGuardar',
            'submit'
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
    public function submit()
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

        $tarifa = Tarifa::create([
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
            'tipo_cont_grup' => $this->tipo_cont_grup,
            'dias' => $this->dias,
            'validez' => $this->validez,
        ]);

        $tarifa->cargosExtra()->delete();

        foreach ($this->cargo as $cargoExtra) {
            $tarifa->cargosExtra()->create([
                'concepto' => $cargoExtra['concepto'],
                'valor' => $cargoExtra['valor'],
            ]);
        }

        if ($tarifa) {
            $this->alert('success', 'Tarifa registrada correctamente!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => '',
                'confirmButtonText' => 'Ok',
                'timerProgressBar' => true,
            ]);

            $this->reset([
                'origen_id',
                'destino_id',
                'destinoterrestre',
                'precio_contenedor_20',
                'precio_contenedor_40',
                'precio_contenedor_h4',
                'precio_terrestre',
                'precio_grupage',
                'tipo_imp_exp',
                'tipo_cont_grup',
                'tipo_mar_area_terr',
                'proveedor_id',
                'dias',
                'cargo',
                'validez',
            ]);
        } else {
            $this->alert('error', '¡No se ha podido registrar la tarifa!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
            ]);
        }
    }
}
