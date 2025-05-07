<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarifa;
use App\Models\Puerto; // Asegúrate de que el modelo Puerto existe y el namespace es correcto
use App\Models\Proveedor; // Asegúrate de que el modelo Proveedor existe y el namespace es correcto
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;

class TarifaImportController extends Controller
{
    /**
     * Muestra el formulario para importar tarifas.
     */
    public function showImportForm()
    {
        $proveedores = [
            'one_med_north_spain' => 'ONE',
            'hmm_fe4' => 'HMM',
            'generic_feb_quincena' => 'OPERINTER',
            'generic_far_east_pod_espana' => 'MSC ASECOMEX',
        ];
        return view('tarifa.import', compact('proveedores'));
    }

    /**
     * Maneja la subida e importación del archivo Excel.
     */
    public function handleImport(Request $request)
    {
        $request->validate([
            'tipo_mar_area_terr' => 'required|integer|in:1,2,3',
            'tipo_imp_exp' => 'required|integer|in:1,2',
            'tipo_cont_grup' => 'required|integer|in:1,2',
            'proveedor' => 'required|string|in:one_med_north_spain,hmm_india,hmm_fe4,generic_feb_quincena,generic_far_east_pod_espana',
            'tarifa_excel' => 'required|file|mimes:xlsx,xls',
            // Validar campos de suma (opcionales, numéricos)
            'cargo20' => 'nullable|numeric',
            'cargo40' => 'nullable|numeric',
            'cargoHc' => 'nullable|numeric',
            'cargoGrup' => 'nullable|numeric',
        ]);

        $proveedorFormato = $request->input('proveedor');
        $file = $request->file('tarifa_excel');
        $filePath = $file->getRealPath();

        // Campos adicionales del formulario
        $additionalData = [
            'tipo_mar_area_terr' => $request->input('tipo_mar_area_terr'),
            'tipo_imp_exp' => $request->input('tipo_imp_exp'),
            'tipo_cont_grup' => $request->input('tipo_cont_grup'),
        ];

        // Campos de suma del formulario (convertir a float, default 0 si es null)
        $sumData = [
            'cargo20' => (float) $request->input('cargo20', 0),
            'cargo40' => (float) $request->input('cargo40', 0),
            'cargoHc' => (float) $request->input('cargoHc', 0),
            'cargoGrup' => (float) $request->input('cargoGrup', 0),
        ];

        Log::info("Iniciando importación para proveedor/formato: {$proveedorFormato} desde archivo: {$file->getClientOriginalName()} con datos adicionales: ", $additionalData);
        Log::info("Cantidades a sumar: ", $sumData);

        DB::beginTransaction();
        try {
            $spreadsheet = IOFactory::load($filePath);

            switch ($proveedorFormato) {
                case 'one_med_north_spain':
                    $this->parseOneMedNorthSpain($spreadsheet, $additionalData, $sumData);
                    break;
                case 'hmm_india':
                    $this->parseHmmIndia($spreadsheet, $additionalData, $sumData);
                    break;
                case 'hmm_fe4':
                    $this->parseHmmFe4($spreadsheet, $additionalData, $sumData);
                    break;
                case 'generic_feb_quincena':
                    $this->parseGenericFebQuincena($spreadsheet, $additionalData, $sumData);
                    break;
                case 'generic_far_east_pod_espana':
                     $this->parseGenericFarEastPodEspana($spreadsheet, $additionalData, $sumData);
                     break;
                default:
                    throw new \Exception("Proveedor/Formato no soportado: {$proveedorFormato}");
            }

            DB::commit();
            Log::info("Importación completada con éxito para proveedor/formato: {$proveedorFormato}");
            return redirect()->route('tarifas.import.form')->with('success', 'Tarifas importadas correctamente.');

        } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
            DB::rollBack();
            Log::error("Error de PhpSpreadsheet durante la importación: " . $e->getMessage() . " en " . $e->getFile() . ":" . $e->getLine());
            return redirect()->route('tarifas.import.form')->with('error', 'Error al leer el archivo Excel: ' . $e->getMessage());
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            Log::error("Error de Base de Datos durante la importación: " . $e->getMessage() . " (SQL: " . $e->getSql() . ")" . " en " . $e->getFile() . ":" . $e->getLine());
            return redirect()->route('tarifas.import.form')->with('error', 'Error de base de datos durante la importación. Verifica que los datos (puertos, proveedores) existan o sean correctos.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error general durante la importación para proveedor/formato: {$proveedorFormato}. Error: " . $e->getMessage() . " en " . $e->getFile() . ":" . $e->getLine());
            return redirect()->route('tarifas.import.form')->with('error', 'Error durante la importación: ' . $e->getMessage());
        }
    }

