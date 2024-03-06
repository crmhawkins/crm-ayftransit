<?php

namespace App\Http\Livewire\Tarifas;

use Livewire\Component;
use App\Models\Tarifa;
use App\Models\Proveedor;

class IndexTerrestreComponent extends Component
{
    public $tarifas;
    public function mount()
    {
        $this->tarifas = Tarifa::where('tipo_mar_area_terr', 3)->get();
    }
    public function render()
    {
        return view('livewire.tarifas.index-terrestre-component');
    }
    public function getProveedor($id)
    {
        $nombreProvedor = Proveedor::find($id)->nombre;
        if (isset($nombreProvedor)){
            return $nombreProvedor ;
        }else{
            return "Proveedor no definido" ;
        }
    }

}
