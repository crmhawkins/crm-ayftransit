<?php

namespace App\Http\Livewire\Puertos;

use App\Models\Puerto;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class EditComponent extends Component
{
    use LivewireAlert;

    public $identificador;
    public $Nombre;
    public $Pais;
    public function mount($identificador)
    {
        $puerto = Puerto::find($identificador);

        $this->identificador = $puerto->id;
        $this->Nombre = $puerto->Nombre;
        $this->Pais = $puerto->Pais;

    }
    public function render()
    {
        return view('livewire.puertos.edit-component');
    }

    public function update()
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

        $puerto = Puerto::find($this->identificador);

        $puertoUpdate = $puerto->update([
            'Nombre' => $this->Nombre,
            'Pais' => $this->Pais,
        ]);

        event(new \App\Events\LogEvent(Auth::user(), 9, $puerto->id));

        if ($puertoUpdate) {
            $this->alert('success', 'Puerto actualizado correctamente!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'confirmed',
                'confirmButtonText' => 'Ok',
            ]);

            $this->emitTo('puertos.index-component', 'refresh');
            // Considera redirigir o cerrar el modal de edición según tu flujo de usuario
        } else {
            $this->alert('error', '¡No se ha podido actualizar la información del puerto!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
            ]);
        }
    }

    // Añade las funciones de alerta según sean necesarias
    public function getListeners()
    {
        return [
            'confirmDelete',
            'confirmed',
            'update',
        ];
    }

    public function confirmed()
    {
        // Implementa lo que sucederá cuando se confirme una acción (ej. redirección)
        return redirect()->route('puertos.index');
    }

    // Implementa la lógica para la confirmación de eliminación si es necesario
    public function confirmDelete()
    {
        $puerto = Puerto::find($this->identificador);
        event(new \App\Events\LogEvent(Auth::user(), 10, $puerto->id));
        $puerto->delete();
        $this->alert('success', 'Puerto eliminado correctamente.', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
            'showConfirmButton' => false,
        ]);
        return redirect()->route('puertos.index');
    }
}
