<!DOCTYPE html>
<html lang="en">
<head>
    @php
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

        
@endphp

    <meta charset="UTF-8">
    <title>Venta N° {{$venta->id}}</title>
    <style>
        body{
            font-family: sans-serif;
            font-size: 10pt;
        }
        .principal{
            float:left;
        }
        .logo{
            width: 200px;
            height: auto;
        }
        .secundario{
            float:right;
            text-align: justify;
            margin-right: 150px;
        }
        .secundario1{
            float:right;
            text-align: justify;
            margin-right: 50px;
        }
        .table{
            clear:both;
            margin: 40px auto;
            width: 100%;
            border-collapse: collapse;
        }
        .table > *{
            border-bottom: 1px solid #000;
            width: 100%
        }
        .total{
            font-weight: bold;
            font-size: 10pt;
            padding: 5px;
        }
        .num{
            text-align:right;
        }

/*         .table thead tr th{ 
            text-align:left;
        } */
    </style>
</head>
<body>
    <div class="principal">
        <img  src="https://i.imgur.com/5aHjoFt.jpg"height="80" alt="img"/>
        <h3>VENTA N° {{$venta->id}}</h3>
        
    </div>

    <div class="secundario">
        
       
        <h3>Usuario: {{$venta->usuario->name}}</h3>
        <h3>Cliente: @php
            if(isset($venta->cliente->nombre)==false){
                echo 'SIN REGISTRO';
            } else{
                echo $venta->cliente->nombre;
            }
        @endphp</h3>
    </div>

    <div class="secundario1">
        {{-- <h3>VENTA N° {{$venta->id}}</h3> --}}
        <h3>Fecha Venta: {{fecha($venta->fecha_venta)}}</h3>
        <h3>Total Venta: {{moneda($venta->total_venta)}}</h3>
        
    </div>


    
    
    
    
    
    <table class="table" >
        <thead>
            <tr>
                <th width="70%" align="left"width="">Producto</th>
                <th width="10%"  align="right" width="">Cantidad</th>
                <th width="20%" align="right" width="">Total Detalle</th>
            </tr>

        </thead>
        <tbody>
            @php($total_productos = 0)
            @foreach ($venta->detalle_ventas as  $detalleVenta)
            

            <tr style="border-bottom: 1px solid #ccc;">
                <td  align="left" >{{$detalleVenta->producto->nombre}}</td>
                <td align="right" >{{$detalleVenta->cantidad}}</td>
                <td align="right">{{moneda($detalleVenta->total_detalle)}}</td>
                
            </tr>

            @php($total_productos = $total_productos + $detalleVenta->total_detalle)
             
            
             @endforeach
           
        </tbody>
        <tfoot>
            <tr>            
                <td colspan="2" align="right"class="total">Total Productos: </td>
                <td  align="left" class="total num" style="padding:0"> {{moneda($total_productos)}}</td>
            </tr>
        </tfoot>
    </table>



    <table class="table" >
        <thead>
            <tr>
                <th width="70%" align="left"width="">Servicio</th>
                <th width="10%"  align="right" width="">Cantidad</th>
                <th width="20%" align="right" width="">Total Detalle</th>
            </tr>

        </thead>
        <tbody>
            @php($total_servicios = 0)
            @foreach ($venta->detalle_servicios as  $detalleServicio)
            

            <tr style="border-bottom: 1px solid #ccc;">
                <td  align="left" >{{$detalleServicio->servicio->nombre}}</td>
                <td align="right" >{{$detalleServicio->cantidad}}</td>
                <td align="right">{{moneda($detalleServicio->total_detalle)}}</td>
                
            </tr>

            @php($total_servicios = $total_servicios + $detalleServicio->total_detalle)
             
            
             @endforeach
           
        </tbody>
        <tfoot>
            <tr>            
                <td colspan="2" align="right"class="total">Total Servicios: </td>
                <td  align="left" class="total num" style="padding:0"> {{moneda($total_servicios)}}</td>
            </tr>
        </tfoot>
    </table>




{{--     <table class="table">
        <thead>
            <tr>
                <th width="70%" align="left">Servicio</th>
                <th width="10%"align="right" >Cantidad</th>
                <th width="20%"align="right"  >Total Detalle</th>
             </tr>
        </thead>
        <tbody>
            @php($total_servicios = 0)
            @foreach ($venta->detalle_servicios as  $detalleServicio)
            

            <tr style="border-bottom: 1px solid #ccc;">
                <td align="left" class="text">{{$detalleServicio->servicio->nombre;}}</td>
                <td align="right" class="text">{{$detalleServicio->cantidad;}}</td>
                <td align="right" class="text">{{moneda($detalleServicio->total_detalle)}}</td>
            </tr>

            @php($total_servicios = $total_servicios + $detalleServicio->total_detalle)

            @endforeach
           
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td colspan="1" align="right"class="total">Total Productos</td>
                <td class="total num" style="padding:0"> {{moneda($total_servicios)}}</td>
            </tr>
        </tfoot>
    </table> --}}



</body>
</html>