<?php

namespace App\Http\Livewire\Proveedores;

use App\Models\Proveedor;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CreateComponent extends Component
{
    use LivewireAlert;

    public $nombre;
    public $direccion;
    public $telefono;
    public $email;

    public function render()
    {
        return view('livewire.proveedores.create-component');
    }

    public function submit()
    {
        $validatedData = $this->validate([
            'nombre' => 'required',
            'direccion' => 'nullable',
            'telefono' => 'nullable',
            'email' => 'required|email|unique:Proveedor,email',
        ]);

        $Proveedor = Proveedor::create($validatedData);

        // Registro del evento, ajusta según tu implementación actual
        event(new \App\Events\LogEvent(Auth::user(), 8, $Proveedor->id));

        if ($Proveedor) {
            $this->alert('success', 'Proveedor registrado correctamente!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => '',
                'confirmButtonText' => 'Ok',
                'timerProgressBar' => true,
            ]);

            // Limpieza de campos después de la inserción
            $this->reset(['nombre', 'direccion', 'telefono', 'email']);
        } else {
            $this->alert('error', '¡No se ha podido registrar el proveedor!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
            ]);
        }
    }

    // Asegúrate de que tus listeners estén correctamente configurados
    public function getListeners()
    {
        return [
            'confirmed',
        ];
    }

    public function confirmed()
    {
        // Redirección tras confirmar, ajusta según tu lógica de navegación
        return redirect()->route('proveedores.index');
    }
}