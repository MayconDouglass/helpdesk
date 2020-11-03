<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BuildDetail;
use App\Models\BuildList;
use Auth;

class BuildDetailAPI extends Controller
{
    
    public function index()
    {
        $build = BuildList::with('build_details')
                          ->get();

        return response()->json($build,200);
    }

    
    public function show($id)
    {
        $build = BuildList::where('id_build',$id)
                          ->with('build_details')
                          ->first();
        if(!$build)
            return response()->json(['erro'=>'404','status'=>'Nenhum dado encontrado'],404); 

        return response()->json($build,200);
    }
   
    
    public function showDetail($id)
    {
        $build = BuildDetail::where('id_details',$id)
                            ->first();
        if(!$build)
            return response()->json(['erro'=>'404','status'=>'Nenhum dado encontrado'],404); 

        return response()->json($build,200);
    }
   
    public function store(Request $request)
    {
        $detail = new BuildDetail;
        $detail->id_ticket = $request->id_ticket;
        $detail->id_build = $request->id_build;
        $detail->user = $request->idUser;
        $detail->data_liberacao = date('Y-m-d H:i:s',strtotime($request->data_liberacao));
        $detail->menu = $request->menu;
        $detail->modulo = $request->modulo;
        $detail->descricao = $request->laudo;
        $detail->status = $request->status;
        $saveStatus = $detail->save();

        if($saveStatus){
            return response()->json(['Code'=>'200','Status'=>'Salvo com sucesso'],200);
        }else{
            return response()->json(['Code'=>'500','Status'=>'Erro ao salvar, tente novamente'],500);
        }
    }


   
    public function update(Request $request, $id)
    {
        $detail = BuildDetail::find($id);
        dd($request->all());

        $saveUpdate = $detail->save();

    }

    public function updateDetail(Request $request, $id)
    {
        $detail = BuildDetail::find($id);
        
        $detail->user = $request->idUser;
        $detail->data_liberacao = date('Y-m-d H:i:s',strtotime($request->data_liberacao));
        $detail->id_ticket = $request->id_ticket;
        $detail->menu = $request->menu;
        $detail->modulo = $request->modulo;
        $detail->descricao = $request->laudo;
        $detail->status = $request->status;
        $saveUpdate = $detail->save();

        if($saveUpdate){
            return response()->json(['Code'=>'200','Status'=>'Atualizado com sucesso'],200);
        }else{
            return response()->json(['Code'=>'500','Status'=>'Erro ao atualizar, tente novamente'],500);
        }
    }

   
    public function destroy($id)
    {
        $detail = BuildDetail::find($id);
        if(!$id)
         return response()->json(['Code'=>'404','Status'=>'Nenhum dado encontrado'],404);
        
        if($detail->delete()){
            return response()->json(['Code'=>'200','Status'=>'Excluido com sucesso'],200);
        }else{
            return response()->json(['Code'=>'401','Status'=>'Erro ao excluir, verifique os dados'],401);
        }
    }
}
