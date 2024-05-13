<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puerto extends Model
{
    use HasFactory;


    protected $fillable = [
        'Nombre',
        'Pais',

    ];

    /**
     * Mutaciones de fecha.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    public function tarifasComoOrigen()
    {
        return $this->hasMany(Tarifa::class, 'origen_id');
    }

    public function tarifasComoDestino()
    {
        return $this->hasMany(Tarifa::class, 'destino_id');
    }
}
