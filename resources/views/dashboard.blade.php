
<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="row">
                    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                    <div class="card-header p-3 pt-2">
                    <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">weekend</i>
                    </div>
                    <div class="text-end pt-1">
                    <p class="text-sm mb-0 text-capitalize">Today's Money</p>
                    <h4 class="mb-0">$53k</h4>
                    </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-3">
                    <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+55% </span>than lask week</p>
                    </div>
                    </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                    <div class="card-header p-3 pt-2">
                    <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">person</i>
                    </div>
                    <div class="text-end pt-1">
                    <p class="text-sm mb-0 text-capitalize">Today's Users</p>
                    <h4 class="mb-0">2,300</h4>
                    </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-3">
                    <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+3% </span>than lask month</p>
                    </div>
                    </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                    <div class="card-header p-3 pt-2">
                    <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">person</i>
                    </div>
                    <div class="text-end pt-1">
                    <p class="text-sm mb-0 text-capitalize">New Clients</p>
                    <h4 class="mb-0">3,462</h4>
                    </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-3">
                    <p class="mb-0"><span class="text-danger text-sm font-weight-bolder">-2%</span> than yesterday</p>
                    </div>
                    </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                    <div class="card">
                    <div class="card-header p-3 pt-2">
                    <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">weekend</i>
                    </div>
                    <div class="text-end pt-1">
                    <p class="text-sm mb-0 text-capitalize">Sales</p>
                    <h4 class="mb-0">$103,430</h4>
                    </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-3">
                    <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+5% </span>than yesterday</p>
                    </div>
                    </div>
                    </div>
                    </div>
            </div>
        </div>
    </div>


    <script>
        var datos = [];
var nombres = [];
@foreach ($DetallesVentas as $detalleVenta)
    datos.push({{$detalleVenta->cantidad}});
    nombres.push("{{$detalleVenta->nombre}}");
@endforeach
const ctx2 = document.getElementById('myChart2').getContext('2d');
crearGraficoCircular(ctx2, datos, nombres);



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
</x-app-layout>
