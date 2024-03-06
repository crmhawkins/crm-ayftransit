<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table ='proveedores';
    protected $fillable = ['nombre', 'direccion', 'telefono', 'email','gastos_llegada','contacto'];

    public function operaciones()
    {
        return $this->hasMany(Operacion::class);
    }
}
