<?php

namespace App\Http\Controllers;

use App\Models\Periodo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeriodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Periodo::all();
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

    public function gestion(){
        return Periodo::where('estado','ACTIVO')->first();

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
        $res=Periodo::where('gestion',$request->gestion)->get();
        if(sizeof($res)==0){
            $periodo=new Periodo;
            $periodo->gestion=$request->gestion;
            $periodo->save();
           // $curmat=DB::table('curso_materia')->where('periodo_id',intval($periodo->id) - 1);
            /*foreach ($curmat as $row) {
                DB::table('curso_materia')->insert([

            'curso_id'=>$row->curso_id,
            'materia_id'=>$row->materia_id,
            'profesor_id'=>$row->profesor_id,
            'periodo_id'=>$periodo->id
                ]);
            }*/
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Periodo  $periodo
     * @return \Illuminate\Http\Response
     */
    public function show(Periodo $periodo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Periodo  $periodo
     * @return \Illuminate\Http\Response
     */
    public function edit(Periodo $periodo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Periodo  $periodo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Periodo $periodo)
    {
        //
        DB::table('periodos')->update(['estado'=>'INACTIVO']);
        $periodo=Periodo::find($request->id);
        $periodo->estado='ACTIVO';
        $periodo->save();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Periodo  $periodo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Periodo $periodo)
    {
        //
        return $periodo->delete();
    }
}
