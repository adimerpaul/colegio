<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Estudiante;
use App\Models\Periodo;
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
        return Curso::with('materias')->get();
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
        //return $curso->id;
        $periodo=Periodo::where('estado','ACTIVO')->first();
        return DB::SELECT("SELECT 
        e.id	,
        e.carnet,	
        e.domicilio	,
        e.paterno	,
        e.materno	,
        e.nombres	,
        e.sexo	,
        e.celular,	
        e.fechanac,	
        e.rude	,
        e.fecha	,
        e.estado,	
        e.imagen,	
        e.vernota,	
        ce.curso_id	
         from estudiantes e inner join curso_estudiante ce on e.id=ce.estudiante_id where ce.curso_id=$curso->id and ce.periodo_id=$periodo->id");
    }

    public function upvernota(Request $request)
    {
        $periodo=Periodo::where('estado','ACTIVO')->first();
        DB::SELECT("UPDATE estudiantes set vernota='SI' where id in (select estudiante_id from curso_estudiante where curso_id=$request->id and periodo_id=$periodo->id)");
    }

    public function upocultarnota(Request $request)
    {
        $periodo=Periodo::where('estado','ACTIVO')->first();
        DB::SELECT("Update estudiantes set vernota='NO' where id in (select estudiante_id from curso_estudiante where curso_id=$request->id and periodo_id=$periodo->id)");
    }

    public function upverestudiante(Request $request)
    {
        //$periodo=Periodo::where('estado','ACTIVO')->first();
        $estudiante=Estudiante::find($request->id);
        if($estudiante->vernota=='SI'){
            $estudiante->vernota='NO';
        }
        else{
            $estudiante->vernota='SI';
        }
        $estudiante->save();
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

    public function upMateriaCurso(Request $request){
        $periodo=Periodo::where('estado','ACTIVO')->first();

        DB::SELECT("DELETE from curso_materia where curso_id=$request->curso");
        foreach($request->materias as $m){
        DB::SELECT("INSERT into curso_materia (curso_id,periodo_id,materia_id,profesor_id) values($request->curso,$periodo->id,$m,1)");
        }

    }
    public function recperaMat(Request $request ){
        return DB::SELECT("SELECT materia_id from curso_materia where curso_id=$request->curso");
    }
}
