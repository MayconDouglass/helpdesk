<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\CargoAcesso;
use App\Models\Setor;
use Illuminate\Http\Request;
use Auth;

class SetorController extends Controller
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

            $setores = Setor::all();

            if ($role[4]  == 1){
                return view('suporte.setor',compact('ucargo','unomecargo','unome','uid','uimagem','setores','acessoCargo'));
            }else{
                return redirect('/nopermission');
            }  

        }else{

            return route('loginSup');

        }
    }

    public function store(Request $request){
       
        $countSetor = count(Setor::where('descricao',$request->descricaocad)->get());
       
            if($countSetor < 1){
                $setor = new Setor;
                $setor->descricao = $request->descricaocad;
                $setor->status = $request->statuscad;
                $saveStatus = $setor->save();

                if($saveStatus){            
                    return redirect()->action('SetorController@create')->with('status_success', 'Setor Cadastrada!');
                }else{
                    return redirect()->action('SetorController@create')->with('status_error', 'OPS! Algum erro no cadastro, tente novamente!');
                }

            }else{
                return redirect()->action('SetorController@create')->with('status_error', 'Já existe um setor com esta descrição!');
            }
    }

    public function update(Request $request){
        $setor = Setor::find($request->idSetorAlt);
        $setor->descricao = $request->descricaoAlt;
        $setor->status = $request->statusAlt;
        $saveUpdate = $setor->save();
            if($saveUpdate){            
                    return redirect()->action('SetorController@create')->with('status_success', 'Setor Atualizado!');
            }else{
                    return redirect()->action('SetorController@create')->with('status_error', 'OPS! Algum erro na alteração, tente novamente!');
            }

   
    }


    public function destroy(Request $request){
            
            if(empty($request->iddelete)){
                return redirect()->action('SetorController@create')->with('status_error', 'Falha!');    
            }

            $setor = Setor::find($request->iddelete);
            $delete = $setor->delete();
            
            if($delete){
                return redirect()->action('SetorController@create')->with('status_success', 'Setor Excluído!');
            }else{
                return redirect()->action('SetorController@create')->with('status_error', 'Não foi possível excluir o setor, possivelmente existem tickets associados!');    
            }

    }



}
