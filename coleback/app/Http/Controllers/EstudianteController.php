<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Periodo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function listado(request $request){
        return Estudiante::with('curso')->get();
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
        $periodo=Periodo::where('estado',"ACTIVO")->get()[0];
        DB::table('curso_estudiante')->insert([ ["estudiante_id"=>$estudiante->id],
       ["curso_id"=>$request->curso_id],["periodo_id"=>$periodo->id],["user_id"=>$request->user()->id]]);

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
        $estudiante=Estudiante::find($request->id);
        $estudiante->domicilio=$request->domicilio;
        $estudiante->paterno=$request->paterno;
        $estudiante->materno=$request->materno;
        $estudiante->nombres=$request->nombres;
        $estudiante->celular=$request->celular;
        $estudiante->fechanac=$request->fechanac;
        $estudiante->fecha=date('Y-m-d');
        $estudiante->curso_id=$request->curso_id;
        $estudiante->save();
        $periodo=Periodo::where('estado',"ACTIVO")->get()[0];
        $curest=DB::table('curso_estudiante')->where("estudiante_id",$estudiante->id)->where("periodo_id",$periodo->id)->get();
        if(sizeof($curest)>0){
        DB::table('curso_estudiante')->where("estudiante_id",$estudiante->id)->where("periodo_id",$periodo->id)->update(["curso_id"=>$request->curso_id]);}
       else
        {DB::table('curso_estudiante')->insert(["estudiante_id"=>$request->id,
        "curso_id"=>$request->curso_id,"periodo_id"=>$periodo->id,"user_id"=>$request->user()->id]);}
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
