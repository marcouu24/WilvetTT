<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
class PanelController extends Controller
{
    public function index(Request $request)
    {
        $productos =  Producto::where('stock', '<', 5)->get();
        return view('panel',compact('productos'));        
    }
}
