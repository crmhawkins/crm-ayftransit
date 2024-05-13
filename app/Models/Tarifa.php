<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarifa extends Model
{
    use HasFactory;


    protected $fillable = [
        'origen_id',
        'destino_id',
        'destinoterrestre',
        'precio_grupage',
        'precio_contenedor_20',
        'precio_contenedor_40',
        'precio_contenedor_h4',
        'precio_terrestre',
        'tipo_imp_exp',
        'tipo_cont_grup',
        'tipo_mar_area_terr',
        'proveedor_id',
        'dias',
        'cargo',
        'validez',
        'efectividad'
    ];

    /**
     * Mutaciones de fecha.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];
    public function origen()
    {
        return $this->belongsTo(Puerto::class, 'origen_id');
    }

    public function destino()
    {
        return $this->belongsTo(Puerto::class, 'destino_id');
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class,'proveedor_id');
    }
}
