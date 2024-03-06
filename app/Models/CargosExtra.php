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
        'tarifa_id',
        'concepto',
        'valor',
    ];

    /**
     * Obtiene la tarifa a la que pertenece el cargo extra.
     */
    public function tarifa()
    {
        return $this->belongsTo(Tarifa::class);
    }
}
