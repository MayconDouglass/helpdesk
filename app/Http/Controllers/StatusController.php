<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\CargoAcesso;
use App\Models\StatusTicket;
use Illuminate\Http\Request;
use Auth;

class StatusController extends Controller
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

            $statusTickets = StatusTicket::all();

            if ($role[4]  == 1){
                return view('suporte.status',compact('ucargo','unomecargo','unome','uid','uimagem','statusTickets','acessoCargo'));
            }else{
                return redirect('/nopermission');
            }  

        }else{

            return route('loginSup');

        }
    }

    public function store(Request $request){
       
        $countStatus = count(StatusTicket::where('descricao',$request->descricaocad)->get());
       
            if($countStatus < 1){
                $status = new StatusTicket;
                $status->descricao = $request->descricaocad;
                $status->status = $request->statuscad;
                $saveStatus = $status->save();

                if($saveStatus){            
                    return redirect()->action('StatusController@create')->with('status_success', 'Status Cadastrado!');
                }else{
                    return redirect()->action('StatusController@create')->with('status_error', 'OPS! Algum erro no cadastro, tente novamente!');
                }

            }else{
                return redirect()->action('StatusController@create')->with('status_error', 'Já existe um status com esta descrição!');
            }
    }

    public function update(Request $request){
        $status = StatusTicket::find($request->idStatusAlt);
        $status->descricao = $request->descricaoAlt;
        $status->status = $request->statusAlt;

        $saveUpdate = $status->save();
            if($saveUpdate){            
                    return redirect()->action('StatusController@create')->with('status_success', 'Status Atualizado!');
            }else{
                    return redirect()->action('StatusController@create')->with('status_error', 'OPS! Algum erro na alteração, tente novamente!');
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
