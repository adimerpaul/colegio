<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'nombres',
        'apellidos',
        'email',
        'password',
        'carnet',
        'fechalimite',
        'unit_id',
        'tipo'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function permisos(){
        return $this->belongsToMany(Permiso::class);
    }
    public function unit(){
        return $this->belongsTo(Unit::class);
    }

    public function materias(){
        return $this->belongsToMany(Materia::class);
    }

    public function estudiantes(){
        return $this->belongsToMany(Estudiante::class)->with('curso');
    }

    public function cursos(){
        return $this->belongsToMany(Curso::class);
    }
}
