<?php

namespace App\Http\Livewire\Clientes;

use App\Models\Cliente;
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
        return view('livewire.clientes.create-component');
    }

    public function submit()
    {
        $validatedData = $this->validate([
            'nombre' => 'required',
            'direccion' => 'nullable',
            'telefono' => 'nullable',
            'email' => 'required|email|unique:clientes,email',
        ]);

        $cliente = Cliente::create($validatedData);

        // Registro del evento, ajusta según tu implementación actual
        event(new \App\Events\LogEvent(Auth::user(), 8, $cliente->id));

        if ($cliente) {
            $this->alert('success', '¡Cliente registrado correctamente!', [
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
            $this->alert('error', '¡No se ha podido registrar el cliente!', [
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
        return redirect()->route('clientes.index');
    }
}