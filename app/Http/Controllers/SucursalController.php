<?php

namespace App\Http\Controllers;

use App\Sucursal;
use Illuminate\Http\Request;

class SucursalController extends Controller
{

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra una lista de las sucursales
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('sucursal.index',['sucursales'=>Sucursal::all()]);
    }

}
