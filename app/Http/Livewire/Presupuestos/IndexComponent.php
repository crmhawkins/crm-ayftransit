<?php

namespace App\Http\Livewire\Presupuestos;

use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\Evento;
use App\Models\Presupuesto;
use App\Models\TipoEvento;
use Livewire\Component;

class IndexComponent extends Component
{
    // public $search;
    public $presupuestos;
    public $clientes;
    public $eventos;
    public $empresas;
    public $tipos_eventos;
    public function mount()
    {
        $this->presupuestos = Presupuesto::all();
        $this->clientes = Cliente::all();
    }

    public function getClienteNombre($id){

        if($id == 0){
            return "Presupuesto sin cliente";
        }
        $cliente = $this->clientes->find($id);
        if(isset($cliente)){
            $nombre = $cliente->nombre;
            return $nombre;
        }else{
            return'Cliente no encontrado';
        }
    }


    public function render()
    {

        return view('livewire.presupuestos.index-component');
    }

}
