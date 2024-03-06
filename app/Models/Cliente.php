<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Cliente extends Model
{
    protected $fillable = ['nombre', 'direccion', 'telefono', 'email','empresa','pago','seguro','cif'];

    public function operaciones()
    {
        return $this->hasMany(Operacion::class);
    }

    public function ofertas()
    {
        return $this->hasMany(Oferta::class);
    }




    /**
     * Mutaciones de fecha.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];
}
