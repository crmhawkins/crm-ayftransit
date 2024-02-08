<?php

namespace App\Http\Livewire\Proveedores;

use App\Models\Proveedor;
use Livewire\Component;

class IndexComponent extends Component
{

    public $Proveedores;

    public function mount()
    {
        $this->Proveedores = Proveedor::all();
    }
    public function render()
    {
        return view('livewire.proveedores.index-component');
    }
}
