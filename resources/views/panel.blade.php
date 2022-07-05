@extends("layouts.master")
@section("contenido")

<div class="row mt-5">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-header p-3 pt-2">
                <div class="div">
                    <h3  style="text-align:center; font-weight: bold">PRODUCTOS STOCK BAJO</h3>
                </div>
                {{-- <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">weekend</i>
                </div>
                <div class="text-end pt-1">
                    <p class="text-sm mb-0 text-capitalize">Today's Money</p>
                    <h4 class="mb-0">$53k</h4>
                </div> --}}
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
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
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-header p-3 pt-2">
                <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                    <h3 style=" font-weight: bold">  @php 

                        $fecha = "2018-11-25";
                        $date = new DateTime();
                        $result = $date->format('Y-m-d');

                        echo strtoupper('Mes ' . date("M.Y", strtotime($result))) @endphp </h3>
                    
                </div>
                <div class="text-end pt-1">
                    <p class="text-sm mb-0 text-capitalize" style=" font-weight: bold" >Total Ventas</p>
                    <h2 class="mb-0" style="color: green; font-weight: bold">$2,300</h2>
                </div>
            </div>
            <hr class="dark horizontal my-0">

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



@endsection
@section("javascript")



<script>
    
</script>



<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedcolumns/4.0.2/css/fixedColumns.dataTables.css"/>

<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/fixedcolumns/4.0.2/js/dataTables.fixedColumns.js"></script>
