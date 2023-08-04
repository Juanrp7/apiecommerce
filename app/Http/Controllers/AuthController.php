<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\User;
use \stdClass;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    //Funcion para regitrar usuario
    public function registrar(Request $request){

        //Validacion de los campos
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        //comprueba la validacion
        if($validator->fails()){
            return response()->json($validator->errors());
        }

        //si pasa la validacion crea el usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        //Crea el token de autenticacion para poder acceder
        $token = $user->createToken('auth_token')->plainTextToken;

        //Retorna en formato Json toda la info del usuario, token y tipo de token
        return response()->json(['data' => $user, 'access_token' =>$token, 'token_type'=>'Bearer']);
    }

    //Funcion para Login
    public function login(Request $request){

        //Intento de Login
        //Si no encuentra el user o el password es incorrecto retorna mensaje
        if(!Auth::attempt($request->only('email','password'))){
            //return response()->json(["message"=>"Registro no encontrado"],404);
            return response()->json(['message' => 'No Autorizado'], 401);
        }
        //$user = User::whereEmailAndPassword($request->email, $request->password )->get();
        
        //return response()->json($user, 200);
        /*if(is_null($user)){
            return response()->json(["message"=>"Registro no encontrado"],404);
        }*/
        

        //Si los datos son correctos busca el usuario con el email
        $user = User::where('email',$request['email'])->firstOrFail();

        //Crea token de autenticacion
        $token = $user->createToken('auth_token')->plainTextToken;

        //Retorn datos
        return response()->json([
            'message' => 'Hola '.$user->name,
            'accesToken' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);

    }

    //Funcion para Logout
    public function logout(){
        //Todos los tokens del usuario atenticado son borrados
        auth()->user()->tokens()->delete();

        return[
            'message' => 'Se ha cerrado la session'
        ];
    }
}
