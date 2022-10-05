<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;
    protected $fillable=[
        'nombre',
        'paralelo',
    ];

    public function materias(){
        return $this->belongsToMany(Materia::class)->with('grupo');
    }

    
}
