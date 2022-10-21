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
//        return DB::select("select c.id,c.nombre,c.paralelo,count(*) as cantidad from cursos c INNER JOIN estudiantes e ON e.curso_id=c.id GROUP BY c.id,c.nombre,c.paralelo");
        return DB::select("
                select c.id,c.nombre,c.paralelo,count(*) as cantidad , (
        SELECT count(*) from estudiantes where curso_id=c.id AND sexo='M'
        ) as m,(SELECT count(*) from estudiantes where curso_id=c.id AND sexo='F'
        ) as f
        from cursos c INNER JOIN estudiantes e ON e.curso_id=c.id
        GROUP BY c.id,c.nombre,c.paralelo
        ");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        return $request;
        $estudiante=new Estudiante();
        $estudiante->carnet=$request->carnet;
        $estudiante->domicilio=strtoupper($request->domicilio);
        $estudiante->paterno= strtoupper($request->paterno);
        $estudiante->materno=strtoupper($request->materno);
        $estudiante->nombres=strtoupper($request->nombres);
        $estudiante->celular=$request->celular;
        $estudiante->rude=$request->rude;
        $estudiante->sexo=$request->sexo;
        $estudiante->fechanac=$request->fechanac;
//        $estudiante->tipo=$request->tipo;
        $estudiante->fecha=date('Y-m-d');
//        $estudiante->estado=$request->estado;
//        $estudiante->imagen=$request->imagen;
        $estudiante->curso_id=$request->curso_id;
        $estudiante->save();
        $periodo=Periodo::where('estado',"ACTIVO")->get()[0];
//        return [
//            "estudiante_id"=>$estudiante->id,
//            "curso_id"=>$request->curso_id,
//            "periodo_id"=>$periodo->id,
//            "user_id"=>$request->user()->id,
//        ];
        DB::table('curso_estudiante')->insert([
            "estudiante_id"=>$estudiante->id,
            "curso_id"=>$request->curso_id,
            "periodo_id"=>$periodo->id,
            "user_id"=>$request->user()->id,
        ]);

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
        $estudiante->domicilio=strtoupper($request->domicilio);
        $estudiante->paterno=strtoupper($request->paterno);
        $estudiante->materno=strtoupper($request->materno);
        $estudiante->nombres=strtoupper($request->nombres);
        $estudiante->celular=$request->celular;
        $estudiante->fechanac=$request->fechanac;
        $estudiante->rude=$request->rude;
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

    public function boleta($id){
        $datos= DB::SELECT("SELECT e.carnet,e.nombres,e.paterno,e.materno,u.nombres as tnom,u.apellidos,u.email,u.carnet as tci,c.nombre as curs,c.paralelo  From estudiantes e inner join estudiante_user es on e.id=es.estudiante_id inner join users u on u.id=es.user_id inner join cursos c on e.curso_id=c.id where e.id=$id")[0];
        $cadena="<style>
        *{
        padding: 0px,
        margin: 0px,
        border: 0px,
        }
        </style>
        <table>
        <tr>
        <td>
        <div style='font-weight: bold;font-size: 12px;text-align: center'>BOLETA DE INSCRIPCION</div><hr>
            <table style='border-collapse: collapse;border: 1px solid black'>
            <tr><td><b>Pagina de notas:</b></td><td>https://uesantarosa2.gq</td></tr>
            <tr><td><b>Familiar:</b></td><td>$datos->tnom $datos->apellidos</td></tr>
            <tr><td><b>Correo:</b></td><td>$datos->email </td></tr>
            <tr><td><b>Password:</b></td><td>$datos->tci </td></tr>
            <tr><td><b>Estudiante:</b></td><td>$datos->nombres $datos->paterno $datos->materno </td></tr>
            <tr><td><b>Curso:</b></td><td>$datos->curs $datos->paralelo </td></tr></td></tr>
            <tr><td><b>Consultas:</b></td><td>77159262 </td></tr>
            </table>
        </td>
        <td>
        <div style='font-weight: bold;font-size: 12px;text-align: center'>BOLETA DE INSCRIPCION</div><hr>
            <table style='border-collapse: collapse;border: 1px solid black'>
            <tr><td><b>Pagina de notas:</b></td><td>https://uesantarosa2.gq</td></tr>
            <tr><td><b>Familiar:</b></td><td>$datos->tnom $datos->apellidos</td></tr>
            <tr><td><b>Correo:</b></td><td>$datos->email </td></tr>
            <tr><td><b>Password:</b></td><td>$datos->tci </td></tr>
            <tr><td><b>Estudiante:</b></td><td>$datos->nombres $datos->paterno $datos->materno </td></tr>
            <tr><td><b>Curso:</b></td><td>$datos->curs $datos->paralelo </td></tr></td></tr>
            <tr><td><b>Consultas:</b></td><td>77159262 </td></tr>
            </table>
        </td>
        </tr>
        </table>";

        return $cadena;
    }
}
