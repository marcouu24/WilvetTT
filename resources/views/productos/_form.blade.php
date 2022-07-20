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
            <form action="{{route('productos.guardar')}}" method="POST" enctype="multipart/form-data" id="form">
                @csrf

                <div class="row">
                   @if ( @isset($producto->id)  )
                   <h1>EDITAR PRODUCTO</h1>                               
                   @else
                   <h1>AGREGAR PRODUCTO</h1>
                   @endif
                     

                    
                    <hr class="mb-2 w-100">



                    <div class="row">
                        <div class="mb-md-3 mb-2 mt-3 ">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input required maxlength="30" type="text" name="producto[nombre]" id="producto_nombre" placeholder="" value="{{old('producto.nombre',$producto->nombre)}}"
                            class="form-control @error('nombre') is-invalid @enderror" >
                            @error('nombre')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>       
                        
                        <div class="mb-md-3 mb-2 mt-3 ">
                            <label for="precio_venta" class="form-label">Precio Venta</label>
                            <input required max="99999999999"  type="number" name="producto[precio_venta]" id="producto_precio_venta" value="{{old('producto.precio_venta',$producto->precio_venta)}}"
                            class="form-control @error('precio') is-invalid @enderror" >
                            @error('precio')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div> 


                        
                    </div> 

                    
                </div>

                <div class="row">
                    <div class="mb-md-3 mb-2 mt-3 ">
                        <label for="producto[stock]" class="form-label">Stock</label>
                        <input max="99999" required type="number" name="producto[stock]" id="producto_stock" value="{{old('producto.stock',$producto->stock)}}"
                        class="form-control @error('stock') is-invalid @enderror" required>
                        @error('stock')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div> 
                </div> 
                
                <div class="row">
                    <div class="mb-md-3 mb-2 mt-3 ">
                        <label for="categoria_id">Categoría</label>
                        <select class="select" style="width: 100%" name="producto[id_categoria]" required id="producto_id_categoria">
                            <option value="">--SELECCIONAR--</option>
                            @foreach ($categorias as $categoria)                            
                            <option @if(old('producto.id_categoria',$producto->id_categoria)==$categoria->id) selected @endif value="{{ $categoria['id'] }}">{{ $categoria['nombre'] }}</option>
                            @endforeach
                        </select>    
                    </div> 
                </div> 



                <hr class="mb-3 mt-3 w-100">

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 mx-auto mr-auto">
                        <input type="hidden" name="id" value="{{$producto->id ?? ''}}">
                        <a class="btn btn-dark" href="{{url()->previous()}}" name="aceptarBtn">Volver</a>
                        <button class="btn btn-primary float-right" type="submit" name="aceptarBtn" style="float: right">Guardar</button>
                        @isset($producto->id)
                            <button type="submit" class="btn btn-danger" style='float: right; margin-right: 1%' id="btn-eliminar" data-producto_id="{{$producto->id}}">Eliminar</button>
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

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>

$('#producto_id_categoria').select2();


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
                $('#form').attr('action', "{{route('productos.eliminar', '')}}"+"/"+$(this).data('producto_id'));
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