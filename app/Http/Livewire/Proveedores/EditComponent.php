<?php

namespace App\Http\Livewire\Proveedores;

use App\Models\Proveedor;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class EditComponent extends Component
{
    use LivewireAlert;

    public $identificador;
    public $nombre;
    public $direccion;
    public $telefono;
    public $email;

    public function mount($identificador)
    {
        $Proveedor = Proveedor::find($identificador);

        $this->identificador = $Proveedor->id;
        $this->nombre = $Proveedor->nombre;
        $this->direccion = $Proveedor->direccion ?? '';
        $this->telefono = $Proveedor->telefono ?? '';
        $this->email = $Proveedor->email;
    }

    public function render()
    {
        return view('livewire.proveedores.edit-component');
    }

    public function update()
    {
        $validatedData = $this->validate([
            'nombre' => 'required',
            'direccion' => 'nullable',
            'telefono' => 'nullable',
            'email' => 'required|email|unique:Proveedor,email,' . $this->identificador,
        ]);

        $Proveedor = Proveedor::find($this->identificador);

        $Proveedor = $Proveedor->update([
            'nombre' => $this->nombre,
            'direccion' => $this->direccion,
            'telefono' => $this->telefono,
            'email' => $this->email,
        ]);

        event(new \App\Events\LogEvent(Auth::user(), 9, $Proveedor->id));

        if ($Proveedor) {
            $this->alert('success', 'Proveedor actualizado correctamente!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
                'showConfirmButton' => true,
                'confirmButtonText' => 'Ok',
            ]);

            $this->emitTo('Proveedor.index-component', 'refresh');
            // Considera redirigir o cerrar el modal de edición según tu flujo de usuario
        } else {
            $this->alert('error', '¡No se ha podido actualizar la información del Proveedor!', [
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
        return redirect()->route('Proveedor.index');
    }

    // Implementa la lógica para la confirmación de eliminación si es necesario
    public function confirmDelete()
    {
        $Proveedor = Proveedor::find($this->identificador);
        event(new \App\Events\LogEvent(Auth::user(), 10, $Proveedor->id));
        $Proveedor->delete();
        $this->alert('success', 'Proveedor eliminado correctamente.', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
            'showConfirmButton' => false,
        ]);
        return redirect()->route('Proveedor.index');
    }
}