    // --- Métodos Helper ---

    /**
     * Busca o crea un Puerto y devuelve su ID.
     */
    private function findOrCreatePuerto($puertoName)
    {
        if (empty($puertoName)) return null;
        $trimmedName = trim($puertoName);
        // Intenta buscar por nombre exacto primero (case-insensitive podría ser mejor)
        $puerto = Puerto::whereRaw('LOWER(Nombre) = ?', [strtolower($trimmedName)])->first();

        if (!$puerto) {
            Log::warning("Puerto no encontrado: '{$trimmedName}'. Se omite o se requiere creación manual.");
            // Opcional: Crear puerto si no existe
            $puerto = Puerto::create(['Nombre' => $trimmedName]);
            if($puerto){
                Log::info("Puerto creado: '{$trimmedName}' con ID: {$puerto->id}");
            }else{
                Log::warning("Puerto no creado: '{$trimmedName}'.");
            }
            //return null; // O lanzar excepción si es mandatorio que exista
        }
        return $puerto->id;
    }

    /**
     * Busca o crea un Proveedor y devuelve su ID.
     */
    private function findOrCreateProveedor($proveedorName)
    {
        if (empty($proveedorName)) return null;
        $trimmedName = trim($proveedorName);
        // Asume que el campo se llama 'nombre' (case-insensitive podría ser mejor)
        $proveedor = Proveedor::whereRaw('LOWER(nombre) = ?', [strtolower($trimmedName)])->first();

        // Si no se encuentra por nombre, podrías intentar buscar por código u otro campo
        // if (!$proveedor && ...) { ... }

        if (!$proveedor) {
            //Log::warning("Proveedor no encontrado: '{$trimmedName}'. Se omite o se requiere creación manual.");
            // Opcional: Crear proveedor si no existe
            $proveedor = Proveedor::create(['nombre' => $trimmedName, /* otros campos */]);
            Log::info("Proveedor creado: '{$trimmedName}' con ID: {$proveedor->id}");
           // return null; // O lanzar excepción
        }
        return $proveedor->id;
    }

