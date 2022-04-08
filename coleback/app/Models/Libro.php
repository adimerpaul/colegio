<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    use HasFactory;
    protected $fillable=[
    'titulo',
    'autor',
    'editorial',
    'archivo',
    'imagen',
    'fecha',
    'curso_id',
    'materia_id'];

    public function materia(){
        return $this->belongsTo(Materia::class);
    }

    public function curso(){
        return $this->belongsTo(Curso::class);
    }
}
