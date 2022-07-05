<?php

namespace App\Http\Controllers;
use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\Ajuste;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

use DataTables;
use Illuminate\Http\Request;

class ComprasController extends Controller
{
    public function index(Request $request)
    {
        return view('compras.index');        
    }

   

    public function crearCompra()
    {
        $compra= New Compra();
        $proveedores= Proveedor::all();
        $productos= Producto::all();
        return view('compras.crear', compact('compra','proveedores','productos'));
    }

    public function guardarCompra(Request $request)
    {

        DB::beginTransaction();
                try {
                   /*  dd($request); */
                    if ( $request->id_compra!=null )  {    

                        $compra = Compra::findOrFail($request->id_compra);                      
                        $compra->fecha_compra = $request->compra['fecha_compra'];
                        $compra->total_compra = $request->compra['total_compra'];
                        $compra->id_proveedor = $request->compra['id_proveedor']; 
        
                        $compra->save();




                        //RECORRER COSTOS Y ELIMINARLOS
                        $detalleCompras= DetalleCompra::where('id_compra',  $request->id_compra) ->get();

                        foreach($detalleCompras as $detalleCompraEliminar){
                            $detalleCompraEliminar->delete();                           
                        }    



                        $total=0;
                        //RECORRER PRODUCTOS Y CREAR DETALLES COMPRAS
                        
                        if ($request->productos_compra != null){
                            foreach($request->productos_compra as $productoCompra){
                                $detalleCompra= DetalleCompra::create([                                    
                                    'cantidad' => $productoCompra['cantidad'],
                                    'total_detalle' => $productoCompra['total_detalle'],
                                    'precio_unitario' => $productoCompra['precio_unitario'],                              
                                    'id_producto' => $productoCompra['id_producto'],       
                                    'id_compra' => $request->id_compra,                       
                                ]);  
                                $total=$total+$productoCompra['total_detalle'];                      
                            }
                        }


                        //ASIGNAR TOTAL RECIEN CALCULADO
                        $compra = Compra::findOrFail($request->id_compra);                                             
                        $compra->total_compra = $total;            
                        $compra->save();                        


                    

                    }else{

                        //CREAR COMPRA
                        $compra = Compra::create([   
                            'fecha_compra' => $request->compra['fecha_compra'],
                            'total_compra' => 0,
                            'id_usuario' => $request->id_usuario,
                            'id_proveedor' => $request->compra['id_proveedor'],               
                        ]);                      
                        $ultimoIdCompra = $compra->id;
                        $total=0;


                        //RECORRER PRODUCTOS Y CREAR DETALLES COMPRAS
                        
                        if ($request->productos_compra != null){
                            
                            foreach($request->productos_compra as $productoCompra){
                                $detalleCompra= DetalleCompra::create([                                 
                                    'cantidad' => $productoCompra['cantidad'],
                                    'total_detalle' => $productoCompra['total_detalle'],
                                    'precio_unitario' => $productoCompra['precio_unitario'],                              
                                    'id_producto' => $productoCompra['id_producto'],       
                                    'id_compra' => $ultimoIdCompra,                                                         
                                ]);
                                $total=$total+$productoCompra['total_detalle'];

                                 //SUMAR STOCK A PRODUCTO POR LA COMPRA
                                $producto = Producto::findOrFail($productoCompra['id_producto']);                      
                                $producto->stock = $producto->stock + $productoCompra['cantidad'];     
                                $producto->save();

                                //CREAR REGISTO EN AJUSTES

                                $ajuste = Ajuste::create([   
                                    'motivo' => strval($productoCompra['cantidad']) . ' Unidades añadidas a través de compra ID N° ' . strval($ultimoIdCompra),
                                    'stock' => $producto->stock,    
                                    'id_usuario' => $request->id_usuario,   
                                    'id_producto' => $productoCompra['id_producto'],   
                                ]);           

                            }                           
                        }


                        //ASIGNAR TOTAL RECIEN CALCULADO

                        $compra = Compra::findOrFail($ultimoIdCompra);                                             
                        $compra->total_compra = $total;            
                        $compra->save();


                       
                    } 
                    
                    DB::commit();
                    alert()->success('¡Éxito!','Compra guardada satisfactoriamente');
                    return redirect(route('compras.index'));
                } catch (\Exception $e) {
                    
                    DB::rollback();
                    alert()->error('Error','No se pueden guardar los datos, intente nuevamente');
                    dd($e);
                    return redirect()->back()->withInput();
                return $e->getMessage();
                } 

    }


    public function editarCompra($id)
    {
        $compra =  Compra::find($id);
        $proveedores= Proveedor::all();
        $productos= Producto::all();
        return view('compras.editar',compact('compra','proveedores','productos'));
    }

    public function eliminarCompra($id){
        try {
            Compra::find($id)->delete();
            return redirect()->route('compras.index');
        } catch (Exception $e) {
            alert()->error('Error','No se pudo eliminar la compra, intente nuevamente');
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

        function fecha($date, $format = 'd-m-Y')
    {
        if ($date==null){
            return 'SIN FECHA';
        }else{
            return date($format, strtotime($date));
        }

    }


        if ($request->ajax()) {
            $data = Compra::all();     
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($compra){
               
                    $actionBtn = '<a href="'.route('compras.editar',$compra->id).'" class="edit btn btn-warning btn-sm ">Editar</a> 
                    <a href="'.route('compras.reportePDF', [$compra->id, 'pdf']).'" class="edit btn btn-dark btn-sm ">PDF</a>
                    <form action="'.route('compras.eliminar',$compra->id).'" class="d-inline js-form-eliminar" method="post">
                        <input type="hidden" name="_token" value="'.csrf_token().'">
                        <input type="hidden" name="_method" value="delete" />
                        <input class="delete btn btn-danger btn-sm" type="submit" value="Eliminar" />    
                    </form>';
                    return $actionBtn;
                
            })  
            
            ->addColumn('total_compra', function($compra){ 
                return moneda($compra->total_compra);
            })

            ->addColumn('fecha_compra', function($compra){ 
                return fecha($compra->fecha_compra);
            })

            ->addColumn('proveedor', function($compra){ 
                return $compra->proveedor->nombre;
            })

            ->addColumn('usuario', function($compra){ 
                return $compra->usuario->name;
            })
            ->rawColumns(['action','total_compra','proveedor','usuario','fecha_compra'])
            ->make(true);
        }
    }


    public function reportePDF(Request $request,$id)
    
    {
        $compra2 = Compra::where('id', $id)->first();
             
        $compra = ['compra'=>$compra2];        
        $pdf = PDF::loadView('compras.pdf', $compra);
        return $pdf->stream('Compra Detallada.pdf');

    }


}