    /**
     * Helper para parsear diferentes formatos de validez.
     */
    private function parseValidity($validityString, $format = null)
    {
        $validez = null; // Fecha inicio
        $efectividad = null; // Fecha fin

        if (empty($validityString)) {
            return ['validez' => null, 'efectividad' => null];
        }

        try {
            // Formato 'DD/MM/YYYY A DD/MM/YYYY' o 'DD/MM/YYYY al DD/MM/YYYY'
            if (preg_match('/(\d{1,2}\/\d{1,2}\/\d{4})\s*(?:A|al)\s*(\d{1,2}\/\d{1,2}\/\d{4})/i', $validityString, $matches)) {
                $dateFormat = $format ?? 'd/m/Y';
                $validez = Carbon::createFromFormat($dateFormat, trim($matches[1]))->startOfDay();
                $efectividad = Carbon::createFromFormat($dateFormat, trim($matches[2]))->endOfDay();
            }
            // Formato 'DD.MM - DD.MM.YYYY'
            elseif (preg_match('/(\d{1,2}\.\d{1,2})\s*-\s*(\d{1,2}\.\d{1,2}\.\d{4})/i', $validityString, $matches)) {
                $yearPart = Carbon::createFromFormat('d.m.Y', trim($matches[2]));
                $year = $yearPart->year;
                $startStr = trim($matches[1]) . '.' . $year;
                $endStr = trim($matches[2]);
                $validez = Carbon::createFromFormat('d.m.Y', $startStr)->startOfDay();
                $efectividad = Carbon::createFromFormat('d.m.Y', $endStr)->endOfDay();
            }
            // Formato 'DD/MM - DD/MM/YYYY'
            elseif (preg_match('/(\d{1,2}\/\d{1,2})\s*-\s*(\d{1,2}\/\d{1,2}\/\d{4})/i', $validityString, $matches)) {
                 $yearPart = Carbon::createFromFormat('d/m/Y', trim($matches[2]));
                 $year = $yearPart->year;
                 $startStr = trim($matches[1]) . '/' . $year;
                 $endStr = trim($matches[2]);
                 $validez = Carbon::createFromFormat('d/m/Y', $startStr)->startOfDay();
                 $efectividad = Carbon::createFromFormat('d/m/Y', $endStr)->endOfDay();
            }
            // Formato Fecha Excel (Numérico) o DateTime Object
            elseif (is_numeric($validityString) || $validityString instanceof \DateTime || $validityString instanceof Carbon) {
                 $dateObject = is_numeric($validityString) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($validityString) : $validityString;
                 $carbonDate = Carbon::instance($dateObject);

                 // Si es F_INICIO (solo fecha inicio)
                 if ($format === 'F_INICIO') {
                     $validez = $carbonDate->copy()->startOfDay();
                     $efectividad = $validez->copy()->endOfMonth(); // Asumir fin de mes
                     Log::warning("Validez solo con fecha inicio (F_INICIO) detectada: '{$validez->toDateString()}'. Asumiendo fin de mes.");
                 }
                 // Si es fecha fin (ej. 'Valid till' en ONE)
                 else {
                     $efectividad = $carbonDate->copy()->endOfDay();
                     $validez = $efectividad->copy()->startOfMonth(); // Asumir inicio de mes
                     Log::warning("Validez solo con fecha fin detectada: '{$efectividad->toDateString()}'. Asumiendo inicio de mes.");
                 }
            }
            else {
                Log::warning("Formato de validez no reconocido: '{$validityString}'");
            }

        } catch (\Exception $e) {
            Log::error("Error parseando validez '{$validityString}': " . $e->getMessage());
            return ['validez' => null, 'efectividad' => null];
        }

        return ['validez' => $validez, 'efectividad' => $efectividad];
    }

    /**
     * Convierte valor a float, manejando separadores de miles y decimales.
     */
    private function parseFloatValue($value)
    {
        if ($value === null || $value === '') return null;
        // Eliminar espacios y símbolo de moneda si existe
        $cleanedValue = preg_replace('/[\s\$\€]/', '', $value);
        // Reemplazar coma decimal por punto
        $cleanedValue = str_replace(',', '.', $cleanedValue);
        // Eliminar puntos de miles (si los hubiera después de la coma decimal)
        // Esta parte es delicada, asume que el último punto es el decimal si no hay coma
        // Si hay múltiples puntos, podría fallar. Mejorar si es necesario.
        if (substr_count($cleanedValue, '.') > 1) {
             $cleanedValue = str_replace('.', '', substr($cleanedValue, 0, strrpos($cleanedValue, '.'))) . substr($cleanedValue, strrpos($cleanedValue, '.'));
        }

        return is_numeric($cleanedValue) ? (float) $cleanedValue : null;
    }

    // --- Métodos de Parseo Específicos ---

