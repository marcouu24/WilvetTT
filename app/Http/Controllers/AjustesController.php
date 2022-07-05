<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Ajuste;
use RealRashid\SweetAlert\Facades\Alert;
use DataTables;
class AjustesController extends Controller
{
    public function index(Request $request)
    {
        return view('ajustes.index');        
    }

   

    public function crearAjuste()
    {
        $ajuste= New Ajuste();
        $productos= Producto::all();
        return view('ajustes.crear', compact('productos','ajuste'));
    }


    
    public function guardarAjuste(Request $request)
    {
        

        try{

            $ajuste = Ajuste::create([   
                'motivo' => $request->producto_ajuste['motivo'],
                'stock' => $request->producto_ajuste['stock'],    
                'id_usuario' => $request->producto_ajuste['id_usuario'],     
                'id_producto' => $request->producto_ajuste['id_producto'],        
            ]);           
            
            $producto = Producto::findOrFail($request->producto_ajuste['id_producto'],);                      
            $producto->stock = $request->producto_ajuste['stock'];       
            $producto->save();


             
            alert()->success('¡Éxito!','Ajuste guardado satisfactoriamente');
            return redirect(route('ajustes.index'));
        }catch(Exception $e){
            alert()->error('Error','No se pudo guardar el ajuste, intente nuevamente');
            report($e);
            return redirect()->back()->withInput();
        }
    }

    public function listar(Request $request) 
    {     

        function fecha($date, $format = 'd-m-Y')
        {
            if ($date==null){
                return 'SIN FECHA';
            }else{
                return date($format, strtotime($date));
            }
    
        }
        
        if ($request->ajax()) {
            $data = Ajuste::all();     
            return Datatables::of($data)
            ->addIndexColumn()
           
            ->addColumn('fecha', function($ajuste){ 
                return fecha($ajuste->created_at);
            })

            ->addColumn('producto', function($ajuste){ 
                return $ajuste->producto->nombre;
            })

            ->addColumn('usuario', function($ajuste){ 
                return $ajuste->usuario->name;
            })

                        

            ->rawColumns(['fecha','usuario','producto'])
            ->make(true);
        }
    }



    

}
