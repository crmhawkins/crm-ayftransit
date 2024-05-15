<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Presupuesto extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "presupuestos";

    protected $fillable = [
        'id_cliente',
        'estado',
        'fechaEmision',
        'tipo_imp_exp',
        'tipo_cont_grup',
        'tipo_mar_area_terr',
        'id_proveedorterrestre',
        'destino',
        'precio_terrestre',
        'gastos_llegada_20',
        'gastos_llegada_40',
        'gastos_llegada_h4',
        'gastos_llegada_grupage'
    ];


    /**
     * Mutaciones de fecha.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    public function cargosExtra()
    {
        return $this->hasMany(CargosExtra::class);
    }
    public function notas()
    {
        return $this->hasMany(Notas::class);
    }
    public function servicios()
    {
        return $this->hasMany(Servicios::class);
    }
    public function generales()
    {
        return $this->hasMany(Generales::class);
    }
    public function Tarifas()
    {
        return $this->hasMany(TarifasPresupuestos::class);
    }
}
