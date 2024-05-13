<?php

namespace App\Http\Livewire\Tarifas;

use Livewire\Component;
use App\Models\Tarifa;
use App\Models\Proveedor;

class IndexAereoComponent extends Component
{
    public $tarifas;
    public function mount()
    {
        $this->tarifas = Tarifa::where('tipo_mar_area_terr', 2)->get();
    }
    public function render()
    {
        return view('livewire.tarifas.index-aereo-component');
    }

    public function getProveedor($id)
    {
        $nombreProvedor = Proveedor::find($id);
        if (isset($nombreProvedor)){
            return $nombreProvedor->nombre ;
        }else{
            return "Proveedor no definido" ;
        }
    }
    public function tipo($id)
    {
        if ($id == 1){
            return "Importación" ;
        }elseif($id == 2){
            return "Exportación" ;
        }else{
            return "No Definido";
        }
    }
}
