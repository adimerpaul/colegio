<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    use HasFactory;

    public function estudiante(){
        return $this->belongsTo(Estudiante::class);
    }

    public function periodo(){
        return $this->belongsTo(Periodo::class);
    }

    public function materia(){
        return $this->belongsTo(Materia::class)->with('grupo');
    }

}
