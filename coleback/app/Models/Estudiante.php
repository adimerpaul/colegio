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
        'tipo',
        'fecha',
        'estado',
        'imagen',
        'curso_id',
    ];
    public function users(){
        return $this->belongsToMany(User::class);
    }
}
