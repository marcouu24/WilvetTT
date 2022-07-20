@extends("layouts.master")
@section("contenido")

@php
function moneda($number, $prefix = '$ ', $decimals = 0)
{
return $prefix.number_format($number, $decimals, ',', '.');
}

@endphp

<div class="row">

    <div class="col-sm-6 mt-4">
        <div class="card">

            <div class="card-body p-3 pt-2">
                <h4>PRODUCTOS MÁS VENDIDOS  {{Carbon\Carbon::now()->month."/".Carbon\Carbon::now()->year}}</h4>
                <canvas id="myChart3"></canvas>
            </div>
            <hr class="dark horizontal my-0">

        </div>
    </div>

    <div class="col-sm-6 mt-4">
        <div class="card">

               
            <div class="card-body p-3 pt-2">
                <h4>SERVICIOS MÁS VENDIDOS  {{Carbon\Carbon::now()->month."/".Carbon\Carbon::now()->year}}</h4>
                <canvas id="myChart4"></canvas>
            </div>
            <hr class="dark horizontal my-0">

        </div>
    </div>


</div>

<div class="row">
    
        
        <style>
            canvas{
                max-height: 200px;
                width: auto;
            }
            #tabla_datos td{
               padding: 10px;
            }
            .card{
                box-shadow: 0 0.5rem 0.5rem rgb(0, 0, 0 / 4%);
               
            }
            .btn-graf button{
                border:none;
                background-color: #fff;
                padding: 2px 2px;
                height: 15px;
            }
            .btn-graf{
                display: flex;
                justify-content: center;
            }
            .tabla-graficos{
                border-collapse: collapse;
                padding:0;
            }
            .tabla-graficos tr{
                border-bottom: 1px solid #0A1840;
            }
            .tabla-graficos th,.tabla-graficos td {
                font-size: 0.8em;
            }

            th{
                align= "right" 
            }

            h4{
font-weight: bold;
text-align:center;
}
        </style>        


    <div class="col-sm-3 mt-4 pb-5">
        <div class="card" style="min-height: 261px">
            <div class="card-header p-3 pt-2">
                <div class="div">
                    <h4  style="text-align:center; font-weight: bold">PROD.  STOCK BAJO</h4>
                </div>

            </div>
            <hr class="dark horizontal my-0">
            <div class="card-body p-3">
                <table  class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="50%">Producto</th>
                            <th width="20%">Stock</th>
                          
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($productos as $producto)
                        <tr>
                            <td>
                                {{$producto->nombre}}
                            </td>
                            <td class="text-start " style=" color:rgb(168, 2, 2); font-weight: bold">{{$producto->stock}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <div class="col-sm-3 mt-4 pb-5">


        <div class="card "  style="min-height: 261px">
            <div class="card-header p-3 pt-2">
                <div class="div">
                    <h4 style=" font-weight: bold">TOTAL VENTAS</h4>
                    
                </div>

            </div>
            <hr class="dark horizontal my-0">
            <div class="card-body p-3">
                <p class="text-sm mb-0 text-capitalize" style=" font-weight: bold" >@php 

                    $fecha = "2018-11-25";
                    $date = new DateTime();
                    $result = $date->format('Y-m-d');

                    echo strtoupper('Mes ' . date("M.Y", strtotime($result))) @endphp </p>
                <h2 class="mb-0" style="color: green; font-weight: bold">{{moneda($totalVentas)}}</h2>


                <p class="text-sm mb-0 text-capitalize mt-5" style=" font-weight: bold" >MES ANTERIOR</p>
                <h2 class="mb-0" style="color: green; font-weight: bold">{{moneda($totalVentasMesAnterior)}}</h2>

            </div>
        </div>



       
    </div>




    <div class="col-sm-3 mt-4 pb-5">


        <div class="card "  style="min-height: 261px">
            <div class="card-header p-3 pt-2">
                <div class="div">
                    <h4 >CANTIDAD PRODUCTOS</h4>
                    
                </div>

            </div>
            <hr class="dark horizontal my-0">
            <div class="card-body p-3">
                <table class="tabla-graficos table">
                    <thead>
                        <tr>
                            <th width="50%">Producto</th>
                            <th width="10%">Cantidad</th>
                            <th width="40%">Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($totalCantidad = 0)
                        @php($totalPrecio = 0)
                        @foreach ($productos_mes as $producto)
                        <tr>
                            <td align="left">{{$producto->nombre}}</td>
                            <td align="right">{{$producto->cantidad}}</td>
                            <td align="right">{{moneda($producto->suma_precios)}}</td>
                            @php($totalCantidad += $producto->cantidad)
                             @php($totalPrecio += $producto->suma_precios)
                        </tr>
                        @endforeach
                        <tr style="background: rgb(236, 236, 236)">
                            <td align="left">Total General: </td>
                            <td align="right">{{$totalCantidad}}</td>
                            <td align="right">{{moneda($totalPrecio)}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>



       
    </div>





    <div class="col-sm-3 mt-4 pb-5">


        <div class="card "  style="min-height: 261px">
            <div class="card-header p-3 pt-2">
                <div class="div">
                    <h4 style=" font-weight: bold">CANTIDAD SERVICIOS</h4>
                    
                </div>

            </div>
            <hr class="dark horizontal my-0">
            <div class="card-body p-3">
                <table class="tabla-graficos table">
                    <thead>
                        <tr>
                            <th width="50%">Servicio</th>
                            <th width="10%">Cantidad</th>
                            <th align= "right"  width="40%">Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($totalCantidad = 0)
                        @php($totalPrecio = 0)
                        @foreach ($servicios_mes as $producto)
                        <tr>
                            <td align="left">{{$producto->nombre}}</td>
                            <td align="right">{{$producto->cantidad}}</td>
                            <td align="right">{{moneda($producto->suma_precios)}}</td>
                            @php($totalCantidad += $producto->cantidad)
                             @php($totalPrecio += $producto->suma_precios)
                        </tr>
                        @endforeach
                        <tr style="background: rgb(236, 236, 236)">
                            <td align="left">Total General: </td>
                            <td align="right">{{$totalCantidad}}</td>
                            <td align="right">{{moneda($totalPrecio)}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>



       
    </div>





     


        


</div>



@endsection
@section("javascript")



<script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.0/dist/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0-rc"></script>

<script>
document.addEventListener('DOMContentLoaded', function(){ 

    var datos = [];
    var nombres = [];

    @foreach ($productos_mes as $detalleVenta)
        datos.push({{$detalleVenta->cantidad}});
        nombres.push("{{$detalleVenta->nombre}}");
    @endforeach

    const ctx2 = document.getElementById('myChart3').getContext('2d');
    crearGraficoCircular(ctx2, datos, nombres);



    var datos = [];
    var nombres = [];

    @foreach ($servicios_mes as $detalleServicio)
        datos.push({{$detalleServicio->cantidad}});
        nombres.push("{{$detalleServicio->nombre}}");
    @endforeach

    const ctx3 = document.getElementById('myChart4').getContext('2d');
    crearGraficoCircular(ctx3, datos, nombres);
})



    



function crearGraficoCircular(ctx, datos, nombres){
const myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: nombres,
        datasets: [{
            data: datos,
            backgroundColor: [
                '#0A1840',
                '#A91035',
                '#CD5506',
                '#000033',
                '#7B0007'
            ],
            hoverOffset: 2
        }]
    },
    options:{
        maintainAspectRatio: false,
        plugins: {
            legend:{
                position: 'right'
            },
            tooltip:{
                enabled: false
            },
            datalabels: {
                color: '#FFF',
                formatter: (value, context) =>{
                    const datapoints = context.chart.data.datasets[0].data;
                    function totalSum(total, datapoint){
                        return total + datapoint;
                    }
                    const totalValor = datapoints.reduce(totalSum, 0);
                    const valorPorcentaje = (value /totalValor * 100).toFixed(0);
                    return valorPorcentaje +"%";
                }
            }
        },

    },
    plugins: [ChartDataLabels]
});
}



</script>
