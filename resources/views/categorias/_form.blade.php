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
            <form action="{{route('categorias.guardar')}}" method="POST" enctype="multipart/form-data" id="form">
                @csrf

                <div class="row">
                   @if ( @isset($categoria->id)  )
                   <h1>EDITAR CATEGORÍA</h1>                               
                   @else
                   <h1>AGREGAR CATEGORÍA</h1>
                   @endif
                     

                    
                    <hr class="mb-2 w-100">



                    <div class="row">
                        <div class="mb-md-3 mb-2 mt-3 ">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input maxlength="30" required type="text" name="categoria[nombre]" id="categoria_nombre" placeholder="" value="{{old('categoria.nombre',$categoria->nombre)}}"
                            class="form-control @error('nombre') is-invalid @enderror" >
                            @error('nombre')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>       
                        
                        


                        
                    </div> 

                    
                </div>

               



                <hr class="mb-3 mt-3 w-100">

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 mx-auto mr-auto">
                        <input type="hidden" name="id" value="{{$categoria->id ?? ''}}">
                        <a class="btn btn-dark" href="{{url()->previous()}}" name="aceptarBtn">Volver</a>
                        <button class="btn btn-primary float-right" type="submit" name="aceptarBtn" style="float: right">Guardar</button>
                        @isset($categoria->id)
                            <button type="submit" class="btn btn-danger" style='float: right; margin-right: 1%' id="btn-eliminar" data-categoria_id="{{$categoria->id}}">Eliminar</button>
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
                $('#form').attr('action', "{{route('categorias.eliminar', '')}}"+"/"+$(this).data('categoria_id'));
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