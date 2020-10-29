<?php

namespace App\Http\Controllers;

use App\Models\CargoAcesso;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
use App\User;
use Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Hash as FacadesHash;

class LoginClienteController extends Controller
{
    public function form()
    {
        if (Auth::user()){
            
            $uid= Auth::user()->id_usuario;
            $unome= Auth::user()->nome;
            $ucargo= Auth::user()->cargo->id_cargo;
            $unomecargo= Auth::user()->cargo->descricao;

            //dd($unomecargo);
            $arquivo = 'storage/img/users/'.$uid.'.jpg';
            if(file_exists($arquivo)){
            $uimagem = $arquivo;
            } else {
            $uimagem = 'storage/img/users/default.jpg';
            }

            $role = CargoAcesso::where('cargo_cod', $ucargo)
                                    ->pluck('status');

         
            $acessoCargo = CargoAcesso::where('cargo_cod', $ucargo)
                                       ->select('role','status')
                                       ->get();
            
                                
            if ($role[0]  == 1){
                return view('cliente.index',compact('ucargo','unomecargo','unome','uid','uimagem','acessoCargo'));
            }else{
                return view('nopermission');
            }  

        }else{

            return view('loginCli');

        }
    }

    public function Login(Request $request)
    {
        //dd(bcrypt($request->password));
        $request->validate([
            'email' => 'required',
            'senha' => 'required'
        ]);


        $lembrar = empty($request->remember) ? false : true;

        $usuario = User::where('email', $request->email)
                       ->with(['cargo'])
                       ->first();
        
        if(!$usuario){
            return redirect()->action('LoginClienteController@form')->with('status_login_error', 'Usuário inexistente!');
        }

        $statusUser = User::where('email', $request->email)->first();
        //dd($statusUser);
        //dd(bcrypt($request->senha));
            
        if(!$usuario->cargo->status){
            return redirect()->action('LoginSuporteController@form')->with('status_login_error', 'Cargo inativo!');
        }
        

       
        if ($usuario && FacadesHash::check($request->senha, $usuario->password)) {
           
            FacadesAuth::loginUsingId($usuario->id_usuario, $lembrar);
        }
            
       

        if($statusUser->ativo==0){
            return redirect()->action('LoginClienteController@form')->with('status_login_error', 'Usuário Inativo!');
        }else{
            return redirect()->action('LoginClienteController@form')->with('status_login_error', 'Por favor, verifique os dados!');
        }
          
    }



}
