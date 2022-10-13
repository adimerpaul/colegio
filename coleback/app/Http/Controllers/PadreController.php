<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PadreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::where('tipo','PADRE')->orWhere('tipo','TUTOR')->get();
    }

    public function hijos(Request $request)
    {
        return User::where('id',$request->user()->id)->where('tipo','PADRE')->orWhere('tipo','TUTOR')->with('estudiantes')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user= new User();
        $user->tipo=$request->tipo;
        $user->nombres=strtoupper($request->nombres);
        $user->apellidos=strtoupper($request->apellidos);
        $user->carnet=$request->carnet;
        $user->expedido=$request->expedido;
        $user->fechanac=$request->fechanac;
        $user->email=substr(strtoupper($request->nombres),0,1).$request->carnet.'@santarosa2.com';
        $user->fechalimite=date('Y-m-d', strtotime(date("Y-m-d"). ' + 350 days'));;
        $user->password=Hash::make($request->carnet);
        $user->save();

//        $user->tipo=$request->tipo;
//        $user->tipo=$request->tipo;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
