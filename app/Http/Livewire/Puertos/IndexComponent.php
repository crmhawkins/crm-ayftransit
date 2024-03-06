<?php

namespace App\Http\Livewire\Puertos;

use Livewire\Component;
use App\Models\Puerto;


class IndexComponent extends Component
{
    public $puertos;
    public function mount()
    {
        $this->puertos = Puerto::all();
    }
    public function render()
    {
        return view('livewire.puertos.index-component');
    }
}
