<?php

namespace App\Http\Livewire\Proveedores;

use App\Models\Proveedor;
use App\Models\ProveedorGasto;
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

    public $concepto;
    public $gasto_20;
    public $gasto_40;
    public $gasto_h4;
    public $gasto_grupage;

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
        return view('livewire.proveedores.edit-component', [
            'gastos_adicionales' => ProveedorGasto::where('proveedor_id', $this->identificador)->get(),
        ]);
    }

    public function addGasto()
    {
        $validated = $this->validate([
            'concepto' => 'required',
        ],[
            'concepto.required' => 'El concepto es obligatorio.',
        ]);

        ProveedorGasto::create([
            'proveedor_id' => $this->identificador,
            'concepto' => $this->concepto,
            'gasto_20' => empty($this->gasto_20) ? null : $this->gasto_20,
            'gasto_40' => empty($this->gasto_40) ? null : $this->gasto_40,
            'gasto_h4' => empty($this->gasto_h4) ? null : $this->gasto_h4,
            'gasto_grupage' => empty($this->gasto_grupage) ? null : $this->gasto_grupage,
        ]);

        $this->resetGastoFields();
    }

    public function removeGasto($id)
    {
        ProveedorGasto::find($id)->delete();
    }

    public function resetGastoFields()
    {
        $this->concepto = '';
        $this->gasto_20 = '';
        $this->gasto_40 = '';
        $this->gasto_h4 = '';
        $this->gasto_grupage = '';
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
        } else {
            $this->alert('error', '¡No se ha podido actualizar la información del Proveedor!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
            ]);
        }
    }

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
        return redirect()->route('proveedores.index');
    }

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
