<?php

namespace App\Http\Livewire\Tarifas;

use File;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Tarifa;
use App\Models\Puerto;
use App\Models\Proveedor;
use Carbon\Carbon;
use DateInterval;
use DateTime;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Maatwebsite\Excel\Facades\Excel;



class SubidaComponent extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $tipo_mar_area_terr; //tipo de tarifa maritima aerea terrestre
    public $tipo_imp_exp; // Exportación o Importación
    public $tipo_cont_grup; // Contenedor o Gupage
    public $origen_id;
    public $destino_id;
    public $precio_contenedor_20;
    public $precio_contenedor_40;
    public $precio_contenedor_h4;
    public $destinoterrestre;
    public $precio_grupage;
    public $precio_terrestre;
    public $proveedor_id;
    public $dias;
    public $cargo= [];
    public $validez;
    public $Proveedores;
    public $Puertos;

    public $cargo20;

    public $cargo40;
    public $cargoHc;
    public $cargoGrup;

    public function render()
    {
        return view('livewire.tarifas.subida-component');
    }

    public function mount()
    {
        $this->Proveedores = Proveedor::all();
        $this->Puertos = Puerto::all();

    }
    public function getListeners()
    {
        return [
            'confirmed',
            'alertaGuardar',
            'guardarTarifas',

        ];
    }



    public function guardarTarifas($tarifas)
    {
        try {

            foreach ($tarifas as $tarifaData) {
                if (empty($tarifaData['2']) && empty($tarifaData['3'])) {
                continue;  // Saltar esta iteración del bucle y no añadir la tarifa
                }
                $origen = Puerto::firstOrCreate(['Nombre' => $tarifaData['2']]);
                $destino = Puerto::firstOrCreate(['Nombre' => $tarifaData['3']]);
                $precio20 = floatval(str_replace('.', '', $tarifaData['4']));
                $precio40 = floatval(str_replace('.', '', $tarifaData['5']));
                $precioHC = floatval(str_replace('.', '', $tarifaData['6']));
                $precioGrup = floatval(str_replace('.', '', $tarifaData['7']));
                $dias =  $tarifaData['8'];

                Tarifa::create([
                    'origen_id' => $origen->id,
                    'destino_id' => $destino->id,
                    'proveedor_id' => $this->proveedor_id,
                    'tipo_mar_area_terr' => $this->tipo_mar_area_terr,
                    'tipo_imp_exp' => $this->tipo_imp_exp,
                    'tipo_cont_grup' => $this->tipo_cont_grup,
                    'precio_contenedor_20' => $precio20 + $this->cargo20,
                    'precio_contenedor_40' => $precio40+ $this->cargo40,
                    'precio_contenedor_h4' => $precioHC + $this->cargoHc,
                    'precio_grupage' => $precioGrup + $this->cargoGrup,
                    'dias' => $dias,
                    'validez' => Carbon::createFromFormat('Y-m-d', $tarifaData['0']),
                    'efectividad' => Carbon::createFromFormat('Y-m-d', $tarifaData['1']),
                ]);
            }

            $this->alert('success', 'Tarifas registradas correctamente!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => '',
                'confirmButtonText' => 'Ok',

                'timerProgressBar' => true,
            ]);
        } catch (\Exception $e) {
            $this->alert('error', '¡No se ha podido registrar las tarifas!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
            ]);
        }
    }

    public function isDateValid($date, $format = 'Y-m-d')
    {
        try {
            Carbon::createFromFormat($format, $date);
            return true;  // La fecha es válida
        } catch (\Exception $e) {
            return false;  // La fecha no es válida
        }
    }
    public function excelDateToDate($excelDateNumber) {
        $baseDate = DateTime::createFromFormat('Y-m-d', '1899-12-30'); // Fecha base de Excel (sistema de fecha de 1900)
        $date = clone $baseDate;
        $date->add(new DateInterval('P' . intval($excelDateNumber) . 'D'));
        return $date->format('Y-m-d');
    }

    public function tarifasOne()
    {
        $tarifa= false;
        $path = $this->file->store('temp');
        $data = Excel::toArray([], storage_path('app/'.$path));


         $sheets_to_process = [1,2]; // Hojas 2 y 3, los índices comienzan en 0

        foreach ($sheets_to_process as $sheet_index) {
            $sheet_data = $data[$sheet_index];

            $extra_charges_dry = 0;
            for ($i = 14; $i <= 41; $i++) {

                if (isset($sheet_data[$i]) && (strpos($sheet_data[$i][1], 'OBS') !== false || strpos($sheet_data[$i][1], 'ETS') !== false) && $sheet_data[$i][2] === 'DRY') {
                    $extra_charges_dry += floatval(str_replace('$', '', $sheet_data[$i][5]));
                }
                if (isset($sheet_data[$i]) && in_array($sheet_data[$i][1], ['SCT', 'Emergency PSS'])) {
                    $extra_charges_dry += floatval(str_replace('$', '', $sheet_data[$i][5]));
                }
            }

            $origen_col = $sheet_index == 1 ? 5 : 4; // En hoja 1 (índice 0) origen está en columna 5, en hoja 2 en columna 4
            $destino_col = $sheet_index == 1 ? 6 : 5; // En hoja 1 (índice 0) destino está en columna 6, en hoja 2 en columna 5

             for ($index = 42; $index < count($sheet_data); $index++) {
                $row = $sheet_data[$index];
                if (!empty($row[1]) && !empty($row[2])) {

                    if ($this->isDateValid($this->excelDateToDate($row[1]))) {
                        // La fecha en $row[1] es válida, procesar la fila
                        $origen = Puerto::firstOrCreate(['Nombre' => $row[$origen_col]]);
                        $destino = Puerto::firstOrCreate(['Nombre' => $row[ $destino_col]]);
                        $effective_date = Carbon::createFromFormat('Y-m-d', $this->excelDateToDate($row[1]));
                        $expiry_date = Carbon::createFromFormat('Y-m-d', $this->excelDateToDate($row[2]));

                        $tarifa = new Tarifa([
                            'origen_id' => $origen->id,
                            'destino_id' => $destino->id,
                            'precio_contenedor_20' => floatval($row[11]) + $extra_charges_dry,
                            'precio_contenedor_40' => floatval($row[12]) + (2 * $extra_charges_dry),
                            'precio_contenedor_h4' => floatval($row[13]) + (2 * $extra_charges_dry),
                        ]);
                        $tarifa->save();
                    } else {
                        // La fecha en $row[1] no es válida, manejar el error o saltar la fila
                    }
                }
            }
        }

        // Remove temp file after import
        unlink(storage_path('app/'.$path));
        $this->file = null;
        if ($tarifa) {
            $this->alert('success', 'Tarifas registradas correctamente!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => '',
                'confirmButtonText' => 'Ok',
                'timerProgressBar' => true,
            ]);

            $this->reset([
                'origen_id',
                'destino_id',
                'destinoterrestre',
                'precio_contenedor_20',
                'precio_contenedor_40',
                'precio_contenedor_h4',
                'precio_terrestre',
                'precio_grupage',
                'tipo_imp_exp',
                'tipo_cont_grup',
                'tipo_mar_area_terr',
                'proveedor_id',
                'dias',
                'cargo',
                'validez',
            ]);
        } else {
            $this->alert('error', '¡No se ha podido registrar las tarifas!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
            ]);
        }
    }
    public function tarifasHyundai()
    {

        $tarifa= false;
        $path = $this->file->store('temp');
        $data = Excel::toArray([], storage_path('app/'.$path));


         $sheets_to_process = [0]; // Hojas 2 y 3, los índices comienzan en 0

        foreach ($sheets_to_process as $sheet_index) {
            $sheet_data = $data[$sheet_index];
        dd($sheet_data[9][6]);
            $destino = Puerto::firstOrCreate(['Nombre' => $sheet_data[9][5]]); // Adjusted to 0-based index, where row 10 is index 9

             for ($index = 13; $index < count($sheet_data); $index++) {
                $row = $sheet_data[$index];
                if (!empty($row[1]) && !empty($row[2])) {

                    if ($this->isDateValid($this->excelDateToDate($row[1]))) {
                        // La fecha en $row[1] es válida, procesar la fila
                        $origen = Puerto::firstOrCreate(['Nombre' => $row[2] ,'Pais' => $row[0]]);
                        $effective_date = Carbon::createFromFormat('Y-m-d', $this->excelDateToDate($row[4]));
                        $expiry_date = Carbon::createFromFormat('Y-m-d', $this->excelDateToDate($row[5]));

                        $tarifa = new Tarifa([
                            'origen_id' => $origen->id,
                            'destino_id' => $destino->id,
                            'proveedor_id' => $this->proveedor_id,
                            'validez' => $expiry_date,
                            'tipo_mar_area_terr' => $this->tipo_mar_area_terr,
                            'tipo_imp_exp' => $this->tipo_imp_exp,
                            'tipo_cont_grup' => $this->tipo_cont_grup,
                            'precio_contenedor_20' => floatval($row[18]),
                            'precio_contenedor_40' => floatval($row[19]),
                            'precio_contenedor_h4' => floatval($row[20]),
                        ]);
                        $tarifa->save();
                    } else {
                        // La fecha en $row[1] no es válida, manejar el error o saltar la fila
                    }
                }
            }
        }

        // Remove temp file after import
        unlink(storage_path('app/'.$path));
        $this->file = null;
        if ($tarifa) {
            $this->alert('success', 'Tarifas registradas correctamente!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => '',
                'confirmButtonText' => 'Ok',
                'timerProgressBar' => true,
            ]);

            $this->reset([
                'origen_id',
                'destino_id',
                'destinoterrestre',
                'precio_contenedor_20',
                'precio_contenedor_40',
                'precio_contenedor_h4',
                'precio_terrestre',
                'precio_grupage',
                'tipo_imp_exp',
                'tipo_cont_grup',
                'tipo_mar_area_terr',
                'proveedor_id',
                'dias',
                'cargo',
                'validez',
            ]);
        } else {
            $this->alert('error', '¡No se ha podido registrar las tarifas!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
            ]);
        }
    }
}
