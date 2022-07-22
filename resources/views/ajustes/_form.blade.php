@extends("layouts.master")
@section("contenido")

<style>
    .table {table-layout: fixed;}
    .thotros {width: 202px;overflow: hidden;}
    .primerth {width: 40px;overflow: hidden;}
</style>


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
            <form action="{{route('ajustes.guardar')}}" method="POST" enctype="multipart/form-data" id="form">
                @csrf

                <div class="row">


                   <div class="mb-3">
                    <h1>REALIZAR AJUSTE INVENTARIO</h1>
                   </div>
                                     

                    <div class="card shadow  mb-3">
                        <div class="card-header">
                            <h4>Datos Ajuste</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label for="proveedor_id">Producto</label>      
                                       
                                        <select class="select2-select" required style="width: 100%" name="producto_ajuste[id_producto]" id="producto_ajuste_id_producto"> 
                                            <option value="">--SELECCIONAR--</option>
                                            @foreach ($productos as $producto)  
                                            <option data-stock={{ $producto['stock'] }} value="{{ $producto['id'] }}">{{ $producto['nombre'] }}</option> 
                                            @endforeach 
                                       </select>  
                                    </div>


                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="mb-md-3 mb-2 mt-3 ">
                                                <label for="producto[stock]" class="form-label">Nuevo Stock</label>
                                                <input max="9999" required type="number" name="producto_ajuste[stock]" id="producto_stock" value=""
                                                class="form-control @error('stock') is-invalid @enderror" required>
                                                @error('stock')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div> 
                                        </div> 
                                    </div>
                                </div>

                                




                                <div class=" col-sm-9">
                                    <div class="mb-3">
                                        <label for="nombre">Motivo del ajuste</label>                   
                                        <textarea maxlength="110" rows="10" required name="producto_ajuste[motivo]" id="servicios_observaciones" class="form-control"></textarea>
                                    </div>
                                </div>
                                
                                
                            </div>
                         {{--    <input type="hidden"  name="id_compra" value="{{$compra->id}}">    --}}
                            <input type="hidden"  name="producto_ajuste[id_usuario]" value="{{Auth::user()->id}}">                                                   
                        </div>
                    </div>
                    
                
            
                </div> 
                    

                    <div class="acciones text-end">
                        <a class="btn btn-dark float-start" href="{{url()->previous()}}" name="aceptarBtn">Volver</a>

                       
                        <button class="btn btn-primary" type="submit" name="aceptarBtn">Guardar {{$ajuste->guardar}} </button>
                    </div>
                    
                 

                





                
            </form>
        </div>
    </div>
</div>


@endsection
@section("javascript")

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>




<script>

document.addEventListener('DOMContentLoaded', function(){ 
    $('#producto_ajuste_id_producto').select2();
    var stock=($('#producto_ajuste_id_producto').select2().find(":selected").attr("data-stock"));
        $('#producto_stock').val(stock);

    $('#producto_ajuste_id_producto').on('select2:select', function (e) {
        

        var stock=($('#producto_ajuste_id_producto').select2().find(":selected").attr("data-stock"));
        $('#producto_stock').val(stock);
    })
});

//AGREGAR ROW TABLA COSTO
$(".agregar_producto").on('click',function(){
            var i=new Date().getTime();
            html = '<tr>';
                html += '<td><input class="case" type="checkbox"/></td>';
                
                
                html += '<td> <select class="js-select-2" style="width: 100%" name="productos_compra['+i+'][id_producto]" id="productos_compra_id_producto'+i+'"> <option value=""></option> @foreach ($productos as $producto)  <option @if(old('id_producto',$producto->id_producto)==$producto->id) selected @endif value="{{ $producto['id'] }}">{{ $producto['nombre'] }}</option> @endforeach </select> </td>';
                html += '<td><input type="number" name="productos_compra['+i+'][cantidad]" id="productos_compra_cantidad'+i+'" class="form-control text-end"></td>';
                html += '<td><input type="number" name="productos_compra['+i+'][total_detalle]" id="productos_compra_total_detalle'+i+'" class="form-control  text-end"></td>';
                html += '<td><input type="number" name="productos_compra['+i+'][precio_unitario]" id="productos_compra_precio_unitario'+i+'" class="form-control  text-end"></td>';
                html += ' <input type="hidden"  name="productos_compra['+i+'][id_compra]" value="">';


                html += '</tr>';
                $('.tabla_productos').append(html);
                
                $('#productos_compra_id_producto'+i).select2();

            });
            
            //ELIMINAR ROW TABLA COSTO
            $(".eliminar_producto").on('click', function() {
                $('.case:checkbox:checked').parents("tr").remove();
                $('#check_all').prop("checked", false); 
            });

</script>

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
                $('#form').attr('action', "{{route('compras.eliminar', '')}}"+"/"+$(this).data('compra_id'));
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