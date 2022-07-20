<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\DetalleServicio;
use Carbon\Carbon;
use DB;

class PanelController extends Controller
{
    public function index(Request $request)
    {
        $productos_mes = DetalleVenta::join('productos', 'productos.id', '=', 'detalle_ventas.id_producto' )
        ->join('ventas', 'ventas.id', '=', 'detalle_ventas.id_venta' )
        ->select(DB::raw('sum(detalle_ventas.cantidad) as cantidad,sum(detalle_ventas.total_detalle) as suma_precios'), 'productos.nombre')
        
        ->whereMonth('fecha_venta', Carbon::now()->month)
        ->groupBy('detalle_ventas.id_producto')
        ->get();



        $servicios_mes = DetalleServicio::join('servicios', 'servicios.id', '=', 'detalle_servicios.id_servicio' )
        ->join('ventas', 'ventas.id', '=', 'detalle_servicios.id_venta' )
        ->select(DB::raw('sum(detalle_servicios.cantidad) as cantidad,sum(detalle_servicios.total_detalle) as suma_precios'), 'servicios.nombre')
        ->whereMonth('fecha_venta', Carbon::now()->month)
        ->groupBy('detalle_servicios.id_servicio')
        ->get();

       
   




        $productos =  Producto::where('stock', '<', 5)->get();
        $ventas= Venta::whereMonth('fecha_venta', Carbon::now()->month)->get();

        $ventasMesAnterior= Venta::whereMonth('fecha_venta', Carbon::now()->month - 1)->get();

        $totalVentas=0;
        $totalVentasMesAnterior=0;
        foreach($ventas as $venta){
            $totalVentas=$totalVentas + $venta->total_venta;
        }

        foreach($ventasMesAnterior as $ventasMesAnterior){
            $totalVentasMesAnterior=$totalVentasMesAnterior + $ventasMesAnterior->total_venta;
        }
       

        $DetallesVentas= DetalleVenta::with('producto')->get();
        $DetallesServicios= DetalleServicio::with('servicio')->get();
      
       /*   dd($DetallesServicios);  */
        return view('panel',compact('productos','servicios_mes','DetallesVentas','DetallesServicios','totalVentas','totalVentasMesAnterior','productos_mes'));        
    }
}
