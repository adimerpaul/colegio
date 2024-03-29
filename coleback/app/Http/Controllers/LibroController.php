<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use Illuminate\Http\Request;

class LibroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Libro::with('materia')->with('curso')->get();
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
        $nombreArchivo='';
//        if ($request->hasFile('archivo')) {
//            $file=$request->file('archivo');
//            $nombreArchivo = $file->getClientOriginalName();
//            $file->move(\public_path('archivos'), $nombreArchivo);
//        }
        if ($request->hasFile('imagen')) {
            $file=$request->file('imagen');
            $nombreimagen = $file->getClientOriginalName();
            $file->move(\public_path('imagenes'), $nombreimagen);
        }
        $libro=new Libro;
        $libro->titulo=$request->titulo;
        $libro->autor=$request->autor;
        $libro->archivo=$request->archivo;
        $libro->imagen=$nombreimagen;
        $libro->editorial=$request->editorial;
        $libro->fecha=date('Y-m-d');
        $libro->materia_id=$request->materia_id;
        $libro->curso_id=$request->curso_id;
        $libro->save();
    }

    public function uparchivo(Request $request){
        $nombreArchivo='';
        if ($request->hasFile('archivo')) {
            $file=$request->file('archivo');
            $nombreArchivo = $file->getClientOriginalName();
            $file->move(\public_path('archivos'), $nombreArchivo);
        }
        $libro=Libro::find($request->id);
        $libro->archivo=$nombreArchivo;
        $libro->save();
     }

    public function upimagen(Request $request){
        $nombreArchivo='';
        if ($request->hasFile('imagen')) {
            $file=$request->file('imagen');
            $nombreArchivo = $file->getClientOriginalName();
            $file->move(\public_path('imagenes'), $nombreArchivo);
        }
        $libro=Libro::find($request->id);
        $libro->imagen=$nombreArchivo;
        $libro->save();
     }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Libro  $libro
     * @return \Illuminate\Http\Response
     */
    public function show(Libro $libro)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Libro  $libro
     * @return \Illuminate\Http\Response
     */
    public function edit(Libro $libro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Libro  $libro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Libro $libro)
    {
        //
        $libro= Libro::find($request->id);
        $libro->titulo=$request->titulo;
        $libro->autor=$request->autor;
        $libro->editorial=$request->editorial;
        $libro->materia_id=$request->materia_id;
        $libro->curso_id=$request->curso_id;
        $libro->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Libro  $libro
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        //
        $libro=Libro::find($id);
        $libro->delete();
    }

    public function buscarlibro(Request $request){
        //return $request;

        return Libro::with('materia')->with('curso')
        ->where('materia_id',$request->materia_id)
        ->where('curso_id',$request->curso_id)
        ->get();

    }
}
