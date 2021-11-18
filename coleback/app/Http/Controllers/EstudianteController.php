<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\User;
use Illuminate\Http\Request;

class EstudianteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Estudiante::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $estudiante=new Estudiante();
        $estudiante->carnet=$request->carnet;
        $estudiante->domicilio=$request->domicilio;
        $estudiante->paterno=$request->paterno;
        $estudiante->materno=$request->materno;
        $estudiante->nombres=$request->nombres;
        $estudiante->celular=$request->celular;
        $estudiante->fechanac=$request->fechanac;
//        $estudiante->tipo=$request->tipo;
        $estudiante->fecha=date('Y-m-d');
//        $estudiante->estado=$request->estado;
//        $estudiante->imagen=$request->imagen;
        $estudiante->curso_id=$request->curso_id;
        $estudiante->save();
        $user=User::find($request->padre_id);
        $estudiante->users()->attach($request->padre_id,['relacion'=>$user->tipo]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Estudiante  $estudiante
     * @return \Illuminate\Http\Response
     */
    public function show($carnet)
    {
        return Estudiante::where('carnet',$carnet)->first();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Estudiante  $estudiante
     * @return \Illuminate\Http\Response
     */
    public function edit(Estudiante $estudiante)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Estudiante  $estudiante
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Estudiante $estudiante)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Estudiante  $estudiante
     * @return \Illuminate\Http\Response
     */
    public function destroy(Estudiante $estudiante)
    {
        //
    }
}
