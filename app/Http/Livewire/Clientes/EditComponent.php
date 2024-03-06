<?php

namespace App\Http\Livewire\Clientes;

use App\Models\Cliente;
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
    public $empresa;
    public $cif;
    public $seguro;
    public $pago;

    public function mount($identificador)
    {
        $cliente = Cliente::find($identificador);

        $this->identificador = $cliente->id;
        $this->nombre = $cliente->nombre;
        $this->direccion = $cliente->direccion ?? '';
        $this->telefono = $cliente->telefono ?? '';
        $this->email = $cliente->email;
        $this->empresa = $cliente->empresa;
        $this->cif = $cliente->cif;
        $this->seguro = $cliente->seguro;
        $this->pago = $cliente->pago;
    }

    public function render()
    {
        return view('livewire.clientes.edit-component');
    }

    public function update()
    {
        $validatedData = $this->validate([
            'empresa'=> 'required',
            'cif'=> 'required',
            'seguro'=> 'nullable',
            'pago'=> 'nullable',
            'nombre' => 'required',
            'direccion' => 'nullable',
            'telefono' => 'nullable',
            'email' => 'required|email|unique:clientes,email,'. $this->identificador,
        ]);

        $cliente = Cliente::find($this->identificador);

        $clienteUpdate = $cliente->update([
            'nombre' => $this->nombre,
            'direccion' => $this->direccion,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'empresa'=> $this->empresa,
            'cif'=> $this->cif,
            'seguro'=> $this->seguro,
            'pago'=> $this->pago,
        ]);

        event(new \App\Events\LogEvent(Auth::user(), 9, $cliente->id));

        if ($clienteUpdate) {
            $this->alert('success', 'Cliente actualizado correctamente!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'confirmed',
                'confirmButtonText' => 'Ok',
            ]);

            $this->emitTo('clientes.index-component', 'refresh');
            // Considera redirigir o cerrar el modal de edición según tu flujo de usuario
        } else {
            $this->alert('error', '¡No se ha podido actualizar la información del cliente!', [
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
        return redirect()->route('clientes.index');
    }

    // Implementa la lógica para la confirmación de eliminación si es necesario
    public function confirmDelete()
    {
        $cliente = Cliente::find($this->identificador);
        event(new \App\Events\LogEvent(Auth::user(), 10, $cliente->id));
        $cliente->delete();
        $this->alert('success', 'Cliente eliminado correctamente.', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
            'showConfirmButton' => false,
        ]);
        return redirect()->route('clientes.index');
    }
}
