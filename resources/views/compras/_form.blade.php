@extends("layouts.master")
@section("contenido")

<style>
    .table {table-layout: fixed;}
    .thotros {width: 202px;overflow: hidden;}
    .primerth {width: 40px;overflow: hidden;}
</style>

@php
                                function moneda($number, $prefix = '$ ', $decimals = 0)
                                {
                                    return $prefix.number_format($number, $decimals, ',', ',');
                                }
                    @endphp 

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
            <form action="{{route('compras.guardar')}}" method="POST" enctype="multipart/form-data" id="form">
                @csrf

                <div class="row">

                   @if ( @isset($compra->id)  )
                   <div class="mb-3">
                    <h1>EDITAR COMPRA</h1>
                   </div>                     
                   @else
                   <div class="mb-3">
                    <h1>REGISTRAR COMPRA</h1>
                   </div>
                  
                   @endif
                     

                    
                    


                    <div class="card shadow mb-3">
                        <div class="card-header">
                            <h4>Datos Compra</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label for="proveedor_id">Proveedor</label>                    
                                        <select class="js-select-2 select2-select" required style="width: 100%" name="compra[id_proveedor]" id="compra_id_proveedor_select">
                                            <option value="">--SELECCIONAR--</option>
                                            @foreach ($proveedores as $proveedor)                               
                                            <option @if(old('compra_id_proveedor'  ,$compra->id_proveedor)==$proveedor->id) selected @endif value="{{ $proveedor['id'] }}">{{ $proveedor['nombre'] }}</option>              
                                            @endforeach
                                        </select>   
                                    </div>   
                                </div>
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label for="servicios_facturacion">Fecha Compra</label>
                                        <div class="row">
                                            <div class="col-12">
                                                <input type="date" required class="form-control " value="{{$compra->fecha_compra}}"  id="compra_fecha_compra" name="compra[fecha_compra]">
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label for="servicios_facturacion">Total Compra</label>
                                        <div class="row">
                                            <div class="col-12">
                                                <input readonly type="text" name="compra[total_compra]" id="compra_total_compra"  value="{{moneda($compra->total_compra)}}"  class="form-control total_compra text-center " >
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label for="id">ID</label>
                                        <input class="form-control" type="text" id="id_servicio" value="{{$compra->id}}" readonly>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden"  name="id_compra" value="{{$compra->id}}">   
                            <input type="hidden"  name="id_usuario" value="{{Auth::user()->id}}">                                                   
                        </div>
                    </div>
                

                
                    
                    
                    <div class="card shadow mb-3">
                        <div class="card-header">
                            <h4>Productos</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive columna">
                                <table class="table tabla_productos columna  table-bordered table-hover table-responsive " >
                                    <thead>
                                        <tr>
                                            <th class="primerth"><input id="check_all" class="formcontrol" type="checkbox"></th>	
                                            <th class="thotros"> Producto</th>			
                                            <th class="thotros">Cantidad</th>
                                            
                                            <th class="thotros">Precio Unitario</th>     
                                            <th class="thotros">Total Detalle</th>                   			
                                        </tr>
                                    </thead>
                                    <tbody>
                                          @foreach($compra->detalle_compras as $detalle_compra)
                                         
                                    <tr>
                                        <td><input class="case" type="checkbox"></td>

                                        <td>
                                             <select class="select2-select" style="width: 100%" name="productos_compra[{{$detalle_compra->id}}][id_producto]" id="productos_compra_id_producto{{$detalle_compra->id}}"> 
                                                 @foreach ($productos as $producto)  
                                                 <option @if(old('id_producto',$detalle_compra->id_producto)==$producto->id) selected @endif value="{{ $producto['id'] }}">{{ $producto['nombre'] }}</option> 
                                                 @endforeach 
                                            </select> 
                                        </td>

                                        <td><input type="number" required min="1" data-id-numero="{{$detalle_compra->id}}" name="productos_compra[{{$detalle_compra->id}}][cantidad]" id="productos_compra_cantidad{{$detalle_compra->id}}" value="{{$detalle_compra->cantidad}}" class="form-control cantidad  text-end" ></td>
                                        
                                        <td><input type="number"required min="1"  data-id-numero="{{$detalle_compra->id}}" name="productos_compra[{{$detalle_compra->id}}][precio_unitario]" id="productos_compra_precio_unitario{{$detalle_compra->id}}" value="{{$detalle_compra->precio_unitario}}" class="form-control precio_unitario  text-end" ></td>                                                                      
                                        <td><input type="text" data-id-numero="{{$detalle_compra->id}}" name="productos_compra[{{$detalle_compra->id}}][total_detalle]" readonly id="productos_compra_total_detalle{{$detalle_compra->id}}" value="{{moneda($detalle_compra->total_detalle)}}" class="form-control total_detalle text-end" ></td>
                                        <input type="hidden"  name="productos_compra[{{$detalle_compra->id}}][id_compra]" value="{{$detalle_compra->id_compra}}">
                                                                      
                                    </tr>
                                    @endforeach 
                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <td class="text-start" colspan="5">
                                                <button class="btn btn-sm btn-success agregar_producto" type="button">Añadir Producto</button> 
                                                <button class="btn btn-sm btn-danger eliminar_producto" type="button">Eliminar Selección</button>
                                            </td>
                                            
                                        </tr>
                                    </tfoot>
                            </table>
                        </div>
                    </div>



                
                
                    {{-- <div class="card shadow mb-3">
                        <div class="card-header">
                            <h4>Productos</h4>
                        </div>
                        <div class="card-body">
                            <table class="tabla_productos table table-bordered table-hover  table-responsive">
                                <thead>
                                    <tr >
                                        <th class="primerth"><input id="check_all" class="formcontrol" type="checkbox"></th>	
                                        <th class="thotros"> Producto</th>			
                                        <th class="thotros">Cantidad</th>
                                        <th class="thotros">Total Detalle</th>
                                        <th class="thotros">Precio Unitario</th>                        			
                                    </tr>
                                </thead>
                                <tbody> --}}
                                {{--  @foreach($servicio->costosServicio as $costoServicio)
                                    <tr>
                                        <td><input class="case" type="checkbox"></td>
                                        <td> 
                                            <select  class="select select-producto" style="width: 100%" name="prestaciones_servicios_costo[{{$costoServicio->id}}][costo_id]" id="prestaciones_servicios_costo_id{{$costoServicio->id}}">
                                                @foreach ($costos as $costo)                               
                                                <option @if(old('costo_id',$costoServicio->costo_id)==$costo->id) selected @endif value="{{ $costo['id'] }}">{{ $costo['nombre'] }}</option>
                                                @endforeach
                                            </select>  
                                        </td>
                                        
                                        <td> 
                                            <select class="select2-select" style="width: 100%" name="prestaciones_servicios_costo[{{$costoServicio->id}}][proveedor_id]" id="prestaciones_servicios_proveedor_id{{$costoServicio->id}}">
                                                @foreach ($proveedores as $proveedor)                               
                                                <option @if(old('proveedor_id',$costoServicio->proveedor_id)==$proveedor->id) selected @endif value="{{ $proveedor['id'] }}">{{ $proveedor['nombre'] }}</option>
                                                @endforeach
                                            </select>  
                                        </td>
                                        
                                        <td><input type="text" name="prestaciones_servicios_costo[{{$costoServicio->id}}][identificador]" id="prestaciones_servicios_costo_identificador{{$costoServicio->id}}" value="{{$costoServicio->identificador_empresa}}" class="form-control" ></td>
                                        <td><input type="number" name="prestaciones_servicios_costo[{{$costoServicio->id}}][precio]" id="prestaciones_servicios_costo_precio{{$costoServicio->id}}" value="{{$costoServicio->precio}}" class="form-control  total_precio_costo text-end" ></td>
                                        <td><input type="number" name="prestaciones_servicios_costo[{{$costoServicio->id}}][costo]" id="prestaciones_servicios_costo_costo{{$costoServicio->id}}" value="{{$costoServicio->costo}}" class="form-control total_costo_costo text-end" ></td>
                                        <input type="hidden"  name="prestaciones_servicios_costo[{{$costoServicio->id}}][prefactura_id]" value="{{$costoServicio->prefactura_id}}">
                                        
                                    </tr>
                                    @endforeach --}}
                               {{--  </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-start" colspan="5">
                                            <button class="btn btn-sm btn-success agregar_producto" type="button">Añadir Producto</button> 
                                            <button class="btn btn-sm btn-danger eliminar_producto" type="button">Eliminar Selección</button>
                                        </td>
                                        
                                    </tr>
                                </tfoot>
                            </table>
                        </div>--}}
                    </div> 
                    

                    <div class="acciones text-end">
                        <a class="btn btn-dark float-start" href="{{url()->previous()}}" name="aceptarBtn">Volver</a>

                        @if($compra->exists)
                        <button class="btn btn-danger" id="btn-eliminar" data-compra_id="{{$compra->id}}">Eliminar</button>
                        @endif
                        <button class="btn btn-primary" type="submit" name="aceptarBtn">Guardar{{$compra->guardar}}</button>
                    </div>
                    
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

