<?php

namespace App\Http\Controllers;
use App\Models\DetalleVenta;
use App\Models\DetalleServicio;
use App\Models\Venta;
use App\Models\Cliente;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Servicio;
use App\Models\Producto;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;


use DataTables;
use Illuminate\Http\Request;

class VentasController extends Controller
{
    public function index(Request $request)
    {
        return view('ventas.index');        
    }

   

    public function crearVenta()
    {
      
        $venta= New Venta();
        $clientes= Cliente::all();
        $servicios= Servicio::all();
        $productos= Producto::all();
        return view('ventas.crear', compact('venta','servicios','productos','clientes'));
    }




    public function guardarVenta(Request $request)
    {

        DB::beginTransaction();
                try {
                   /*  dd($request); */
                    if ( $request->id_venta!=null )  {    

                        $venta = Venta::findOrFail($request->id_venta);                      
                        $venta->fecha_venta = $request->venta['fecha_venta'];
                        $venta->total_venta = 0;
                        $venta->rut_cliente = $request->venta['rut_cliente']; 
                                
                        $venta->save();




                        //RECORRER DETALLE VENTAS Y ELIMINARLOS
                        $detalleVentas= DetalleVenta::where('id_venta',  $request->id_venta) ->get();

                        foreach($detalleVentas as $detalleVentaEliminar){
                            $detalleVentaEliminar->delete();                           
                        }    

                        $totalProductos=0;
                        $totalServicios=0;
                        $totalVentaCompleto=0;


                        //RECORRER DETALLE SERVICIOS Y ELIMINARLOS
                        $detalleServicios= DetalleServicio::where('id_venta',  $request->id_venta) ->get();

                        foreach($detalleServicios as $detalleServiciosEliminar){
                            $detalleServiciosEliminar->delete();                           
                        }    

                        $totalProductos=0;
                        $totalServicios=0;
                        $totalVentaCompleto=0;                        



                        //RECORRER PRODUCTOS Y CREAR DETALLES VENTAS                      
                        if ($request->productos_venta != null){
                            
                            foreach($request->productos_venta as $productoVenta){
                                $detalleVenta= DetalleVenta::create([                                 
                                    'cantidad' => $productoVenta['cantidad'],
                                    'total_detalle' => $productoVenta['total_detalle'],               
                                    'id_producto' => $productoVenta['id_producto'],       
                                    'id_venta' => $request->id_venta,                                                         
                                ]);
                                $totalProductos=$totalProductos+$productoVenta['total_detalle'];
                            }                           
                        }


                        //RECORRER PRODUCTOS Y CREAR DETALLES VENTAS                      
                        if ($request->servicios_venta != null){
                            
                            foreach($request->servicios_venta as $servicioVenta){
                                $detalleServicio= DetalleServicio::create([                                                                    
                                    'total_detalle' => $servicioVenta['total_detalle'],               
                                    'id_servicio' => $servicioVenta['id_servicio'],       
                                    'id_venta' => $request->id_venta,     
                                    'cantidad' => $servicioVenta['cantidad'],                                                     
                                ]);
                                $totalServicios=$totalServicios+$servicioVenta['total_detalle'];
                            }                           
                        }

                        $totalVentaCompleto= $totalServicios + $totalProductos;

                        //ASIGNAR TOTAL RECIEN CALCULADO
                        $venta = Venta::findOrFail($request->id_venta);                                             
                        $venta->total_venta = $totalVentaCompleto;        
                        $venta->save();
                    

                    }else{
                        dd($request);
                        //CREAR VENTA
                        $venta = Venta::create([   
                            'fecha_venta' => $request->venta['fecha_venta'],
                            'total_venta' => 0,
                            'rut_cliente' => $request->venta['rut_cliente'],
                            'id_usuario' => $request->venta['id_usuario'],               
                        ]);                      
                        $ultimoIdVenta = $venta->id;
                        $totalProductos=0;
                        $totalServicios=0;
                        $totalVentaCompleto=0;



                        //RECORRER PRODUCTOS Y CREAR DETALLES VENTAS                      
                        if ($request->productos_venta != null){
                            
                            foreach($request->productos_venta as $productoVenta){
                                $detalleVenta= DetalleVenta::create([                                 
                                    'cantidad' => $productoVenta['cantidad'],
                                    'total_detalle' => $productoVenta['total_detalle'],               
                                    'id_producto' => $productoVenta['id_producto'],       
                                    'id_venta' => $ultimoIdVenta,                                                         
                                ]);
                                $totalProductos=$totalProductos+$productoVenta['total_detalle'];
                            }                           
                        }


                        //RECORRER PRODUCTOS Y CREAR DETALLES VENTAS                      
                        if ($request->servicios_venta != null){
                            
                            foreach($request->servicios_venta as $servicioVenta){
                                $detalleServicio= DetalleServicio::create([                                                                    
                                    'total_detalle' => $servicioVenta['total_detalle'],               
                                    'id_servicio' => $servicioVenta['id_servicio'],       
                                    'id_venta' => $ultimoIdVenta,    
                                    'cantidad' => $servicioVenta['cantidad'],                                                     
                                ]);
                                $totalServicios=$totalServicios+$servicioVenta['total_detalle'];
                            }                           
                        }

                        $totalVentaCompleto= $totalServicios + $totalProductos;

                        //ASIGNAR TOTAL RECIEN CALCULADO
                        $venta = Venta::findOrFail($ultimoIdVenta);                                             
                        $venta->total_venta = $totalVentaCompleto;        
                        $venta->save();

                    } 
                    
                    DB::commit();
                    alert()->success('¡Éxito!','Venta guardada satisfactoriamente');
                    return redirect(route('ventas.index'));
                } catch (\Exception $e) {
                    
                    DB::rollback();
                    dd($e);
                    alert()->error('Error','No se pueden guardar los datos, intente nuevamente');
                    
                    return redirect()->back()->withInput();
                return $e->getMessage();
                } 

    }