    private function parseOneMedNorthSpain($spreadsheet, $additionalData, $sumData)
    {
        Log::info("Parseando formato 'one_med_north_spain'");
        $sheetNames = ['ASIA OCEANIA - MED', 'JAPAN - MED', 'ASIA OCEANIA - N.SPAIN', 'JAPAN - N.SPAIN'];
        $proveedorId = $this->findOrCreateProveedor('OCEAN NETWORK EXPRESS');

        foreach ($sheetNames as $sheetName) {
            if ($spreadsheet->sheetExists($sheetName)) {
                $sheet = $spreadsheet->getSheetByName($sheetName);
                $highestRow = $sheet->getHighestRow();
                $startRow = 18; // Ajustar según inspección real

                for ($row = $startRow; $row <= $highestRow; $row++) {
                    $polName = $sheet->getCell('B' . $row)->getValue();
                    $podName = $sheet->getCell('C' . $row)->getValue();
                    $dv20Excel = $this->parseFloatValue($sheet->getCell('G' . $row)->getCalculatedValue());
                    $dv40Excel = $this->parseFloatValue($sheet->getCell('H' . $row)->getCalculatedValue());
                    $hc40Excel = $this->parseFloatValue($sheet->getCell('I' . $row)->getCalculatedValue());
                    $validityCell = $sheet->getCell('F' . $row)->getValue(); // Fecha fin
                    $transitTime = $sheet->getCell('E' . $row)->getValue();

                    $origenId = $this->findOrCreatePuerto($polName);
                    $destinoId = $this->findOrCreatePuerto($podName);

                    if (empty($origenId) || empty($destinoId) || ($dv20Excel === null && $dv40Excel === null && $hc40Excel === null)) {
                        Log::warning("Fila {$row} en hoja '{$sheetName}' (ONE) omitida por datos incompletos o inválidos (Origen: {$polName}, Destino: {$podName}).");
                        continue;
                    }

                    $validityDates = $this->parseValidity($validityCell);

                    Tarifa::create(array_merge($additionalData, [
                        'origen_id' => $origenId,
                        'destino_id' => $destinoId,
                        'proveedor_id' => $proveedorId,
                        'precio_contenedor_20' => ($dv20Excel !== null) ? $dv20Excel + $sumData['cargo20'] : null,
                        'precio_contenedor_40' => ($dv40Excel !== null) ? $dv40Excel + $sumData['cargo40'] : null,
                        'precio_contenedor_h4' => ($hc40Excel !== null) ? $hc40Excel + $sumData['cargoHc'] : null,
                        'precio_grupage' => ($additionalData['tipo_cont_grup'] === 'Grupaje') ? $sumData['cargoGrup'] : null, // Sumar solo si es grupaje, no hay valor base en este excel
                        'dias' => is_numeric($transitTime) ? (int)$transitTime : null,
                        'validez' => $validityDates['validez'],
                        'efectividad' => $validityDates['efectividad'],
                    ]));
                }
            } else {
                 Log::warning("Hoja '{$sheetName}' no encontrada en el archivo 'one_med_north_spain'.");
            }
        }
        Log::info("Parseo de 'one_med_north_spain' finalizado.");
    }

