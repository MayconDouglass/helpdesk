<?php

namespace App\Http\Controllers;
use App\Models\Cargo;
use App\Models\CargoAcesso;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Auth;

class UserSuporteController extends Controller
{
    public function create(){
        if (Auth::user()){
            $uid= Auth::user()->id_usuario;
            $unome= Auth::user()->nome;
            $ucargo= Auth::user()->cargo_cod;
            $unomecargo= Auth::user()->cargo->descricao;

            
            $statusCargo= Cargo::find(Auth::user()->cargo_cod);

            if($statusCargo->status == 0){
                Auth::logout();
            }
            
            //dd();
            $arquivo = '/storage/img/users/'.$uid.'.jpg';
            if(file_exists('storage/img/users/'.$uid.'.jpg')){
            $uimagem = $arquivo;
            } else {
            $uimagem = '/storage/img/users/default.jpg';
            }
            
                    

            $role = CargoAcesso::where('cargo_cod',$ucargo)
                                    ->pluck('status');

            $acessoCargo = CargoAcesso::where('cargo_cod',$ucargo)
                                      ->select('role','status')
                                      ->get();

            $usuarios = Usuario::all();

            $cargos = Cargo::where('status',1)
                           ->get();
           
            if ($role[4]  == 1){
                return view('suporte.usuarios',compact('ucargo','unomecargo','unome','uid','uimagem','usuarios','cargos','acessoCargo'));
            }else{
                return redirect('/nopermission');
            }  

        }else{

            return route('loginSup');

        }
    }

    public function store(Request $request){
       
        $countUser = count(Usuario::where('email',$request->emailcad)->get());
       
            if($countUser < 1){
                $usuario = new Usuario();
                $usuario->cargo_cod = $request->cargocad;
                $usuario->nome = $request->nomecad;
                $usuario->email = $request->emailcad;
                $usuario->password = bcrypt($request->passwordcad);
                $usuario->ativo = $request->ativacad;
                $usuario->usucad = Auth::user()->id_usuario;
                $saveStatus = $usuario->save();

                if($request->fotocad){
                    $file = $request->fotocad;
                    $filename= $usuario->id_usuario.'.jpg';
                    $info = getimagesize($file);
                    $destination_path = 'storage/img/users/';
    
                    if ($info['mime'] == 'image/jpeg') {
                        $image = imagecreatefromjpeg($file, 6);
                    }elseif($info['mime'] == 'image/png'){
                        $image = imagecreatefrompng($file, 6);
                    }
            
                    imagejpeg($image, $destination_path.$filename, 70);
                }

                if($saveStatus){            
                    return redirect()->action('UserSuporteController@create')->with('status_success', 'Usuário Cadastrado!');
                }else{
                    return redirect()->action('UserSuporteController@create')->with('status_error', 'OPS! Algum erro no cadastro, tente novamente!');
                }

            }else{
                return redirect()->action('UserSuporteController@create')->with('status_error', 'Já existe um usuário com este email!');
            }
    }

    public function update(Request $request){
        $usuario = Usuario::find($request->idUser);
        //dd($request->idUser);
        $usuario->cargo_cod = $request->cargoAlt;
        $usuario->nome = $request->nomeAlt;
        $usuario->ativo = $request->statusAlt;
        $usuario->usucad = Auth::user()->id_usuario;
        $usuario->data_alt = date('Y-m-d H:i:s');
        $saveUpdate = $usuario->save();

            if($request->fotoalt){
                $file = $request->fotoalt;
                $filename= $usuario->id_usuario.'.jpg';
                $info = getimagesize($file);
                $destination_path = 'storage/img/users/';
    
                if ($info['mime'] == 'image/jpeg') {
                    $image = imagecreatefromjpeg($file);
                }elseif($info['mime'] == 'image/png'){
                    $image = imagecreatefrompng($file);
                }
            
                imagejpeg($image, $destination_path.$filename, 50);
            }

            if($saveUpdate){            
                    return redirect()->action('UserSuporteController@create')->with('status_success', 'Usuário Atualizado!');
            }else{
                    return redirect()->action('UserSuporteController@create')->with('status_error', 'OPS! Algum erro na alteração, tente novamente!');
            }

   
    }


    public function resetPassword(Request $request){

        if(empty($request->idUser)){

            return redirect()->action('UserSuporteController@create')->with('status_error', 'Falha!');  

        }
        
        $usuario = Usuario::find($request->idUser);
        $usuario->password = bcrypt('123');
        
        if($usuario->save()){

            return redirect()->action('UserSuporteController@create')->with('status_success', 'Senha resetada!');

        }else{

            return redirect()->action('UserSuporteController@create')->with('status_error', 'OPS! Tente novamente!');

        }

    }

    public function destroy(Request $request){
        if(empty($request->iddelete)){
            return redirect()->action('UserSuporteController@create')->with('status_error', 'Falha!');    
            }
            $usuario = Usuario::find($request->iddelete);
            $delete=$usuario->delete();
            if($delete){
                $arquivo = 'storage/img/users/'.$request->iddelete.'.jpg';
                if(file_exists($arquivo)){
                unlink($arquivo);
                }
            return redirect()->action('UserSuporteController@create')->with('status_success', 'Usuário Excluído!');
            }else{
            return redirect()->action('UserSuporteController@create')->with('status_error', 'Não foi possível excluir o usuário, possivelmente existem movimentação/cadastros!');    
            }
    }



}
