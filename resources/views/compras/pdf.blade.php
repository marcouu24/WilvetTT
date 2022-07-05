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
    <title>Venta N° {{$compra->id}}</title>
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
        <h3>COMPRA N° {{$compra->id}}</h3>
        
    </div>

    <div class="secundario">
      
       
        <h3>Usuario: {{$compra->usuario->name}}</h3>
        <h3>Proveedor: {{$compra->proveedor->nombre}}</h3>
    </div>

    <div class="secundario1">
        {{-- <h3>VENTA N° {{$venta->id}}</h3> --}}
        <h3>Fecha Compra: {{fecha($compra->fecha_compra)}}</h3>
        <h3>Total Compra: {{moneda($compra->total_compra)}}</h3>
        
    </div>


    
    
    
    
    
    <table class="table" >
        <thead>
            <tr>
                
                <th align="left"width="">Producto</th>
                <th align="right" width="">Cantidad</th>
                <th align="right" width="">Total Detalle</th>
                <th align="right" width="">Precio Unitario</th>
            </tr>

        </thead>
        <tbody>
           
            @foreach ($compra->detalle_compras as  $detalleCompra)
            

            <tr style="border-bottom: 1px solid #ccc;">
                <td  align="left" >{{$detalleCompra->producto->nombre}}</td>
                <td  align="right" >{{$detalleCompra->cantidad}}</td>
                <td align="right">{{moneda($detalleCompra->total_detalle)}}</td>
                <td align="right">{{moneda($detalleCompra->precio_unitario)}}</td>
                
            </tr>

           
             
            
             @endforeach
           
        </tbody>
        <tfoot>
            <tr>            
                
            </tr>
        </tfoot>
    </table>




     

</body>
</html>