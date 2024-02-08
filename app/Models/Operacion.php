<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operacion extends Model
{
    protected $fillable = ['cliente_id', 'proveedor_id', 'tipo', 'fecha_emision', 'referencia_num', 'codigo', 'bill_of_landing', 'estado'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function costosLogisticos()
    {
        return $this->hasMany(CostoLogistico::class);
    }
}