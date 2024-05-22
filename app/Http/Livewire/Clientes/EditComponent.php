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
    public $notas = [];
    public $tarifasTerrestres = [];
    public $gastosAduanas = [];
    public $notasToDelete = [];
    public $tarifasTerrestresToDelete = [];
    public $gastosAduanasToDelete = [];

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
        $this->notas = $cliente->notas()->get()->toArray();
        $this->gastosAduanas = $cliente->gastosAduanas()->get()->toArray();
        $this->tarifasTerrestres = $cliente->tarifasTerrestres()->get()->toArray();
    }

    public function render()
    {
        return view('livewire.clientes.edit-component');
    }

    public function agregarNotas()
    {
        $this->notas[] = ['id' => null, 'titulo' => '', 'descripcion' => ''];
    }

    public function eliminarNotas($index)
    {
        if (isset($this->notas[$index]['id'])) {
            $this->notasToDelete[] = $this->notas[$index]['id'];
        }
        unset($this->notas[$index]);
        $this->notas = array_values($this->notas); // Reindexa el arreglo después de eliminar un elemento
    }

    public function agregarGastosAduanas()
    {
        $this->gastosAduanas[] = ['id' => null, 'titulo' => '', 'descripcion' => ''];
    }

    public function eliminarGastosAduanas($index)
    {
        if (isset($this->gastosAduanas[$index]['id'])) {
            $this->gastosAduanasToDelete[] = $this->gastosAduanas[$index]['id'];
        }
        unset($this->gastosAduanas[$index]);
        $this->gastosAduanas = array_values($this->gastosAduanas); // Reindexa el arreglo después de eliminar un elemento
    }

    public function agregarTarifasTerrestres()
    {
        $this->tarifasTerrestres[] = ['id' => null, 'destino' => '', 'precio' => ''];
    }

    public function eliminarTarifasTerrestres($index)
    {
        if (isset($this->tarifasTerrestres[$index]['id'])) {
            $this->tarifasTerrestresToDelete[] = $this->tarifasTerrestres[$index]['id'];
        }
        unset($this->tarifasTerrestres[$index]);
        $this->tarifasTerrestres = array_values($this->tarifasTerrestres); // Reindexa el arreglo después de eliminar un elemento
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
            'email' => 'required|email|unique:clientes,email,' . $this->identificador,
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

        $this->updateOrCreateEntities($cliente, 'gastosAduanas', $this->gastosAduanasToDelete);
        $this->updateOrCreateEntities($cliente, 'tarifasTerrestres', $this->tarifasTerrestresToDelete);
        $this->updateOrCreateEntities($cliente, 'notas', $this->notasToDelete);

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

        } else {
            $this->alert('error', '¡No se ha podido actualizar la información del cliente!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
            ]);
        }
    }

    private function updateOrCreateEntities($cliente, $relation, $entitiesToDelete)    {
        $existingIds = $cliente->$relation()->pluck('id')->toArray();
        $updatedIds = [];

        foreach ($this->$relation as $entity) {
            if (isset($entity['_delete'])) {
                $cliente->$relation()->where('id', $entity['id'])->delete();
            } else {
                $updatedEntity = $cliente->$relation()->updateOrCreate(
                    ['id' => $entity['id']],
                    array_filter($entity, function ($key) {
                        return $key !== 'id';
                    }, ARRAY_FILTER_USE_KEY)
                );
                $updatedIds[] = $updatedEntity->id;
            }
        }
        // Delete entities that are not in the updated list
        $toDeleteIds = array_diff($existingIds, $updatedIds);
        $cliente->$relation()->whereIn('id', array_merge($toDeleteIds, $entitiesToDelete))->delete();
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
        $cliente->notas()->delete();
        $cliente->gastosAduanas()->delete();
        $cliente->tarifasTerrestres()->delete();
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
