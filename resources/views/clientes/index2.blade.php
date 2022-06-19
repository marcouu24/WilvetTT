
@extends('layouts.layout')


@section('page-title','Clientes')

@section('call-to-action')
@role('administrador')
    <a href="" class="btn btn-danger text-white"><i class="fas fa-plus"></i> Agregar Cliente</a>
@endrole
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item active">Clientes</li>
</ol>
@endsection

@section('content')
<div class="card mt-5">
    <div class="card-body">
        <table class="table table-bordered yajra-datatable js-tabla-datos">
            <thead>
                <tr>
                    <th>IDD</th>
                    <th>Nombre</th>
                    <th>Primer Apellido</th>
                    <th>Segundo Apellido</th>
                    <th>RUT</th>
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

@push('javascript')

<script>
    $(function () {   
        var table = $('.yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "",
            columns: [
            {data: 'id', name: 'id', className: 'dt-right'},
            {data: 'nombre', name: 'name'},      
            {data: 'primer_apellido', name: 'primer_apellido'},    
            {data: 'segundo_apellido', name: 'segundo_apellido'}, 
            {data: 'rut', name: 'rut', className: 'dt-right'},    
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



@endpush



