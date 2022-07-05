

<!DOCTYPE html>
<html lang="en">
<head>

    @php
         function moneda($number, $prefix = '$ ', $decimals = 0)
        {
            return $prefix.number_format($number, $decimals, ',', '.');
        }
    @endphp
    <meta charset="UTF-8">
    <style>
        body{
            font-family: sans-serif;
            font-size: 10pt;
        }
        .table{
            border-collapse: collapse;
            width: 100%;
            margin: 40px auto;
            border-style: 5px 2px;
            clear: both;
        }
        .table > *{
            border-bottom: 1px solid #000;
        }
        .table td{
            height: 20pt;
        }
        .table th{
            text-align: left;
        }
        .primario{
            float:left ;
             display: flex;
  align-items: flex-end;
        }
        .secundario{
            float: right;
            margin-right: 120px;
        }



    </style>
    <title>Reporte</title>
</head>
<body>



    <div style="display:inline-block;vertical-align:top;">
        <img  src="https://i.imgur.com/5aHjoFt.jpg"height="80" alt="img"/>
        </div>
        <div style="display:inline-block; ">
            <h1 > LISTADO STOCK PRODUCTOS @php
                $fechaActual = date('d-m-Y'); echo $fechaActual @endphp <h1> 
               
        </div>


       
        
    </div>


    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio Venta</th>
                <th>Stock</th>
                <th>Categoria</th>
            </tr>
        </thead>
        <tbody>
            
            @foreach ($datos as  $dato)
                <tr style="border-bottom: .5px solid #ccc;">
                    <td align="left">{{$dato->id;}}</td>
                    <td align="left">{{$dato->nombre;}}</td>
                    <td align="left">{{moneda($dato->precio_venta)}}</td>
                    <td @if (($dato->stock)<=5)
                        style= "color:#b30101"
                    @endif  align="left">{{$dato->stock;}}</td>
                    <td align="left">{{$dato->categoria->nombre;}}</td>
                   
                   
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="border-top: 1px solid #000;">
              
            </tr>         
        </tfoot>
    </table>
</body>
</html>