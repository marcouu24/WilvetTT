<?php

namespace App\Http\Controllers;
use App\Models\Producto;
use App\Models\Categoria;
use RealRashid\SweetAlert\Facades\Alert;
use DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    public function index(Request $request)
    {
        return view('productos.index');        
    }

   

    public function crearProducto()
    {
        $producto= New Producto();
        $categorias= Categoria::all();
        return view('productos.crear', compact('producto','categorias'));
    }



    public function guardarProducto(Request $request)
    {
        try{
            if ( $request->id ) {
                $producto_existente = Producto::where('nombre', $request->producto['nombre'])->first();
                if($producto_existente != null && $producto_existente->id != $request->id){
                    alert()->error('Error','Ya exite un producto con ese nombre');
                    return redirect()->back()->withInput();
                }
                $producto = Producto::findOrFail($request->id);
                $producto->update( $request->producto);   
            }else{
                $producto_existente = Producto::where('nombre', $request->producto['nombre'])->first();
                if($producto_existente == null){
                    $producto = Producto::create( $request->producto );
                }
                else{
                    alert()->error('Error','Ya exite un producto con ese nombre');
                    return redirect()->back()->withInput();
                }
            } 
            alert()->success('¡Éxito!','Producto guardado satisfactoriamente');
            return redirect(route('productos.index'));
        }catch(Exception $e){
            alert()->error('Error','No se pudo guardar el producto, intente nuevamente');
            report($e);
            return redirect()->back()->withInput();
        }
    }


    /* public function guardarProducto(Request $request)
    {
        try{
        
            if ( $request->id!=null ) { 

                $producto = Producto::findOrFail($request->id);
                $producto->update( $request->producto);   

            }else{
                $productoExistente = Producto::where('nombre', $request->producto['nombre'])->first();
                if($productoExistente == null){
                    $producto = Producto::create( $request->producto );
                }
                else{
                    alert()->error('Error','Ya existe un producto con ese Nombre.');
                   
                    return redirect()->back()->withInput();
                   
                }
            } 
            alert()->success('¡Éxito!','Producto guardado satisfactoriamente');
            return redirect(route('productos.index'));
        }catch(Exception $e){
            alert()->error('Error','No se pudo guardar el producto, intente nuevamente');
            report($e);
            return redirect()->back()->withInput();
        }
    }
 */

    public function editarProducto($id)
    {
        $producto =  Producto::find($id);
        $categorias= Categoria::all();
        return view('productos.editar',compact('producto','categorias'));
    }


    public function eliminarProducto($id){
        try {
            Producto::find($id)->delete();
            alert()->success('Éxito','Producto eliminado correctamente.');
            return redirect()->route('productos.index');
            
        } catch (Exception $e) {
            alert()->error('Error','No se pudo eliminar el producto, intente nuevamente');
            report($e);
            return redirect()->back();
        }
    }



    public function listar(Request $request) 
    {     

        function moneda($number, $prefix = '$ ', $decimals = 0)
        {
            return $prefix.number_format($number, $decimals, ',', '.');
        }

        
        if ($request->ajax()) {
            $data = Producto::all();     
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($producto){
               
                    $actionBtn = '<a href="'.route('productos.editar',$producto->id).'" class="edit btn btn-warning btn-sm ">Editar</a> 
                    
                    <form action="'.route('productos.eliminar',$producto->id).'" class="d-inline js-form-eliminar" method="post">
                        <input type="hidden" name="_token" value="'.csrf_token().'">
                        <input type="hidden" name="_method" value="delete" />
                        <input class="delete btn btn-danger btn-sm" type="submit" value="Eliminar" />    
                    </form>';
                    return $actionBtn;
                
            })    
            
            ->addColumn('categoria', function($producto){ 
                return $producto->categoria->nombre;
            })

                        
            ->addColumn('precio_venta', function($producto){ 
                return moneda($producto->precio_venta);
            })

            ->rawColumns(['action','categoria'])
            ->make(true);
        }
    }



    public function reportePDF(Request $request)
    {
        $datoss= Producto::orderby("stock","asc")->get();
      
        
        $datos = ['datos'=>$datoss];        
        
        
        $pdf = PDF::loadView('productos.pdf', $datos);
        return $pdf->stream('Listado Stock.pdf');

    }
    

}
