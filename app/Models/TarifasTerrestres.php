<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TarifasTerrestres extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tarifas_terrestres';
    protected $fillable = [
        'cliente_id',
        'destino',
        'precio',
    ];
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];
    public function cliente()
    {
        return $this->belongsTo(Cliente::class,'cliente_id','id');
    }
}
