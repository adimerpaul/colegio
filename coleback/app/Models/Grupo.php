<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;
    protected $fillable=[
        'nombre',
        'color',
    ];

    public function materias(){
        return $this->hasMany(Materia::class);
    }

}
