<?php

namespace App\Http\Livewire\Puertos;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Puerto;
use Illuminate\Support\Facades\Auth;

class CreateComponent extends Component
{
    use LivewireAlert;

    public $Nombre;
    public $Pais;

    public function render()
    {
        return view('livewire.puertos.create-component');
    }

    public function submit()
    {
        $validatedData = $this->validate([
            'Pais'=> 'required',
            'Nombre'=> 'required',

        ],
        // Mensajes de error
        [
            'Pais.required'=> 'El pais del puerto es obligatorio.',
            'Nombre.required'=> 'El nombre del puerto  es obligatorio.',
        ]);

        $puerto = Puerto::create($validatedData);

        // Registro del evento, ajusta según tu implementación actual
        event(new \App\Events\LogEvent(Auth::user(), 8, $puerto->id));

        if ($puerto) {
            $this->alert('success', '¡Puerto registrado correctamente!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'confirmed',
                'confirmButtonText' => 'Ok',
                'timerProgressBar' => true,
            ]);

            // Limpieza de campos después de la inserción
            $this->reset(['Nombre', 'Pais']);
        } else {
            $this->alert('error', '¡No se ha podido registrar el puerto!', [
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
            'submit'
        ];
    }

    public function confirmed()
    {
        // Redirección tras confirmar, ajusta según tu lógica de navegación
        return redirect()->route('puertos.index');
    }
}
