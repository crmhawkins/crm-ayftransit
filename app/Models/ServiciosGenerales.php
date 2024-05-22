<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiciosGenerales extends Model
{
    use HasFactory;
    protected $fillable = [
        'titulo',
        'descripcion',
    ];
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];
}
