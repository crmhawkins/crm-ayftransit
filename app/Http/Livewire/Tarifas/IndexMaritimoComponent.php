<?php

namespace App\Http\Livewire\Tarifas;

use Livewire\Component;
use App\Models\Tarifa;
use App\Models\Proveedor;
use App\Models\Puerto;




class IndexMaritimoComponent extends Component
{

    public $tarifas;
    public function mount()
    {
        $this->tarifas = Tarifa::where('tipo_mar_area_terr', 1)->get();
    }
    public function render()
    {
        return view('livewire.tarifas.index-maritimo-component');
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

    public function getPuerto($id)
    {
        $nombrePuerto = Puerto::find($id);
        if (isset($nombrePuerto)){
            return $nombrePuerto->Nombre ;
        }else{
            return "Puerto no definido" ;
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
