<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GastosAduanas extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'gastos_aduanas';
    protected $fillable = [
        'cliente_id',
        'titulo',
        'descripcion',
    ];
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }


}