function formato_moneda($numero){
        var formatter = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'CLP',
        });
        $numero = formatter.format($numero);
        $numero = $numero.replace("CLP", "$");
        return $numero;
    }

    function calcularTotalVenta(){

        var precio_total_venta=0;
        $('.total_detalle').each(function(){
            var total= parseInt(this.value.replace('$', '').replace(',', '').replace(',', '').replace('.', '').trim());    
            if (isNaN(total)) {
                total=0;
            } 

            precio_total_venta += total;        
        });

        $('#compra_total_compra').val(formato_moneda(precio_total_venta));   
    };

document.addEventListener('DOMContentLoaded', function(){ 

    $('#form').on('submit', function() {
        $('.total_detalle').each(function(){
                var total_detalle= parseInt(this.value.replace('$', '').replace(',', '').replace(',', '').trim());    
                
                    this.value= parseInt(total_detalle) ;         
            });

            $('.total_compra').each(function(){
                var total_compra= parseInt(this.value.replace('$', '').replace(',', '').trim());    
                
                    this.value= parseInt(total_compra) ;         
            });

    });



    $('.cantidad').on('change',function(e){

var cantidad=this.value;
var idNumero= $(this).attr("data-id-numero") 

if($('#productos_compra_precio_unitario'+idNumero).val()!=''){

    var precioUnitario=$('#productos_compra_precio_unitario'+idNumero).val();
    var totalDetalle= precioUnitario * cantidad;

    $('#productos_compra_total_detalle'+idNumero).val(formato_moneda(totalDetalle));
    calcularTotalVenta();

}
})



$('.precio_unitario').on('change',function(e){

console.log('cambio');
var precioUnitario=this.value;
var idNumero= $(this).attr("data-id-numero") 

if($('#productos_compra_cantidad'+idNumero).val()!=''){

    var cantidad=$('#productos_compra_cantidad'+idNumero).val();
    var totalDetalle= precioUnitario * cantidad;

    console.log('CANTODAD: ' + cantidad);
                        console.log('UNITARIO: ' + precioUnitario);
                        console.log('TOTAL DETALLE: ' +totalDetalle);

    $('#productos_compra_total_detalle'+idNumero).val(formato_moneda(totalDetalle));
    calcularTotalVenta();

}
})


    $('.select2-select').select2();





});



