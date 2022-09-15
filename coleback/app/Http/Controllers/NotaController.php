<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use App\Models\Periodo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    }

    public function listnota(Request $request){
        $periodo=Periodo::where('estado','ACTIVO')->first();
        return Nota::where('materia_id',$request->materia_id)->where('curso_id',$request->curso_id)->where('periodo_id',$periodo->id)->where('trimestre',$request->trimestre)->get();
        //$table->unsignedBigInteger('periodo_id');
        //$table->string('trimestre');
    }

    public function libreta(Request $request){

        $periodo=Periodo::where('estado','ACTIVO')->first();
       //return Nota::with('materia')->where('estudiante_id',$request->estudiante_id)->where('periodo_id',$periodo->id)->get();
       return DB::SELECT("SELECT m.grupo_id,m.id, m.nombre, 
       (SELECT n.promedio from notas n where n.materia_id=m.id and n.periodo_id=$periodo->id and n.estudiante_id=".$request->estudiante['id']." and n.trimestre='PRIMER TRIMESTRE') as primero, 
       (SELECT n.promedio from notas n where n.materia_id=m.id and n.periodo_id=$periodo->id and n.estudiante_id=".$request->estudiante['id']." and n.trimestre='SEGUNDO TRIMESTRE') as segundo,
       (SELECT n.promedio from notas n where n.materia_id=m.id and n.periodo_id=$periodo->id and n.estudiante_id=".$request->estudiante['id']." and n.trimestre='TERCER TRIMESTRE') as tercero
         FROM materias m inner join curso_materia cm on m.id=cm.materia_id INNER JOIN cursos c on cm.curso_id=c.id where c.id=".$request->curso['id']." order by m.grupo_id,m.id;");
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Nota  $nota
     * @return \Illuminate\Http\Response
     */
    public function show(Nota $nota)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Nota  $nota
     * @return \Illuminate\Http\Response
     */
    public function edit(Nota $nota)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Nota  $nota
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Nota $nota)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Nota  $nota
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nota $nota)
    {
        //
    }
}
