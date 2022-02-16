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
    'fecha',
    'materia_id'];

    public function materia(){
        return $this->belongsTo(Materia::class);
    }
}
