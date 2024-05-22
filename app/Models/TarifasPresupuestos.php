<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TarifasPresupuestos extends Model
{
    use HasFactory;
    protected $table = "tarifas_presupuestos";
    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'presupuesto_id',
        'id_proveedor',
        'origen_id',
        'destino_id',
        'precio_grupage',
        'precio_contenedor_20',
        'precio_contenedor_40',
        'precio_contenedor_h4',
        'dias',
        'tarifa_id',
        'efectividad',
        'validez',
    ];
    /**
     * Obtiene la tarifa a la que pertenece el cargo extra.
     */
    public function presupuesto()
    {
        return $this->belongsTo(Presupuesto::class);
    }
}
