<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargosExtra extends Model
{
    use HasFactory;
    protected $table = "cargosextras";
    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'presupuesto_id',
        'concepto',
        'valor20',
        'valor40',
        'valorHQ',
        'Unidad',
    ];
    /**
     * Obtiene la tarifa a la que pertenece el cargo extra.
     */
    public function presupuesto()
    {
        return $this->belongsTo(Presupuesto::class);
    }
}
