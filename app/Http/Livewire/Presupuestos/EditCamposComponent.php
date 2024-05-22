<?php

namespace App\Http\Livewire\Presupuestos;


use App\Models\CondicionesGenerales;
use App\Models\NotasGenerales;
use App\Models\ServiciosGenerales;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
class EditCamposComponent extends Component
{

    use LivewireAlert;
    public $notas=[];
    public $servicios=[];
    public $generales=[];


    public function mount()
    {
        $this->notas = NotasGenerales::all()->toArray();
        $this->servicios = ServiciosGenerales::all()->toArray();
        $this->generales = CondicionesGenerales::all()->toArray();

    }
    public function render()
    {
        return view('livewire.presupuestos.edit-Campos-component');
    }
    public function agregarNota()
    {
        $this->notas[] = ['titulo' => '', 'descripcion' => ''];
    }
    public function eliminarNota($index)
    {
        unset($this->notas[$index]);
        $this->notas = array_values($this->notas); // Reindexa el arreglo después de eliminar un elemento
    }
    public function agregarServicio()
    {
        $this->servicios[] = ['titulo' => '', 'descripcion' => ''];
    }
    public function eliminarServicio($index)
    {
        unset($this->servicios[$index]);
        $this->servicios = array_values($this->servicios); // Reindexa el arreglo después de eliminar un elemento
    }
    public function agregarGenerales()
    {
        $this->generales[] = ['titulo' => '', 'descripcion' => ''];
    }
    public function eliminarGenerales($index)
    {
        unset($this->generales[$index]);
        $this->generales = array_values($this->generales); // Reindexa el arreglo después de eliminar un elemento
    }

    public function update()
    {
        try {
            // Actualiza o crea las notas generales
            NotasGenerales::query()->delete();
            foreach ($this->notas as $nota) {
                NotasGenerales::updateOrCreate(
                    ['titulo' => $nota['titulo']],
                    ['descripcion' => $nota['descripcion']]
                );
            }

            // Actualiza o crea los servicios generales
            ServiciosGenerales::query()->delete();
            foreach ($this->servicios as $servicio) {
                ServiciosGenerales::updateOrCreate(
                    ['titulo' => $servicio['titulo']],
                    ['descripcion' => $servicio['descripcion']]
                );
            }

            // Actualiza o crea las condiciones generales
            CondicionesGenerales::query()->delete();
            foreach ($this->generales as $general) {
                CondicionesGenerales::updateOrCreate(
                    ['titulo' => $general['titulo']],
                    ['descripcion' => $general['descripcion']]
                );
            }

            $this->alert('success', '!Actualizado correctamente!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'confirmed',
                'confirmButtonText' => 'Ok',
            ]);

        } catch (\Exception $e) {
            $this->alert('error', '¡No se ha podido actualizar!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
            ]);
        }
    }


    public function getListeners()
    {
        return [
            'confirmed',
            'update',
        ];
    }

    public function confirmed()
    {
        // Redirección tras confirmar, ajusta según tu lógica de navegación
        return redirect()->route('presupuestos.index');
    }

}
