<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientesController extends Controller
{
    
    public function index(Request $request){
        $clientes=$request->user()->clients;
        return view('sistema.clientes.index',compact('clientes'));

    }


}
