<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cargo;
use App\Models\CargoAcesso;
use App\Models\Usuario;

class UserSuporteAPI extends Controller
{

    public function index()
    {
        $users = Usuario::with(['cargo'])->get();
        return response()->json($users,200);
    }

    
    public function store(Request $request)
    {
        //
    }

    
    public function show($id)
    {
        //
    }

   
    public function update(Request $request, $id)
    {
        //
    }

    
    public function destroy($id)
    {
        //
    }
}
