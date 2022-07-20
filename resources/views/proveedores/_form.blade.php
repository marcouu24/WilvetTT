@extends("layouts.master")
@section("contenido")
<div class="main-ver-concesion container my-5 mb-5">
    <div class="card shadow-sm p-3 mb-5 bg-white rounde">
        <div class="col">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>
                        <h6>{{ $error }}</h6>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form action="{{route('proveedores.guardar')}}" method="POST" enctype="multipart/form-data" id="form">
                @csrf

                <div class="row">
                   @if ( @isset($proveedor->id)  )
                   <h1>EDITAR PROVEEDOR</h1>                               
                   @else
                   <h1>AGREGAR PROVEEDOR</h1>
                   @endif
                     

                    
                    <hr class="mb-2 w-100">



                    <div class="row">
                        <div class="mb-md-3 mb-2 mt-3 ">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input maxlength="50" required type="text" name="proveedor[nombre]" id="proveedor_nombre" placeholder="" value="{{old('proveedor.nombre',$proveedor->nombre)}}"
                            class="form-control @error('nombre') is-invalid @enderror" >
                            @error('nombre')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>       
                        
                        <div class="mb-md-3 mb-2 mt-3 ">
                            <label for="nombre" class="form-label">Correo</label>
                            <input required maxlength="50" type="email" name="proveedor[correo]" id="proveedor_correo" value="{{old('proveedor.correo',$proveedor->correo)}}"
                            class="form-control @error('comuna') is-invalid @enderror" >
                            @error('comuna')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div> 


                        
                    </div> 

                    
                </div>

                <div class="row">
                    <div class="mb-md-3 mb-2 mt-3 ">
                        <label for="proveedor[rut]" class="form-label">RUT</label>
                        <input maxlength="10" type="text" name="proveedor[rut]" id="proveedor_rut" value="{{old('proveedor.rut',$proveedor->rut)}}"
                        class="form-control @error('rut') is-invalid @enderror" required>
                        @error('rut')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div> 
                </div> 
                
                <div class="row">
                    <div class="mb-md-3 mb-2 mt-3 ">
                        <label for="nombre" class="form-label">Teléfono</label>
                        <input maxlength="9" required type="text" name="proveedor[telefono]" id="proveedor_telefono" value="{{old('proveedor.telefono',$proveedor->telefono)}}"
                        class="form-control @error('telefono') is-invalid @enderror" >
                        @error('telefono')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div> 
                </div> 



                <hr class="mb-3 mt-3 w-100">

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 mx-auto mr-auto">
                        <input type="hidden" name="id" value="{{$proveedor->id ?? ''}}">
                        <a class="btn btn-dark" href="{{url()->previous()}}" name="aceptarBtn">Volver</a>
                        <button class="btn btn-primary float-right" type="submit" name="aceptarBtn" style="float: right">Guardar</button>
                        @isset($proveedor->id)
                            <button type="submit" class="btn btn-danger" style='float: right; margin-right: 1%' id="btn-eliminar" data-proveedor_id="{{$proveedor->id}}">Eliminar</button>
                        @endisset
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@section("javascript")


@include('sweetalert::alert') 



<script>
    $('#btn-eliminar').on('click', function(e){
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
                $('#form').append('<input type="hidden" name="_method" value="delete">');
                $('#form').attr('action', "{{route('clientes.eliminar', '')}}"+"/"+$(this).data('cliente_id'));
                $('#form').submit();
            }
            else{
                return false;
            }
    });
})
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" integrity="sha512-aOG0c6nPNzGk+5zjwyJaoRUgCdOrfSDhmMID2u4+OIslr0GjpLKo7Xm0Ao3xmpM4T8AmIouRkqwj1nrdVsLKEQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

@endsection