//AGREGAR ROW TABLA COSTO
$(".agregar_producto").on('click',function(){
            var i=new Date().getTime();
            html = '<tr>';
                html += '<td><input class="case" type="checkbox"/></td>';
                
                
                html += '<td> <select required class="js-select-2" style="width: 100%" name="productos_compra['+i+'][id_producto]" id="productos_compra_id_producto'+i+'"> <option value=""></option> @foreach ($productos as $producto)  <option @if(old('id_producto',$producto->id_producto)==$producto->id) selected @endif value="{{ $producto['id'] }}">{{ $producto['nombre'] }}</option> @endforeach </select> </td>';
                html += '<td><input type="number" required min="1" name="productos_compra['+i+'][cantidad]" id="productos_compra_cantidad'+i+'" data-id-numero="'+i+'" class="form-control cantidad text-end"></td>';
                html += '<td><input type="number" required min="1" name="productos_compra['+i+'][precio_unitario]" id="productos_compra_precio_unitario'+i+'" data-id-numero="'+i+'" class="form-control precio_unitario text-end"></td>';
                html += '<td><input type="text" name="productos_compra['+i+'][total_detalle]" id="productos_compra_total_detalle'+i+'" data-id-numero="'+i+'" readonly class="form-control total_detalle text-end"></td>';
                
                html += ' <input type="hidden"  name="productos_compra['+i+'][id_compra]" value="">';


                html += '</tr>';
                $('.tabla_productos').append(html);
                
                $('#productos_compra_id_producto'+i).select2();


                $('#productos_compra_cantidad'+i).on('change',function(e){

                    var cantidad=this.value;
                    var idNumero= $(this).attr("data-id-numero") 

                    if($('#productos_compra_precio_unitario'+idNumero).val()!=''){
                        var totalDetalle=0;
                        var precioUnitario=$('#productos_compra_precio_unitario'+idNumero).val();
                        totalDetalle= precioUnitario * cantidad;

                        $('#productos_compra_total_detalle'+idNumero).val(formato_moneda(totalDetalle));
                        calcularTotalVenta();

                    }
                    })



                    $('#productos_compra_precio_unitario'+i).on('change',function(e){

                    console.log('cambio');

                    var totalDetalle=0;
                    var precioUnitario=this.value;
                    var idNumero= $(this).attr("data-id-numero") 

                    if($('#productos_compra_cantidad'+idNumero).val()!=''){
                       
                        var cantidad=$('#productos_compra_cantidad'+idNumero).val();
                        totalDetalle= precioUnitario * cantidad;

                        console.log('CANTODAD: ' + cantidad);
                        console.log('UNITARIO: ' + precioUnitario);

                        $('#productos_compra_total_detalle'+idNumero).val(formato_moneda(totalDetalle));
                        calcularTotalVenta();

                    }
                    })




            });
            
            //ELIMINAR ROW TABLA COSTO
            $(".eliminar_producto").on('click', function() {
                $('.case:checkbox:checked').parents("tr").remove();
                $('#check_all').prop("checked", false); 
                calcularTotalVenta();
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