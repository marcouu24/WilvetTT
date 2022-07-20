@extends("layouts.master")
@section("contenido")
    <!-- Agregar formulario -->

    <div class="row">

        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-5">
            <a href="{{route('ajustes.crear')}}" class="btn btn-danger float-left text-white"><i class="fas fa-plus text- float-left right"></i>Realizar Ajuste</a>
          </div>


    </div>
    

    
    <div class="card mt-3 ">
        <div class="card-body">
            <table id="table_id" class="yajra-datatable js-tabla-datos display row-border nowrap stripe hover " style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Producto</th>
                        <th>Fecha</th>
                        <th>Motivo</th>
                        <th>Nuevo Stock</th>
                        <th>Usuario</th>
                       

                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>

        </div>
    </div> 
@endsection
@section("javascript")



<script>
    $(function () {   
        var table = $('.yajra-datatable').DataTable({
            scrollY:        "700px",
            order: [[0, 'desc']],
            scrollX:        true,
            scrollCollapse: true,
            processing: true,
            serverSide: true,
            
            ajax: "{{ route('ajustes.listar') }}",
            columns: [
            {data: 'id', name: 'id',className: 'dt-right'},
            {data: 'producto', name: 'producto',className: 'dt-left', width: "20%"},      
            {data: 'fecha', name: 'fecha' ,className: 'dt-right',width: "10%"},    
            {data: 'motivo', name: 'motivo',className: 'dt-right'},   
            {data: 'stock', name: 'stock',className: 'dt-right',width: "5%"},     
            {data: 'usuario', name: 'usuario',className: 'dt-right',width: "10%"}, 
           
            
            
            ]
        });  
    });


</script>



<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedcolumns/4.0.2/css/fixedColumns.dataTables.css"/>
 
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/fixedcolumns/4.0.2/js/dataTables.fixedColumns.js"></script>






@endsection