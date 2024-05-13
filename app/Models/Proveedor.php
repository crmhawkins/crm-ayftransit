<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table ='proveedores';
    protected $fillable = ['nombre', 'direccion', 'telefono', 'email','gastos_llegada_20','gastos_llegada_40','gastos_llegada_h4','gastos_llegada_grupage','contacto'];

    public function tarifas()
    {
        return $this->hasMany(Tarifa::class,'proveedor_id');
    }
}
