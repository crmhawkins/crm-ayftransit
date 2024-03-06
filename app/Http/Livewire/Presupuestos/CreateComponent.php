<?php

namespace App\Http\Livewire\Presupuestos;

use App\Models\Cliente;
use App\Models\Proveedor;
use App\Models\Presupuesto;
use Barryvdh\DomPDF\Facade\Pdf;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


use function PHPUnit\Framework\isEmpty;

class CreateComponent extends Component
{

    use LivewireAlert;
    public $clientes;
    public $proveedores;
    public $id_cliente;
    public $id_proveedor;
    public $origen;
    public $destino;
    public $cliente;
    public $estado;



    public function mount()
    {
        $this->clientes = Cliente::all(); // datos que se envian al select2
        $this->proveedores = Proveedor::all();
    }

    public function render()
    {
        return view('livewire.presupuestos.create-component');
    }

}
