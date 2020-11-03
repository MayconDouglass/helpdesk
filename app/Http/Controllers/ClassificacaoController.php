<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\CargoAcesso;
use App\Models\Classificacao;
use Illuminate\Http\Request;
use Auth;

class ClassificacaoController extends Controller
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

            $classificacoes = Classificacao::all();

            if ($role[4]  == 1){
                return view('suporte.classificacao',compact('ucargo','unomecargo','unome','uid','uimagem','classificacoes','acessoCargo'));
            }else{
                return redirect('/nopermission');
            }  

        }else{

            return route('loginSup');

        }
    }

    public function store(Request $request){
       
        $countClass = count(Classificacao::where('descricao',$request->descricaocad)->get());
       
            if($countClass < 1){
                $class = new Classificacao;
                $class->descricao = $request->descricaocad;
                $class->status = $request->statuscad;
                $saveStatus = $class->save();

                if($saveStatus){            
                    return redirect()->action('ClassificacaoController@create')->with('status_success', 'Classificação Cadastrada!');
                }else{
                    return redirect()->action('ClassificacaoController@create')->with('status_error', 'OPS! Algum erro no cadastro, tente novamente!');
                }

            }else{
                return redirect()->action('ClassificacaoController@create')->with('status_error', 'Já existe uma classificação com esta descrição!');
            }
    }

    public function update(Request $request){
        $class = Classificacao::find($request->idClassAlt);
        $class->descricao = $request->descricaoAlt;
        $class->status = $request->statusAlt;
        $saveUpdate = $class->save();
            if($saveUpdate){            
                    return redirect()->action('ClassificacaoController@create')->with('status_success', 'Classificação Atualizada!');
            }else{
                    return redirect()->action('ClassificacaoController@create')->with('status_error', 'OPS! Algum erro na alteração, tente novamente!');
            }

   
    }


    public function destroy(Request $request){
            
            if(empty($request->iddelete)){
                return redirect()->action('ClassificacaoController@create')->with('status_error', 'Falha!');    
            }

            $class = Classificacao::find($request->iddelete);
            $delete = $class->delete();
            
            if($delete){
                return redirect()->action('ClassificacaoController@create')->with('status_success', 'Classificação Excluída!');
            }else{
                return redirect()->action('ClassificacaoController@create')->with('status_error', 'Não foi possível excluir a classificação, possivelmente existem tickets associados!');    
            }

    }



}