    private function parseHmmIndia($spreadsheet, $additionalData, $sumData)
    {
        Log::info("Parseando formato 'hmm_india'");
        $sheet = $spreadsheet->getActiveSheet();
        $highestRow = $sheet->getHighestRow();
        $startRow = 14; // Ajustar
        $proveedorId = $this->findOrCreateProveedor('HMM');

        $generalValidity = $sheet->getCell('B1')->getValue();
        $validityDates = $this->parseValidity($generalValidity, 'd/m - d/m/Y'); // Ajustar formato

        for ($row = $startRow; $row <= $highestRow; $row++) {
            $polName = $sheet->getCell('A' . $row)->getValue();
            $podName = $sheet->getCell('B' . $row)->getValue();
            $dv20Excel = $this->parseFloatValue($sheet->getCell('Y' . $row)->getCalculatedValue());
            $dv40Excel = $this->parseFloatValue($sheet->getCell('Z' . $row)->getCalculatedValue());
            $hc40Excel = $this->parseFloatValue($sheet->getCell('AA' . $row)->getCalculatedValue());

            $destinoId = $this->findOrCreatePuerto($polName);
            $origenId = $this->findOrCreatePuerto($podName);

            if (empty($origenId) || empty($destinoId) || ($dv20Excel === null && $dv40Excel === null && $hc40Excel === null)) {
                Log::warning("Fila {$row} en hoja '{$sheet->getTitle()}' (HMM India) omitida por datos incompletos o inválidos (Origen: {$polName}, Destino: {$podName}).");
                continue;
            }

            Tarifa::create(array_merge($additionalData, [
                'origen_id' => $origenId,
                'destino_id' => $destinoId,
                'proveedor_id' => $proveedorId,
                'precio_contenedor_20' => ($dv20Excel !== null) ? $dv20Excel + $sumData['cargo20'] : null,
                'precio_contenedor_40' => ($dv40Excel !== null) ? $dv40Excel + $sumData['cargo40'] : null,
                'precio_contenedor_h4' => ($hc40Excel !== null) ? $hc40Excel + $sumData['cargoHc'] : null,
                'precio_grupage' => ($additionalData['tipo_cont_grup'] === 'Grupaje') ? $sumData['cargoGrup'] : null,
                'validez' => $validityDates['validez'],
                'efectividad' => $validityDates['efectividad'],
            ]));
        }
        Log::info("Parseo de 'hmm_india' finalizado.");
    }

    private function parseHmmFe4($spreadsheet, $additionalData, $sumData)
    {
        Log::info("Parseando formato 'HMM'");
        $sheetNames = ['ESALG', 'ESBIO', 'ESVGO', 'PTLEI', 'PTLIS'];
        $proveedorId = $this->findOrCreateProveedor('HMM');

        $sheetESALG = $spreadsheet->getSheetByName('ESALG');

        foreach ($sheetNames as $sheetName) {
            $sheet = $spreadsheet->getSheetByName($sheetName);
            if ($sheet === null) {
                Log::warning("Hoja '{$sheetName}' no encontrada en el archivo 'HMM'.");
                continue;
            }

            $highestRow = $sheet->getHighestRow();
            $startRow = 14; // Ajustar según inspección real

            for ($row = $startRow; $row <= $highestRow; $row++) {
                $polName = $sheet->getCell('J11')->getValue(); // POL fijo en la celda J11
                $podName = $sheet->getCell('C' . $row)->getValue();
                $dv20Excel = $this->parseFloatValue($sheet->getCell('Y' . $row)->getCalculatedValue());
                $dv40Excel = $this->parseFloatValue($sheet->getCell('Z' . $row)->getCalculatedValue());
                $hc40Excel = $this->parseFloatValue($sheet->getCell('AA' . $row)->getCalculatedValue());
                $validityCell = $sheetESALG->getCell('F14')->getValue();
                $effectivityCell = $sheetESALG->getCell('E14')->getValue();

                $destinoId = $this->findOrCreatePuerto($polName);
                $origenId = $this->findOrCreatePuerto($podName);

                if (empty($origenId) || empty($destinoId) || ($dv20Excel === null && $dv40Excel === null && $hc40Excel === null)) {
                    Log::warning("Fila {$row} en hoja '{$sheetName}' (HMM) omitida por datos incompletos o inválidos (Origen: {$polName}, Destino: {$podName}).");
                    continue;
                }
                Log::info("Validez: {$validityCell}, Efectividad: {$effectivityCell}");

                $validityDate = Carbon::instance(Date::excelToDateTimeObject($validityCell))->format('Y-m-d');
                $effectivityDate = Carbon::instance(Date::excelToDateTimeObject($effectivityCell))->format('Y-m-d');

                Tarifa::create(array_merge($additionalData, [
                    'origen_id' => $origenId,
                    'destino_id' => $destinoId,
                    'proveedor_id' => $proveedorId,
                    'precio_contenedor_20' => ($dv20Excel !== null) ? $dv20Excel + $sumData['cargo20'] : null,
                    'precio_contenedor_40' => ($dv40Excel !== null) ? $dv40Excel + $sumData['cargo40'] : null,
                    'precio_contenedor_h4' => ($hc40Excel !== null) ? $hc40Excel + $sumData['cargoHc'] : null,
                    'precio_grupage' => ($additionalData['tipo_cont_grup'] === 'Grupaje') ? $sumData['cargoGrup'] : null,
                    'validez' => $validityDate,
                    'efectividad' => $effectivityDate,
                ]));
            }
        }

        Log::info("Parseo de 'HMM' finalizado.");
    }

