<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Curso::all();
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
        //
        $curso=new Curso;
        $curso->nombre=$request->nombre;
        $curso->paralelo=$request->paralelo;
        $curso->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function show(Curso $curso)
    {
        return Estudiante::where('curso_id',$curso->id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function edit(Curso $curso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Curso $curso)
    {
        //
        $curso= Curso::find($request->id);
        $curso->nombre=$request->nombre;
        $curso->paralelo=$request->paralelo;
        $curso->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $curso=Curso::find($id);
        $curso->delete();
    }

    public function listmaterias($id){
       return Curso::with('materias')->where('id',$id)->get();
       /*return DB::SELECT("SELECT * from curso_materia cm inner join materia m on cm.materia_id=m.id
        inner join user u on cm.profesor_id = u.id
        where cm.curso_id=$id");*/
    }


    public function regmateria(Request $request){
        DB::table('curso_materia')->insert([["curso_id"=>$request->curso_id],["materia_id"=>$request->materia_id],["profesor_id"=>$request->user_id]]);
    }

    public function listestudiante(Request $request){
        return DB::SELECT("SELECT e.* FROM curso_estudiante ce inner join estudiantes e on ce.estudiante_id=e.id where ce.periodo_id=(select p.id from periodos p where p.estado='ACTIVO') and ce.curso_id=$request->curso_id");
    }

}
