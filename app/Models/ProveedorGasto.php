<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProveedorGasto extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table ='proveedor_gastos';
    protected $fillable = [
        'proveedor_id',
        'concepto',
        'gasto_20',
        'gasto_40',
        'gasto_h4',
        'gasto_grupage',
    ];

}
