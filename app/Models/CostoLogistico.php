<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostoLogistico extends Model
{
    protected $fillable = ['operacion_id', 'tipo', 'valor', 'puerto'];

    public function operacion()
    {
        return $this->belongsTo(Operacion::class);
    }
}