    private function parseGenericFebQuincena($spreadsheet, $additionalData, $sumData)
    {
        Log::info("Parseando formato 'generic_feb_quincena'");
        $sheetName = 'FLETES'; // Ajustar si es necesario
        if (!$spreadsheet->sheetExists($sheetName)) throw new \Exception("Hoja '{$sheetName}' no encontrada.");
        $sheet = $spreadsheet->getSheetByName($sheetName);

        $highestRow = $sheet->getHighestRow();
        $startRow = 5; // Ajustar

        for ($row = $startRow; $row <= $highestRow; $row++) {
            $polName = $sheet->getCell('A' . $row)->getValue();
            $podName = $sheet->getCell('B' . $row)->getValue();
            $navieraName = $sheet->getCell('C' . $row)->getValue();
            $dv20Excel = $this->parseFloatValue($sheet->getCell('D' . $row)->getCalculatedValue());
            $dv40Excel = $this->parseFloatValue($sheet->getCell('E' . $row)->getCalculatedValue());
            $hc40Excel = $this->parseFloatValue($sheet->getCell('F' . $row)->getCalculatedValue());
            $validityCell = $sheet->getCell('G' . $row)->getValue(); // Formato '15/02/2024 al 29/02/2024'
            // Grupaje no parece estar en este formato

            $origenId = $this->findOrCreatePuerto($polName);
            $destinoId = $this->findOrCreatePuerto($podName);
            $proveedorId = $this->findOrCreateProveedor($navieraName);

            if (empty($origenId) || empty($destinoId) || empty($proveedorId) || ($dv20Excel === null && $dv40Excel === null && $hc40Excel === null)) {
                 Log::warning("Fila {$row} en hoja '{$sheet->getTitle()}' (Generic Feb Quincena) omitida por datos incompletos o inválidos (Origen: {$polName}, Destino: {$podName}, Naviera: {$navieraName}).");
                continue;
            }

            $validityDates = $this->parseValidity($validityCell, 'd/m/Y');

            Tarifa::create(array_merge($additionalData, [
                'origen_id' => $origenId,
                'destino_id' => $destinoId,
                'proveedor_id' => $proveedorId,
                'precio_contenedor_20' => ($dv20Excel !== null) ? $dv20Excel + $sumData['cargo20'] : null,
                'precio_contenedor_40' => ($dv40Excel !== null) ? $dv40Excel + $sumData['cargo40'] : null,
                'precio_contenedor_h4' => ($hc40Excel !== null) ? $hc40Excel + $sumData['cargoHc'] : null,
                'precio_grupage' => ($additionalData['tipo_cont_grup'] === 'Grupaje') ? $sumData['cargoGrup'] : null,
                'validez' => $validityDates['validez'],
                'efectividad' => $validityDates['efectividad'],
            ]));
        }
        Log::info("Parseo de 'generic_feb_quincena' finalizado.");
    }

