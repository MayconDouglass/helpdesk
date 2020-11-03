<?php

namespace App\Http\Controllers;
use App\Models\Cargo;
use App\Models\CargoAcesso;
use App\Models\Role;
use Illuminate\Http\Request;
use Auth;

class CargoController extends Controller
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

            $cargos = Cargo::all();
        
            if ($role[4]  == 1){
                return view('suporte.cargos',compact('ucargo','unomecargo','unome','uid','uimagem','cargos','acessoCargo'));
            }else{
                return redirect('/nopermission');
            }  

        }else{

            return route('loginSup');

        }
    }

    public function store(Request $request){
       
        $countCargo = count(Cargo::where('descricao',$request->descricaocad)->get());
       
            if($countCargo < 1){
                $cargo = new Cargo;
                $cargo->descricao = $request->descricaocad;
                $cargo->status = $request->statuscad;
                $saveStatus = $cargo->save();

                if($saveStatus){            
                    return redirect()->action('CargoController@create')->with('status_success', 'Cargo Cadastrado!');
                }else{
                    return redirect()->action('CargoController@create')->with('status_error', 'OPS! Algum erro no cadastro, tente novamente!');
                }

            }else{
                return redirect()->action('CargoController@create')->with('status_error', 'Já existe um cargo com esta descrição!');
            }
    }

    public function update(Request $request){
        $cargo = Cargo::find($request->idCargoAlt);
        $cargo->descricao = $request->descricaoAlt;
        $cargo->status = $request->statusAlt;
        $cargo->data_alt = date('Y-m-d H:i:s');
        $saveStatus = $cargo->save();


            if($saveStatus){            
                    return redirect()->action('CargoController@create')->with('status_success', 'Cargo Atualizado!');
            }else{
                    return redirect()->action('CargoController@create')->with('status_error', 'OPS! Algum erro na alteração, tente novamente!');
            }

   
    }

    public function destroy(Request $request){
        if(empty($request->iddelete)){
            return redirect()->action('CargoController@create')->with('status_error', 'Falha!');    
            }
            $cargo = Cargo::find($request->iddelete);
            $delete=$cargo->delete();
            
            if($delete){
                return redirect()->action('CargoController@create')->with('status_success', 'Cargo Excluído!');
            }else{
                return redirect()->action('CargoController@create')->with('status_error', 'Erro ao excluir, possivelmente existem usuários relacionados à este cargo!');    
            }
    }


    public function atualizarPermissao(Request $request){
        $select = 'role';
        $acesso = CargoAcesso::where('cargo_cod','=',$request->idCargo)->get();  
        $sizeRole = Role::all()->max('id_role');
  
        if(count($acesso) > 0){
            for ($i=1; $i < $sizeRole + 1; $i++) { 
                $roleExist = CargoAcesso::where('cargo_cod','=',$request->idCargo)
                                 ->where('role','=',$i)
                                 ->get();  
                                 
                if(count($roleExist) > 0){
                    if($request->role5){
                        $cargoAcesso = CargoAcesso::where('cargo_cod','=',$request->idCargo)->where('role',$i)->first();     
                        $cargoAcesso->cargo_cod = $request->idCargo;
                        $cargoAcesso->role = $i;
                        $cargoAcesso->status = 1;
                        $cargoAcesso->save();
                    }else{
                        $cargoAcesso = CargoAcesso::where('cargo_cod','=',$request->idCargo)->where('role',$i)->first();     
                        $cargoAcesso->cargo_cod = $request->idCargo;
                        $cargoAcesso->role = $i;
                        $cargoAcesso->status = $request->input($select.$i);
                        $cargoAcesso->save(); 
                    }
                }else{
                    $status = $request->input($select.'5');

                    $cargoAcesso = new CargoAcesso();     
                    $cargoAcesso->cargo_cod = $request->idCargo;
                    $cargoAcesso->role = $i;
                    $cargoAcesso->status = $status ? 1 : $request->input($select.$i);
                    $cargoAcesso->save(); 
                }
            }
        }else{
            foreach (range(1,$sizeRole) as $size => $role) {
                $cargoAcesso = new CargoAcesso();     
                $cargoAcesso->cargo_cod = $request->idCargo;
                $cargoAcesso->role = $role;
                $cargoAcesso->status = $request->input($select.$role);
                $cargoAcesso->save();
            }             
        }              
        
        $cargo = Cargo::find($request->idCargo);
        $cargo->data_alt = date('Y-m-d H:i:s');
        $statusAcesso = $cargo->save();
        
            if($statusAcesso){   
                return redirect()->action('CargoController@create')->with('status_success', 'Permissões atualizadas!');
            }else{
                return redirect()->action('CargoController@create')->with('status_error', 'Não foi possível atualizar as permissões deste cargo, tente novamente!');    
            }
    }

    public function obterPermissaoCargo(Request $request){
     
        $permissao = CargoAcesso::where('cargo_cod',$request->id)->pluck('status');
      
        return response()->json([$permissao],200);

    }

    public function countRoleCargo(){
 
        $permissao = Role::all()->max('id_role');

        return response()->json($permissao,200);

    }
}

