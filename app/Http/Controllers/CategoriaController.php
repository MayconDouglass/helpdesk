<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\CargoAcesso;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Auth;

class CategoriaController extends Controller
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

            $categorias = Categoria::all();

            if ($role[4]  == 1){
                return view('suporte.categorias',compact('ucargo','unomecargo','unome','uid','uimagem','categorias','acessoCargo'));
            }else{
                return redirect('/nopermission');
            }  

        }else{

            return route('loginSup');

        }
    }

    public function store(Request $request){
       
        $countCategoria = count(Categoria::where('descricao',$request->descricaocad)->get());
       
            if($countCategoria < 1){
                $categoria = new Categoria;
                $categoria->tipo = $request->tipocad;
                $categoria->descricao = $request->descricaocad;
                $categoria->status = $request->statuscad;
                $saveStatus = $categoria->save();

                if($saveStatus){            
                    return redirect()->action('CategoriaController@create')->with('status_success', 'Categoria Cadastrada!');
                }else{
                    return redirect()->action('CategoriaController@create')->with('status_error', 'OPS! Algum erro no cadastro, tente novamente!');
                }

            }else{
                return redirect()->action('CategoriaController@create')->with('status_error', 'Já existe uma categoria com esta descrição!');
            }
    }

    public function update(Request $request){
        $categoria = Categoria::find($request->idCategoriaAlt);
        //dd($request->idUser);
        $categoria->tipo = $request->tipoAlt;
        $categoria->descricao = $request->descricaoAlt;
        $categoria->status = $request->statusAlt;
        $saveUpdate = $categoria->save();
            if($saveUpdate){            
                    return redirect()->action('CategoriaController@create')->with('status_success', 'Categoria Atualizada!');
            }else{
                    return redirect()->action('CategoriaController@create')->with('status_error', 'OPS! Algum erro na alteração, tente novamente!');
            }

   
    }


    public function destroy(Request $request){
            
            if(empty($request->iddelete)){
                return redirect()->action('CategoriaController@create')->with('status_error', 'Falha!');    
            }

            $categoria = Categoria::find($request->iddelete);
            $delete = $categoria->delete();
            
            if($delete){
                return redirect()->action('CategoriaController@create')->with('status_success', 'Categoria Excluída!');
            }else{
                return redirect()->action('CategoriaController@create')->with('status_error', 'Não foi possível excluir a categoria, possivelmente existem registros associados!');    
            }

    }



}
