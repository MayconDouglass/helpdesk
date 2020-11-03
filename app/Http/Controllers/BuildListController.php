<?php

namespace App\Http\Controllers;

use App\Models\BuildList;
use App\Models\Cargo;
use App\Models\CargoAcesso;
use App\Models\StatusTicket;
use Illuminate\Http\Request;
use Auth;

class BuildListController extends Controller
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

            $buildLists = BuildList::all();

            if ($role[0]  == 1){
                return view('suporte.buildlist',compact('ucargo','unomecargo','unome','uid','uimagem','buildLists','acessoCargo'));
            }else{
                return redirect('/nopermission');
            }  

        }else{

            return route('loginSup');

        }
    }

    public function store(Request $request){
       
        
                $build = new BuildList;
                $build->dialecto = $request->dialectocad;
                $build->build = $request->buildcad;
                $build->tipo = $request->tipocad;
                $build->observacao = $request->observacaocad;
                $build->status = $request->statuscad;
                $build->data_cad = date('Y-m-d H:i:s');
                $saveStatus = $build->save();

                if($saveStatus){            
                    return redirect()->action('BuildListController@create')->with('status_success', 'Build Cadastrada!');
                }else{
                    return redirect()->action('BuildListController@create')->with('status_error', 'OPS! Algum erro no cadastro, tente novamente!');
                }

    }

    public function update(Request $request){
        $build = BuildList::find($request->idBuildAlt);
        $build->dialecto = $request->dialectoAlt;
        $build->build = $request->buildAlt;
        $build->tipo = $request->tipoAlt;
        $build->observacao = $request->observacaoAlt;
        $build->status = $request->statusAlt;
        $build->data_alt = date('Y-m-d H:i:s');
        $saveUpdate = $build->save();
        
            if($saveUpdate){            
                    return redirect()->action('BuildListController@create')->with('status_success', 'BuildList Atualizada!');
            }else{
                    return redirect()->action('BuildListController@create')->with('status_error', 'OPS! Algum erro na alteração, tente novamente!');
            }

   
    }


    public function destroy(Request $request){
            
            if(empty($request->iddelete)){
                return redirect()->action('StatusController@create')->with('status_error', 'Falha!');    
            }

            $status = StatusTicket::find($request->iddelete);
            $delete = $status->delete();
            
            if($delete){
                return redirect()->action('StatusController@create')->with('status_success', 'Status Excluído!');
            }else{
                return redirect()->action('StatusController@create')->with('status_error', 'Não foi possível excluir o status, possivelmente existem tickets associados!');    
            }

    }



}