    private function parseGenericFarEastPodEspana($spreadsheet, $additionalData, $sumData)
    {
        Log::info("Parseando formato 'generic_far_east_pod_espana'");
        $sheet = $spreadsheet->getActiveSheet();
        $highestRow = $sheet->getHighestRow();
        $startRow = 3; // Ajustar

        for ($row = $startRow; $row <= $highestRow; $row++) {
            $polName = $sheet->getCell('B' . $row)->getValue(); // DPOL
            $podName = $sheet->getCell('C' . $row)->getValue(); // DPOD
            $navieraName = $sheet->getCell('D' . $row)->getValue(); // CARRIERNAME
            $validityCell = $sheet->getCell('E' . $row)->getValue(); // VALIDEZ
            $transitTime = $sheet->getCell('F' . $row)->getValue(); // TT
            $dv20Excel = $this->parseFloatValue($sheet->getCell('G' . $row)->getCalculatedValue()); // 20 DV
            $dv40Excel = $this->parseFloatValue($sheet->getCell('H' . $row)->getCalculatedValue()); // 40 DV
            $hc40Excel = $this->parseFloatValue($sheet->getCell('I' . $row)->getCalculatedValue()); // 40 HC
            $polCode = $sheet->getCell('R' . $row)->getValue(); // POL (Código)
            $podCode = $sheet->getCell('S' . $row)->getValue(); // POD (Código)
            $navieraCode = $sheet->getCell('T' . $row)->getValue(); // CARRIER (Código)
            $validezInicioExcelRaw = $sheet->getCell('X' . $row)->getValue(); // F_INICIO
            $validezInicioExcel = null;
            if (is_numeric($validezInicioExcelRaw)) {
                try {
                    $validezInicioExcel = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($validezInicioExcelRaw));
                } catch (\Exception $e) {
                    Log::warning("Error al convertir F_INICIO a fecha en fila {$row}: " . $e->getMessage());
                }
            }
            // Grupaje no parece estar en este formato

            $origenId = $this->findOrCreatePuerto($polCode ?: $polName);
            $destinoId = $this->findOrCreatePuerto($podCode ?: $podName);
            $proveedorId = $this->findOrCreateProveedor($navieraCode ?: $navieraName);

            if (empty($origenId) || empty($destinoId) || empty($proveedorId) || ($dv20Excel === null && $dv40Excel === null && $hc40Excel === null)) {
                 Log::warning("Fila {$row} en hoja '{$sheet->getTitle()}' (Far East Pod España) omitida por datos incompletos o inválidos (Origen: {$polName}/{$polCode}, Destino: {$podName}/{$podCode}, Naviera: {$navieraName}/{$navieraCode}).");
                continue;
            }

            // Usar F_INICIO si existe y es válido, si no, parsear VALIDEZ
            $validityDates = $this->parseValidity($validezInicioExcel ?: $validityCell, $validezInicioExcel ? 'F_INICIO' : 'd/m/Y');

            Tarifa::create(array_merge($additionalData, [
                'origen_id' => $origenId,
                'destino_id' => $destinoId,
                'proveedor_id' => $proveedorId,
                'precio_contenedor_20' => ($dv20Excel !== null) ? $dv20Excel + $sumData['cargo20'] : null,
                'precio_contenedor_40' => ($dv40Excel !== null) ? $dv40Excel + $sumData['cargo40'] : null,
                'precio_contenedor_h4' => ($hc40Excel !== null) ? $hc40Excel + $sumData['cargoHc'] : null,
                'precio_grupage' => ($additionalData['tipo_cont_grup'] === 'Grupaje') ? $sumData['cargoGrup'] : null,
                'dias' => is_numeric($transitTime) ? (int)$transitTime : null,
                'validez' => $validityDates['validez'],
                'efectividad' => $validityDates['efectividad'],
            ]));
        }
        Log::info("Parseo de 'generic_far_east_pod_espana' finalizado.");
    }
}

