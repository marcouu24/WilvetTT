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
            <form action="{{route('clientes.guardar')}}" method="POST" enctype="multipart/form-data" id="form">
                @csrf

                <div class="row">
                   
                    <hr class="mb-2 w-100">



                    <div class="row">
                        <div class="mb-md-3 mb-2 mt-3 ">
                            <label for="cliente[rut]" class="form-label">RUT</label>
                            <input maxlength="10" type="text" name="cliente[rut]" id="cliente_rut" value="{{old('cliente.rut',$cliente->rut)}}"
                            class="form-control @error('rut') is-invalid @enderror" required>
                            @error('rut')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div> 
                    </div> 

                    <div class="mb-md-3 mb-2 mt-3 ">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input maxlength="50" type="text" name="cliente[nombre]" id="cliente_nombre" placeholder="" value="{{old('cliente.nombre',$cliente->nombre)}}"
                        class="form-control @error('nombre') is-invalid @enderror" >
                        @error('nombre')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>           
                </div>

                <div class="row">
                    <div class="mb-md-3 mb-2 mt-3 ">
                        <label for="nombre" class="form-label">Comuna</label>
                        <input maxlength="50" type="text" name="cliente[comuna]" id="cliente_comuna" value="{{old('cliente.comuna',$cliente->comuna)}}"
                        class="form-control @error('comuna') is-invalid @enderror" >
                        @error('comuna')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div> 
                </div> 
                
                <div class="row">
                    <div class="mb-md-3 mb-2 mt-3 ">
                        <label for="nombre" class="form-label">Direccion</label>
                        <input maxlength="50" type="text" name="cliente[direccion]" id="cliente_direccion" value="{{old('cliente.direccion',$cliente->direccion)}}"
                        class="form-control @error('direccion') is-invalid @enderror" >
                        @error('direccion')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div> 
                </div> 



                <div class="row">
                    <div class="mb-md-3 mb-2 mt-3 ">
                        <label for="nombre" class="form-label">Teléfono</label>
                        <input maxlength="9" type="text" name="cliente[telefono]" id="cliente_telefono" value="{{old('cliente.telefono',$cliente->telefono)}}"
                        class="form-control @error('telefono') is-invalid @enderror" >
                        @error('telefono')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div> 
                </div> 

                <div class="row">
                    <div class="mb-md-3 mb-2 mt-3 ">
                        <label for="nombre" class="form-label">Correo Electrónico</label>
                        <input maxlength="50" type="email" name="cliente[email]" id="cliente_email" value="{{old('cliente.email',$cliente->email)}}"
                        class="form-control @error('email') is-invalid @enderror" >
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div> 
                </div> 
                
                <hr class="mb-3 mt-3 w-100">

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 mx-auto mr-auto">
                        <input type="hidden" name="id" value="{{$cliente->rut ?? ''}}">
                        <a class="btn btn-dark" href="{{url()->previous()}}" name="aceptarBtn">Volver</a>
                        <button class="btn btn-primary float-right" type="submit" name="aceptarBtn" style="float: right">Guardar</button>
                        @isset($cliente->rut)
                            <button type="submit" class="btn btn-danger" style='float: right; margin-right: 1%' id="btn-eliminar" data-cliente_id="{{$cliente->rut}}">Eliminar</button>
                        @endisset
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@section("javascript")

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