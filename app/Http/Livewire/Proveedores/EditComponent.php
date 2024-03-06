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
    public $contacto;
    public $gastos_llegada_20;
    public $gastos_llegada_40;
    public $gastos_llegada_h4;
    public $gastos_llegada_grupage;
    public $direccion;
    public $telefono;
    public $email;

    public function mount($identificador)
    {
        $Proveedor = Proveedor::find($identificador);

        $this->identificador = $Proveedor->id;
        $this->nombre = $Proveedor->nombre;
        $this->contacto = $Proveedor->contacto;
        $this->gastos_llegada_20 = $Proveedor->gastos_llegada_20;
        $this->gastos_llegada_40 = $Proveedor->gastos_llegada_40;
        $this->gastos_llegada_h4 = $Proveedor->gastos_llegada_h4;
        $this->gastos_llegada_grupage = $Proveedor->gastos_llegada_grupage;
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
            'contacto' => 'nullable',
            'gastos_llegada_20' => 'nullable',
            'gastos_llegada_40' => 'nullable',
            'gastos_llegada_h4' => 'nullable',
            'gastos_llegada_grupage' => 'nullable',
            'direccion' => 'nullable',
            'telefono' => 'nullable',
            'email' => 'nullable|email|unique:proveedores,email,' . $this->identificador,
        ]);

        $Proveedor = Proveedor::find($this->identificador);

        $Proveedorupdated = $Proveedor->update([
            'nombre' => $this->nombre,
            'contacto' => $this->contacto,
            'gastos_llegada_20' => $this->gastos_llegada_20,
            'gastos_llegada_40' => $this->gastos_llegada_40,
            'gastos_llegada_h4' => $this->gastos_llegada_h4,
            'gastos_llegada_grupage' => $this->gastos_llegada_grupage,
            'direccion' => $this->direccion,
            'telefono' => $this->telefono,
            'email' => $this->email,
        ]);

        event(new \App\Events\LogEvent(Auth::user(), 9, $Proveedor->id));

        if ($Proveedorupdated) {
            $this->alert('success', 'Proveedor actualizado correctamente!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
                'onConfirmed' => 'confirmed',
                'showConfirmButton' => true,
                'confirmButtonText' => 'Ok',
            ]);

            $this->emitTo('proveedores.index-component', 'refresh');
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
        return redirect()->route('proveedores.index');

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
        return redirect()->route('proveedores.index');
    }
}
