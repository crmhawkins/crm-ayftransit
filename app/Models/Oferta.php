<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oferta extends Model
{
    protected $fillable = [
        'cliente_id',
        'fecha_emision',
        'tipo_cotizacion',
        'tipo',
        'naviera_co_loader',
        'origen',
        'destino',
        'valido_desde',
        'valido_hasta',
        'estado',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}