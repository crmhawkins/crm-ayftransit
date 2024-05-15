<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicios extends Model
{
    use HasFactory;
    protected $table = "servicios";
    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'presupuesto_id',
        'titulo',
        'descripcion',
    ];
    /**
     * Obtiene la tarifa a la que pertenece el cargo extra.
     */
    public function presupuesto()
    {
        return $this->belongsTo(Presupuesto::class);
    }
}
