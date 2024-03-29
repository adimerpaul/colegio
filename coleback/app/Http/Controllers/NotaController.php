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
            //return $request->curso['id'];
            $periodo=Periodo::where('estado','ACTIVO')->first();
            foreach($request->notas as $calif){
                //return $calif['id'];
            $validar=Nota::where('materia_id',$request->materia)
            ->where('curso_id',$request->curso['id'])
            ->where('periodo_id',$periodo->id)
            ->where('trimestre',$request->trimestre)
            ->where('estudiante_id',$calif['id'])->count();
            //return $validar;
            if($validar>0){
                DB::SELECT("UPDATE notas set promedio=".$calif['promedio']." where materia_id=$request->materia 
                and curso_id=".$request->curso['id']." and periodo_id=$periodo->id
                and trimestre='$request->trimestre' and estudiante_id=".$calif['id'] );
            }
            else 
            {
                $periodo=Periodo::where('estado','ACTIVO')->first();
                $nota=new Nota;        
                $nota->curso_id=$request->curso['id'];
                $nota->materia_id=$request->materia;
                $nota->user_id=$request->user()->id;
                $nota->periodo_id=$periodo->id;
                $nota->estudiante_id=$calif['id'];
                $nota->promedio=$calif['promedio'];
                $nota->trimestre=$request->trimestre;
                $nota->fecha=date('Y-m-d');
                $nota->hora=date('H:i:s');
                $nota->save();

            }
        }
    }

    public function listnota(Request $request){
        //return $request;
        $periodo=Periodo::where('estado','ACTIVO')->first();
        return Nota::where('materia_id',$request->materia)
        ->where('curso_id',$request->curso['id'])
        ->where('periodo_id',$periodo->id)
        ->where('trimestre',"$request->trimestre")->get();
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

    public function notaMejor(Request $request){

        $periodo=Periodo::where('estado','ACTIVO')->first();
        $num=sizeof($request->materias);
        $cadena='';
        if ($request->trim=='ANUAL'){
            foreach($request->materias as $m){
                $cadena.=",(select ROUND(sum(n.promedio)/3) from notas n where n.curso_id=$request->curso and n.materia_id=".$m['id']." and n.periodo_id=$periodo->id and n.estudiante_id=e.id ) as '".$m['nombre']."'";
            }
    
            return DB::SELECT( "SELECT e.id,e.paterno,e.materno,e.nombres ".$cadena." 
            ,(select ROUND(sum(n.promedio)/($num*3)) from notas n where n.curso_id=$request->curso and n.periodo_id=$periodo->id and n.estudiante_id=e.id ) as promedio
            from estudiantes e inner join curso_estudiante ce on e.id=ce.estudiante_id
            where ce.curso_id=$request->curso and ce.periodo_id=$periodo->id order by e.paterno,e.materno,e.nombres");
        }else {
        foreach($request->materias as $m){
            $cadena.=",(select IFNULL(n.promedio,0) from notas n where n.curso_id=$request->curso and n.materia_id=".$m['id']." and n.periodo_id=$periodo->id and n.estudiante_id=e.id and n.trimestre='$request->trim') as '".$m['nombre']."'";
        }

        return DB::SELECT( "SELECT e.id,e.paterno,e.materno,e.nombres ".$cadena." 
        ,(select ROUND(sum(n.promedio)/$num) from notas n where n.curso_id=$request->curso and n.periodo_id=$periodo->id and n.estudiante_id=e.id and n.trimestre='$request->trim') as promedio
        from estudiantes e inner join curso_estudiante ce on e.id=ce.estudiante_id
        where ce.curso_id=$request->curso and ce.periodo_id=$periodo->id order by e.paterno,e.materno,e.nombres");
    }




        return $request;
       //return Nota::with('materia')->where('estudiante_id',$request->estudiante_id)->where('periodo_id',$periodo->id)->get();
       return DB::SELECT("SELECT COUNT(*)as cantidad,sum(promedio) as total,estudiante_id,e.nombres,e.paterno,e.materno,c.nombre,c.paralelo from notas n inner join estudiantes e on n.estudiante_id=e.id inner join cursos c on n.curso_id=c.id where n.periodo_id=$periodo->id group by estudiante_id;");
       return DB::SELECT("SELECT m.grupo_id,m.id, m.nombre, 
       (SELECT n.promedio from notas n where n.materia_id=m.id and n.periodo_id=$periodo->id and n.estudiante_id=".$request->estudiante['id']." and n.trimestre='PRIMER TRIMESTRE') as primero, 
       (SELECT n.promedio from notas n where n.materia_id=m.id and n.periodo_id=$periodo->id and n.estudiante_id=".$request->estudiante['id']." and n.trimestre='SEGUNDO TRIMESTRE') as segundo,
       (SELECT n.promedio from notas n where n.materia_id=m.id and n.periodo_id=$periodo->id and n.estudiante_id=".$request->estudiante['id']." and n.trimestre='TERCER TRIMESTRE') as tercero
         FROM materias m inner join curso_materia cm on m.id=cm.materia_id INNER JOIN cursos c on cm.curso_id=c.id 
         where c.id=".$request->curso['id']." order by m.grupo_id,m.id;");
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
