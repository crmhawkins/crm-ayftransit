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
    public $empresa;
    public $cif;
    public $seguro;
    public $direccion;
    public $telefono;
    public $email;
    public $pago;
    public $notas = [];
    public $tarifasTerrestres = [];
    public $gastosAduanas = [];

    public function render()
    {
        return view('livewire.clientes.create-component');
    }

    public function agregarNotas()
    {
        $this->notas[] = ['titulo' => '', 'descripcion' => ''];
    }
    public function eliminarNotas($index)
    {
        unset($this->notas[$index]);
        $this->notas = array_values($this->notas); // Reindexa el arreglo después de eliminar un elemento
    }   public function agregarGastosAduanas()
    {
        $this->gastosAduanas[] = ['titulo' => '', 'descripcion' => ''];
    }
    public function eliminarGastosAduanas($index)
    {
        unset($this->gastosAduanas[$index]);
        $this->gastosAduanas = array_values($this->gastosAduanas); // Reindexa el arreglo después de eliminar un elemento
    }   public function agregarTarifasTerrestres()
    {
        $this->tarifasTerrestres[] = ['destino' => '', 'precio' => ''];
    }
    public function eliminarTarifasTerrestres($index)
    {
        unset($this->tarifasTerrestres[$index]);
        $this->tarifasTerrestres = array_values($this->tarifasTerrestres); // Reindexa el arreglo después de eliminar un elemento
    }

    public function submit()
    {
        $validatedData = $this->validate([
            'empresa'=> 'required',
            'cif'=> 'required',
            'seguro'=> 'nullable',
            'pago'=> 'nullable',
            'nombre' => 'nullable',
            'direccion' => 'nullable',
            'telefono' => 'required',
            'email' => 'required|email|unique:clientes,email',
        ],
        // Mensajes de error
        [
            'empresa.required'=> 'El nombre de la empresa es obligatorio.',
            'cif.required'=> 'El CIF/DNI es obligatorio.',
            'email.required' => 'El email es obligatorio.',
            'telefono.required' => 'El telefono es obligatorio.',
        ]);

        $cliente = Cliente::create($validatedData);

        foreach ($this->gastosAduanas as $gastosAduana) {
            $cliente->gastosAduanas()->create([
                'titulo' => $gastosAduana['titulo'],
                'descripcion' => $gastosAduana['descripcion'],
            ]);
        }
        foreach ($this->tarifasTerrestres as $tarifaTerrestre) {
            $cliente->tarifasTerrestres()->create([
                'destino' => $tarifaTerrestre['destino'],
                'precio' => $tarifaTerrestre['precio'],
            ]);
        }
        foreach ($this->notas as $nota) {
            $cliente->notas()->create([
                'titulo' => $nota['titulo'],
                'descripcion' => $nota['descripcion'],
            ]);
        }
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
            $this->reset(['nombre', 'direccion', 'telefono', 'email','empresa','pago','seguro','cif']);
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
            'submit'
        ];
    }

    public function confirmed()
    {
        // Redirección tras confirmar, ajusta según tu lógica de navegación
        return redirect()->route('clientes.index');
    }
}
