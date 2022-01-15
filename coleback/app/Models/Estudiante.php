<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;
    protected $fillable=[
        'carnet',
        'domicilio',
        'paterno',
        'materno',
        'nombres',
        'celular',
        'fechanac',
        'sexo',
        'tipo',
        'fecha',
        'estado',
        'imagen',
        'curso_id',
    ];
    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function curso(){
        return $this->belongsTo(Curso::class);
    }


}
