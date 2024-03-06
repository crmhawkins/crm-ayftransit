<?php

namespace App\Http\Livewire\Clientes;

use App\Models\Cliente;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Illuminate\Support\Facades\Redirect;
use Ramsey\Uuid\Type\Integer;
use Illuminate\Support\Facades\Auth;

class CreateFromBudgetComponent extends Component
{

    use LivewireAlert;

    public $clientes;
    public $nombre;
    public $email;
    public $telefono;
    public $direccion;


    public function mount()
    {
        $this->clientes = Cliente::all();
    }


    public function render()
    {
        return view('livewire.clientes.create-from-budget-component');
    }

    // Al hacer submit en el formulario
    public function submit()
    {
        // Validación de datos
        $validatedData = $this->validate(
            [
                'nombre' => 'required',
                'email' => 'required|email|unique:clientes,email',
                'telefono' => 'required',
                'direccion' => 'required',
                
            ],
            // Mensajes de error
            [
                'nombre.required' => 'El nombre es obligatorio.',
                'email.required' => 'El email es obligatorio.',
                'telefono.required' => 'El telefono es obligatorio.',
                'direccion.required' => 'La dirrección es obligatoria.',
            ]
        );



        event(new \App\Events\LogEvent(Auth::user(), 8, $clienteSave->id));
        $this->ident = $clienteSave->id;
        // Alertas de guardado exitoso
        if ($clienteSave) {
            $this->alert('success', '¡Cliente registrado correctamente!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'confirmed',
                'confirmButtonText' => 'ok',
                'timerProgressBar' => true,
            ]);
        } else {
            $this->alert('error', '¡No se ha podido guardar la información del usuario!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
            ]);
        }
    }

    // Función para cuando se llama a la alerta
    public function getListeners()
    {
        return [
            'confirmed',
            'submit'
        ];
    }

    // Función para cuando se llama a la alerta
    public function confirmed()
    {
        session(['datos2' => $this->ident]);
        return redirect()->route('presupuestos.create');
    }
}
