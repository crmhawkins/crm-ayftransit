<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Cliente extends Model
{
    protected $fillable = ['nombre', 'direccion', 'telefono', 'email','empresa','pago','seguro','cif'];

    public function gastosAduanas()
    {
        return $this->hasMany(GastosAduanas::class,'cliente_id');
    }

    public function tarifasTerrestres()
    {
        return $this->hasMany(TarifasTerrestres::class,'cliente_id');
    }
    public function notas()
    {
        return $this->hasMany(NotasCliente::class,'cliente_id');
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
