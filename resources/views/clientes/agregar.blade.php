@extends("layouts.master")
@section("contenido")
    <!-- Agregar formulario -->

    <div class="row">

        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-5">
            <a href="{{route('clientes.crear')}}" class="btn btn-danger float-left text-white"><i class="fas fa-plus text- float-left right"></i> Agregar Cliente</a>
          </div>


    </div>
    

    
    <div class="card mt-2 ">
        <div class="card-body">
            <table id="table_id" class="yajra-datatable js-tabla-datos display row-border nowrap stripe hover " style="width:100%">
                <thead>
                    <tr>
                        <th>RUT</th>
                        <th>Nombre</th>
                        <th>Comuna</th>
                        <th>Dirección</th>
                        <th>Telefono</th>
                        <th>Correo Electrónico</th>
                        <th>Acciones</th>
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
            scrollX:        true,
            scrollCollapse: true,
            processing: true,
            serverSide: true,
            
            ajax: "{{ route('clientes.listar') }}",
            columns: [
            {data: 'rut', name: 'rut'},
            {data: 'nombre', name: 'nombre'},      
            {data: 'comuna', name: 'comuna'},    
            {data: 'direccion', name: 'direccion'}, 
            {data: 'telefono', name: 'telefono', className: 'dt-right'}, 
            {data: 'email', name: 'email'},       
            {
                data: 'action', 
                name: 'action', 
                orderable: false, 
                searchable: false
            },
            ]
        });  
    });

    document.addEventListener('DOMContentLoaded', function () {
        $('.js-tabla-datos').on('submit', '.js-form-eliminar', function(e) {
            e.preventDefault(); 
            Swal.fire({
                title: '¿Desea Eliminar?',
                text: "Esta acción es irreversible",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Eliminar',
                cancelButtonText: 'Cancelar',
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                    else{
                        return false;
                    }
            })
        })
    });
</script>



<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedcolumns/4.0.2/css/fixedColumns.dataTables.css"/>
 
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/fixedcolumns/4.0.2/js/dataTables.fixedColumns.js"></script>




@endsection