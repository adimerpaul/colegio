<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(){
        return User::with('unit')->with('permisos')->where('id','!=',1)->get();
    }
    public function usuarios(Request $request){
        return User::with('unit')->where('id','!=',$request->user()->id)->where('id','!=',1)->orderBy('unit_id')->get();
    }
    public function misremetentes(Request $request){
        return User::with('unit')->where('unit_id',$request->user()->unit_id)->where('id','!=',$request->user()->id)->where('id','!=',1)->orderBy('unit_id')->get();
    }
    public function login(Request $request){
        if (!Auth::attempt($request->all())){
            return response()->json(['res'=>'No existe el usuario'],400);
        }
        if (User::where('email',$request->email)->whereDate('fechalimite','>',now())->get()->count()==0){
            return response()->json(['res'=>'Su usuario sobre paso el limite de ingreso'],400);
        }

        $user=User::where('email',$request->email)->with('unit')->with('permisos')->firstOrFail();
        $token=$user->createToken('auth_token')->plainTextToken;
        return response()->json(['token'=>$token,'user'=>$user],200);;
    }
    public function register(Request $request){
        $request->validate([
            'email'=>'required|unique:users|email',
            'carnet'=>'required|unique:users',
        ]);
        $user=new User();
        $user->nombres= strtoupper( $request->nombres);
        $user->apellidos= strtoupper( $request->apellidos);
        $user->expedido=  $request->expedido;
        $user->fechanac=  $request->fechanac;
        $user->tipo=$request->tipo;
        //$user->email=$request->email;
        $user->email=substr(strtoupper($request->nombres),0,1).substr(strtoupper($request->apellidos),0,1).$request->carnet.'@santarosa2.com';
        $user->password=Hash::make( $request->password);
        $user->carnet=$request->carnet;
        $user->unit_id=$request->unit_id;
        $user->fechalimite=date('Y-m-d', strtotime(now(). ' + 7 days'));;
        $user->save();
        $permiso = Permiso::find([3]);
        $user->permisos()->attach($permiso);
        $token=$user->createToken('auth_token')->plainTextToken;
        return response()->json(['token'=>$token,'user'=>User::where('id',$user->id)->with('permisos')->with('unit')->firstOrFail()],200);;
    }
    public function store(Request $request){
        $user=new User();
        $user->nombres=strtoupper($request->nombres);
        $user->apellidos=strtoupper($request->apellidos);
        $user->expedido=  $request->expedido;
        $user->fechanac=  $request->fechanac;
       // $user->email=$request->email;
        $user->email=substr(strtoupper($request->nombres),0,1).substr(strtoupper($request->apellidos),0,1).$request->carnet.'@santarosa2.com';
        $user->tipo=$request->tipo;
        $user->password= Hash::make($request->password) ;
        //$user->unit_id=$request->unit_id;
        $user->fechalimite=$request->fechalimite;
        $user->carnet=$request->carnet;
        $user->unit_id=1;
//        $user->codigo= strtoupper( substr($request->name,0,3));
        $user->save();
        $permisos= array();
        foreach ($request->permisos as $permiso){
            if ($permiso['estado']==true)
                $permisos[]=$permiso['id'];
        }
        $permiso = Permiso::find($permisos);
        $user->permisos()->attach($permiso);
    }
    public function update(Request $request,User $user){
//        return $request->all();
        //$user->update($request->all());
        $user=User::find($request->id);
        $user->nombres=strtoupper($request->nombres);
        $user->apellidos=strtoupper($request->apellidos);
        //$user->expedido=  $request->expedido;
        //$user->fechanac=  $request->fechanac;
        $user->tipo=$request->tipo;
        $user->email=$request->email;
        //$user->password= Hash::make($request->password) ;
       //$user->unit_id=$request->unit_id;
        $user->fechalimite=$request->fechalimite;
        $user->carnet=$request->carnet;
        //$user->unit_id=1;
//        $user->codigo= strtoupper( substr($request->name,0,3));
        $user->save();
        return $user;
    }
    public function updatepermisos(Request $request,User $user){
        $permisos= array();
        foreach ($request->permisos as $permiso){
            if ($permiso['estado']==true)
                $permisos[]=$permiso['id'];
        }
        $permiso = Permiso::find($permisos);
        $user->permisos()->detach();
        $user->permisos()->attach($permiso);
    }
    public function pass(Request $request,User $user){
        $user->update([
            'password'=>Hash::make($request->password)
        ]);
        return $user;
    }
    public function destroy(User $user){
        $user->delete();
    }
    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json(['res'=>'salido exitosamente'],200);
    }
    public function me(Request $request){
        $user=User::where('id',$request->user()->id)->with('unit')->with('permisos')->firstOrFail();
        return $user;
    }

    public function listprofesor(){
        //return DB::SELECT('SELECT id,nombres,apellidos,carnet,expedido,email,fechalimite from users where tipo="PROFESOR"');
        return User::with('materias')->with('cursos')->where('tipo','PROFESOR')->get();
    }

    public function asignarMateria(Request $request){
        //return $request;
        DB::SELECT("DELETE from materia_user where user_id=".$request->user['id']);
        foreach($request->materias as $m ){
            DB::table('materia_user')->insert(['user_id'=>$request->user['id'],'materia_id'=>$m]);
        }
    }

    
    public function asignarCurso(Request $request){
        DB::SELECT("DELETE from curso_user where user_id=".$request->user['id']);
        foreach($request->cursos as $m ){
            DB::table('curso_user')->insert(['user_id'=>$request->user['id'],'curso_id'=>$m]);
        }
    }
}