    public function editarVenta($id)
    {
        $venta =  Venta::find($id);
        $servicios= Servicio::all();
        $productos= Producto::all();
        return view('ventas.editar',compact('venta','servicios','productos'));
    }

    public function eliminarVenta($id){
        try {
            Venta::find($id)->delete();
            return redirect()->route('ventas.index');
        } catch (Exception $e) {
            alert()->error('Error','No se pudo eliminar la venta, intente nuevamente');
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
            $data = Venta::all();     
            return Datatables::of($data)
            ->addIndexColumn()




            ->addColumn('action', function($venta){
               
                    $actionBtn = '<a href="'.route('ventas.editar',$venta->id).'" class="edit btn btn-warning btn-sm ">Editar</a> 
                    <a href="'.route('ventas.reportePDF', [$venta->id, 'pdf']).'" class="edit btn btn-dark btn-sm ">PDF</a>
                    <form action="'.route('ventas.eliminar',$venta->id).'" class="d-inline js-form-eliminar" method="post">
                        <input type="hidden" name="_token" value="'.csrf_token().'">
                        <input type="hidden" name="_method" value="delete" />
                        <input class="delete btn btn-danger btn-sm" type="submit" value="Eliminar" />    
                    </form>';
                    return $actionBtn;
                
            })  
            
            ->addColumn('total_venta', function($venta){ 
                return moneda($venta->total_venta);
            })

            ->addColumn('fecha_venta', function($venta){ 
                return fecha($venta->fecha_venta);
            })


            ->addColumn('usuario', function($venta){ 
                return $venta->usuario->name;
            })
            ->rawColumns(['action','total_venta','usuario','fecha_venta'])
            ->make(true);
        }
    }



    public function obtenerStockProducto($id)
    {
        $producto = Producto::find($id);
        $stock= $producto->stock;

        return $stock;
    }


    
    public function reportePDF(Request $request,$id)
    
    {
        $venta2 = Venta::where('id', $id)->first();
             
        $venta = ['venta'=>$venta2];        
        $pdf = PDF::loadView('ventas.pdf', $venta);
        return $pdf->stream('Venta Detallada.pdf');

    }


}
