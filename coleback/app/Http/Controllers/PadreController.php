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
        $user->nombres=$request->nombres;
        $user->apellidos=$request->apellidos;
        $user->carnet=$request->carnet;
        $user->expedido=$request->expedido;
        $user->fechanac=$request->fechanac;
        $user->email=$request->email;
        $user->fechalimite=date('Y-m-d', strtotime(date("Y-m-d"). ' + 350 days'));;
        $user->password=Hash::make('123456');
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
