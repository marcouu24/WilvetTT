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
            <form action="{{route('ventas.guardar')}}" method="POST" enctype="multipart/form-data" id="form">
                @csrf

                <div class="row">

                   @if ( @isset($venta->id)  )
                   <div class="mb-3">
                    <h1>EDITAR VENTA</h1>
                   </div>                     
                   @else
                   <div class="mb-3">
                    <h1>REGISTRAR VENTA</h1>
                   </div>
                  
                   @endif
                     

                    @php
                                function moneda($number, $prefix = '$ ', $decimals = 0)
                                {
                                    return $prefix.number_format($number, $decimals, ',', '.');
                                }
                    @endphp 
                    


                    <div class="card shadow mb-3">
                        <div class="card-header">
                            <h4>Datos Compra</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        {{-- <label for="proveedor_id">RUT Cliente</label>                    
                                        <input class="form-control " name="venta[rut_cliente]" id="venta_rut_cliente" value="{{$venta->rut_cliente}}" type="text"> --}}
                                        <label for="categoria_id">RUT Cliente</label>
                                        <select class="select" style="width: 100%" name="venta[rut_cliente]" id="venta_rut_cliente">
                                            <option value="">SIN ASIGNAR</option>
                                            @foreach ($clientes as $cliente)                            
                                            <option @if(old('venta.rut_cliente',$venta->rut_cliente)==$cliente->rut) selected @endif value="{{ $cliente['rut'] }}">{{ $cliente['rut'] }}</option>
                                            @endforeach
                                        </select>    
                                   
                                    </div>   
                                </div>
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label for="servicios_facturacion">Fecha Venta</label>
                                        <div class="row">
                                            <div class="col-12">
                                                <input type="date" required class="form-control " value="{{$venta->fecha_venta}}"  id="venta_fecha_venta" name="venta[fecha_venta]">
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label for="servicios_facturacion">Total Venta</label>
                                        <div class="row">
                                            <div class="col-12">
                                                <input readonly type="text" name="venta[total_venta]" id="venta_total_venta"  value="{{moneda($venta->total_venta)}}"  class="form-control text-center " >
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label for="id">ID</label>
                                        <input class="form-control" type="text" id="id_servicio" value="{{$venta->id}}" readonly>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden"  name="id_venta" value="{{$venta->id}}">   
                            <input type="hidden"  name="venta[id_usuario]" value="{{Auth::user()->id}}">                                                   
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
                                            <th class="thotros">Total Detalle</th>                       			
                                        </tr>
                                    </thead>
                                    <tbody>
                                          @foreach($venta->detalle_ventas as $detalle_venta)
                                         
                                    <tr>
                                        <td><input class="case" type="checkbox"></td>

                                        <td>
                                             <select class="productos_select2 productos-select" data-id-detalle-venta={{$detalle_venta->id}} style="width: 100%" name="productos_venta[{{$detalle_venta->id}}][id_producto]" id="productos_venta_id_producto{{$detalle_venta->id}}"> 
                                                 @foreach ($productos as $producto)  
                                                 <option @if(old('id_producto',$detalle_venta->id_producto)==$producto->id) selected @endif data-producto-precio="{{ $producto['precio_venta'] }}" value="{{ $producto['id'] }}">{{ $producto['nombre'] }}</option> 
                                                 @endforeach 
                                            </select> 
                                        </td>

                                        <td><input type="number" data-id-detalle-venta={{$detalle_venta->id}} data-id-producto={{$detalle_venta->id_producto}} name="productos_venta[{{$detalle_venta->id}}][cantidad]" id="productos_venta_cantidad{{$detalle_venta->id}}" value="{{$detalle_venta->cantidad}}" class="cantidad-productos form-control  text-end" ></td>
                                        <td><input type="text" name="productos_venta[{{$detalle_venta->id}}][total_detalle]" id="productos_venta_total_detalle{{$detalle_venta->id}}" value="{{$detalle_venta->total_detalle}}" class="form-control  text-end" ></td>
                                        <input type="hidden"  name="productos_venta[{{$detalle_venta->id}}][id_venta]" value="{{$detalle_venta->id_venta}}">
                                                                      
                                    </tr>
                                    @endforeach  
                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <td class="text-start" colspan="4">
                                                <button class="btn btn-sm btn-success agregar_producto" type="button">Añadir Producto</button> 
                                                <button class="btn btn-sm btn-danger eliminar_producto" type="button">Eliminar Selección</button>
                                            </td>
                                            
                                        </tr>
                                    </tfoot>
                            </table>
                        </div>
                    </div>
                </div>












                    <div class="card shadow mb-3">
                        <div class="card-header">
                            <h4>Servicios</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive columna">
                                <table class="table tabla_servicios columna  table-bordered table-hover table-responsive " >
                                    <thead>
                                        <tr>
                                            <th class="primerth"><input id="check_all" class="formcontrol" type="checkbox"></th>	
                                            <th class="thotros">Servicio</th>			
                                            <th class="thotros">Cantidad</th>
                                            <th class="thotros">Total Detalle</th>                       			
                                        </tr>
                                    </thead>
                                    <tbody>
                                         @foreach($venta->detalle_servicios as $detalle_servicio)
                                         
                                    <tr>
                                        <td><input class="case" type="checkbox"></td>

                                        <td>
                                             <select class="servicios_select2" style="width: 100%" name="servicios_venta[{{$detalle_servicio->id}}][id_servicio]" id="servicios_venta_id_servicio{{$detalle_servicio->id}}"> 
                                                 @foreach ($servicios as $servicio)  
                                                 <option @if(old('id_servicio',$detalle_servicio->id_servicio)==$servicio->id) selected @endif value="{{ $servicio['id'] }}">{{ $servicio['nombre'] }}</option> 
                                                 @endforeach 
                                            </select> 
                                        </td>

                                        <td><input type="number" name="servicios_venta[{{$detalle_servicio->id}}][cantidad]" id="servicios_venta_cantidad{{$detalle_servicio->id}}" value="{{$detalle_servicio->cantidad}}" class="form-control  text-end" ></td>
                                        <td><input type="number" name="servicios_venta[{{$detalle_servicio->id}}][total_detalle]" id="servicios_venta_total_detalle{{$detalle_servicio->id}}" value="{{$detalle_servicio->total_detalle}}" class="form-control  text-end" ></td>
                                       
                                        <input type="hidden"  name="servicios_venta[{{$detalle_servicio->id}}][id_venta]" value="{{$detalle_servicio->id_venta}}">
                                                                      
                                    </tr>
                                    @endforeach 
                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <td class="text-start" colspan="4">
                                                <button class="btn btn-sm btn-success agregar_servicio" type="button">Añadir Servicio</button> 
                                                <button class="btn btn-sm btn-danger eliminar_servicio" type="button">Eliminar Servicio</button>
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

                     
                       


                    



                        @if($venta->exists)
                        <button class="btn btn-danger" id="btn-eliminar" data-venta_id="{{$venta->id}}">Eliminar</button>
                        @endif
                        <button class="btn btn-primary" type="submit" name="aceptarBtn">Guardar{{$venta->guardar}}</button>
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

$('#form').on('submit', function() {
    $('option').prop('disabled', false);

    $('.total_detalle').each(function(){
            var total_detalle= parseInt(this.value.replace('$', '').replace(',', '').trim());    
            
                this.value= parseInt(total_detalle) ;
                
                
           
        });

});

var marcados= [];
var ServiciosMarcados= [];


function activarOpcion(opcion){

var myIndex = marcados.indexOf(opcion);
if (myIndex !== -1) {
marcados.splice(myIndex, 1);
}};



function formato_moneda($numero){
        var formatter = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'CLP',
        });
        $numero = formatter.format($numero);
        $numero = $numero.replace("CLP", "$");
        return $numero;
    }


    function actualizarOpciones(){
        console.log(marcados);

       if(marcados.length>0){   
            for (i = 0; i < marcados.length; i++) {          
                $('.productos_select2').find("[value='"+marcados[i]+"']").prop("disabled",true);
            } 
       }    
   };

   function actualizarOpcionesServicios(){
        console.log(ServiciosMarcados);

       if(ServiciosMarcados.length>0){   
            for (i = 0; i < ServiciosMarcados.length; i++) {          
                $('.servicios_select2').find("[value='"+ServiciosMarcados[i]+"']").prop("disabled",true);
            } 
       }    
   };


   function calcularTotalVenta(){

        var precio_total_venta=0;
        $('.total_detalle').each(function(){
            var total= parseInt(this.value.replace('$', '').replace(',', '').trim());    
            if (isNaN(total)) {
                total=0;
            } 

            precio_total_venta += total;        
        });
        
        $('#venta_total_venta').val(formato_moneda(precio_total_venta));   
    };



document.addEventListener('DOMContentLoaded', function(){ 
    var marcados= [];
    var ServiciosMarcados= [];

    $('.productos_select2').select2();
    $('.servicios_select2').select2();
    $('#venta_rut_cliente').select2();

    $('.cantidad-productos').on('change',function(e){
          
          var cantidad=this.value;
        var idDetalleVenta= $(this).attr("data-id-detalle-venta") 
        console.log('DETALLE VENTA ID: '+ idDetalleVenta);
          console.log('aaaaasdas: '+ cantidad);
          console.log($(this).attr("data-id-producto"));

          let url = "{{route('obtenerStockProducto','')}}" + '/' + $(this).attr("data-id-producto").toString();
          $.getJSON(url, function(data){
              let stock= data;
              
              if(cantidad>stock){
                  Swal.fire({
                      icon: 'error',
                      title: 'NO HAY STOCK SUFICIENTE',
                      text: 'Stock Disponible: ' + stock,
             
                  })

                  $('#productos_venta_cantidad'+idDetalleVenta).val(stock);
                  var total_Detalle= stock * $('#productos_venta_id_producto'+idDetalleVenta).select2().find(":selected").data("producto-precio");
                      $('#productos_venta_total_detalle'+idDetalleVenta).val(formato_moneda(total_Detalle));
                      calcularTotalVenta();
              }

             

          });
          //DEFINIR TOTAL DETALLE
          var total_Detalle= cantidad * $('#productos_venta_id_producto'+idDetalleVenta).select2().find(":selected").data("producto-precio");
          console.log(total_Detalle);
          $('#productos_venta_total_detalle'+idDetalleVenta).val(formato_moneda(total_Detalle));
          calcularTotalVenta();
      }); 
    




      $('.productos-select').on('select2:select', function (e) {
        var idDetalleVenta= $(this).attr("data-id-detalle-venta") 
marcados.push($(this).select2().find(":selected").val())
console.log(marcados);
$(this).select2().find(":selected").attr('selected','selected');
 

// $('#productos_venta_cantidad'+i).attr('data-id-producto' , $('#productos_venta_id_producto'+i).val());   // JQuery
 $('#productos_venta_cantidad'+idDetalleVenta).attr('data-id-producto' , $(this).select2().find(":selected").val());   // JQuery

 //aaaaaa




if(document.getElementById('productos_venta_cantidad'+idDetalleVenta).value!=''){
    var cantidad=document.getElementById('productos_venta_cantidad'+idDetalleVenta).value;
    console.log('DISTINTO DE VACIO')
  
    let url = "{{route('obtenerStockProducto','')}}" + '/' + $('#productos_venta_cantidad'+idDetalleVenta).attr("data-id-producto").toString();
    $.getJSON(url, function(data){
        let stock= data;
        
        if(cantidad>stock){
            Swal.fire({
                icon: 'error',
                title: 'NO HAY STOCK SUFICIENTE',
                text: 'Stock Disponible: ' + stock,
    
            })

            $('#productos_venta_cantidad'+idDetalleVenta).val(stock);

            var total_Detalle= stock * $('#productos_venta_id_producto'+idDetalleVenta).select2().find(":selected").data("producto-precio");
            $('#productos_venta_total_detalle'+idDetalleVenta).val(formato_moneda(total_Detalle));
            calcularTotalVenta();
        }

    });

    var total_Detalle= cantidad * $('#productos_venta_id_producto'+idDetalleVenta).select2().find(":selected").data("producto-precio");
    $('#productos_venta_total_detalle'+idDetalleVenta).val(formato_moneda(total_Detalle));
    calcularTotalVenta();

} 

});



   
});

//AGREGAR ROW TABLA COSTO
            $(".agregar_producto").on('click',function(){
            var i=new Date().getTime();
            html = '<tr>';
                html += '<td><input data-time="'+i+'" id="'+i+'" class="case" type="checkbox"/></td>';                             
                html += '<td> <select class="productos_select2" required style="width: 100%" name="productos_venta['+i+'][id_producto]" id="productos_venta_id_producto'+i+'"> <option value=""></option> @foreach ($productos as $producto)  <option @if(old('id_producto',$producto->id_producto)==$producto->id) selected @endif data-producto-precio="{{ $producto['precio_venta'] }}" value="{{ $producto['id'] }}">{{ $producto['nombre'] }}</option> @endforeach </select> </td>';
                html += '<td><input type="number" name="productos_venta['+i+'][cantidad]" required min=1 value=1 id="productos_venta_cantidad'+i+'" class="form-control text-end cantidad-producto"></td>';
                html += '<td><input type="text" name="productos_venta['+i+'][total_detalle]" readonly id="productos_venta_total_detalle'+i+'" class="form-control total_detalle text-end"></td>';             
                html += ' <input type="hidden"  name="productos_venta['+i+'][id_venta]" value="">';               
                html += '</tr>';
                $('.tabla_productos').append(html);              
                $('#productos_venta_id_producto'+i).select2();


                $('#productos_venta_id_producto'+i).on("select2:selecting", function (e) {
                    
                     var opcion= ($('#productos_venta_id_producto'+i).select2().find(":selected").val());
                     if(opcion!=''){
                        console.log('OPCION ANTERIOR: ' + opcion);
                        var indice = marcados.indexOf(opcion); // obtenemos el indice
                         marcados.splice(indice, 1); 
                     }                 
                }); 

                
                $('#productos_venta_id_producto'+i).on('select2:opening', function (e) {
                    console.log('ABRIR');
                    $('#productos_venta_id_producto'+i).find("option").prop("disabled",false);    
                    actualizarOpciones();
                })  


              /*   $(".total_detalle").on('change',function(){
                    console.log('CAMVIO DE PREVIO AANSDJK');
                }); */

                




                $('#productos_venta_id_producto'+i).on('select2:select', function (e) {

                    marcados.push($('#productos_venta_id_producto'+i).select2().find(":selected").val())
                    console.log(marcados);
                   $('#productos_venta_id_producto'+i).select2().find(":selected").attr('selected','selected');
                     

                    // $('#productos_venta_cantidad'+i).attr('data-id-producto' , $('#productos_venta_id_producto'+i).val());   // JQuery
                     $('#productos_venta_cantidad'+i).attr('data-id-producto' , $('#productos_venta_id_producto'+i).select2().find(":selected").val());   // JQuery

                     //aaaaaa




                    if(document.getElementById('productos_venta_cantidad'+i).value!=''){
                        var cantidad=document.getElementById('productos_venta_cantidad'+i).value;
                        console.log('DISTINTO DE VACIO')
                      
                        let url = "{{route('obtenerStockProducto','')}}" + '/' + $('#productos_venta_cantidad'+i).attr("data-id-producto").toString();
                        $.getJSON(url, function(data){
                            let stock= data;
                            
                            if(cantidad>stock){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'NO HAY STOCK SUFICIENTE',
                                    text: 'Stock Disponible: ' + stock,
                        
                                })

                                $('#productos_venta_cantidad'+i).val(stock);

                                var total_Detalle= stock * $('#productos_venta_id_producto'+i).select2().find(":selected").data("producto-precio");
                                $('#productos_venta_total_detalle'+i).val(formato_moneda(total_Detalle));
                                calcularTotalVenta();
                            }

                        });

                        var total_Detalle= cantidad * $('#productos_venta_id_producto'+i).select2().find(":selected").data("producto-precio");
                        $('#productos_venta_total_detalle'+i).val(formato_moneda(total_Detalle));
                        calcularTotalVenta();

                    } 
   
                });


                



                $('#productos_venta_cantidad'+i).on('change',function(e){
          
                    var cantidad=document.getElementById('productos_venta_cantidad'+i).value;

                    console.log('aaaaasdas: '+ cantidad);
                    console.log($(this).attr("data-id-producto"));

                    let url = "{{route('obtenerStockProducto','')}}" + '/' + $(this).attr("data-id-producto").toString();
                    $.getJSON(url, function(data){
                        let stock= data;
                        
                        if(cantidad>stock){
                            Swal.fire({
                                icon: 'error',
                                title: 'NO HAY STOCK SUFICIENTE',
                                text: 'Stock Disponible: ' + stock,
                       
                            })

                            $('#productos_venta_cantidad'+i).val(stock);
                            var total_Detalle= stock * $('#productos_venta_id_producto'+i).select2().find(":selected").data("producto-precio");
                                $('#productos_venta_total_detalle'+i).val(formato_moneda(total_Detalle));
                                calcularTotalVenta();
                        }

                       

                    });
                    //DEFINIR TOTAL DETALLE
                    var total_Detalle= cantidad * $('#productos_venta_id_producto'+i).select2().find(":selected").data("producto-precio");
                    console.log(total_Detalle);
                    $('#productos_venta_total_detalle'+i).val(formato_moneda(total_Detalle));
                    calcularTotalVenta();
                }); 




            });
            
            //ELIMINAR ROW TABLA COSTO
            $(".eliminar_producto").on('click', function(e) {
              
                let id2=($('.case:checkbox:checked').attr('id'));      
                var idd= $('#productos_venta_id_producto'+id2).select2().find(":selected").val();
             
                $('.case:checkbox:checked').parents("tr").remove();
                $('#check_all').prop("checked", false); 


                var myIndex = marcados.indexOf(idd);

                if (myIndex !== -1) {
                marcados.splice(myIndex, 1);
                }
                calcularTotalVenta();
            });









            //AGREGAR ROW TABLA SERVICIOS
            $(".agregar_servicio").on('click',function(){
            var i=new Date().getTime();
            html = '<tr>';
                

                html += '<td><input data-time="'+i+'" id="'+i+'" class="case" type="checkbox"/></td>';
                
                
                html += '<td> <select class="servicios_select2" style="width: 100%" required name="servicios_venta['+i+'][id_servicio]" id="servicios_venta_id_servicio'+i+'"> <option value=""></option> @foreach ($servicios as $servicio)  <option @if(old('id_servicio',$servicio->id_servicio)==$servicio->id) selected @endif data-servicio-precio="{{ $servicio['valor_servicio'] }}" value="{{ $servicio['id'] }}">{{ $servicio['nombre'] }}</option> @endforeach </select> </td>';
                html += '<td><input type="number" name="servicios_venta['+i+'][cantidad]" required value=1 min=1 id="servicios_venta_cantidad'+i+'" class="form-control text-end"></td>';
                html += '<td><input type="text" readonly name="servicios_venta['+i+'][total_detalle]" id="servicios_venta_total_detalle'+i+'" class="form-control total_detalle  text-end"></td>';
                html += ' <input type="hidden"  name="servicios_venta['+i+'][id_venta]" value="">';
                html += '</tr>';

                $('.tabla_servicios').append(html);             
                $('#servicios_venta_id_servicio'+i).select2();




                //aaaa





                $('#servicios_venta_id_servicio'+i).on("select2:selecting", function (e) {
                    
                    var opcion= ($('#servicios_venta_id_servicio'+i).select2().find(":selected").val());
                    if(opcion!=''){
                       console.log('OPCION ANTERIOR: ' + opcion);
                       var indice = ServiciosMarcados.indexOf(opcion); // obtenemos el indice
                        ServiciosMarcados.splice(indice, 1); 
                    }                 
               }); 

               
               $('#servicios_venta_id_servicio'+i).on('select2:opening', function (e) {
                   console.log('ABRIR');
                   $('#servicios_venta_id_servicio'+i).find("option").prop("disabled",false);    
                   actualizarOpcionesServicios(); //CAMBIAR
               })  



               $('#servicios_venta_id_servicio'+i).on('select2:select', function (e) {

                   ServiciosMarcados.push($('#servicios_venta_id_servicio'+i).select2().find(":selected").val())
                   console.log(ServiciosMarcados);
                  $('#servicios_venta_id_servicio'+i).select2().find(":selected").attr('selected','selected');
                    

                   // $('#productos_venta_cantidad'+i).attr('data-id-producto' , $('#productos_venta_id_producto'+i).val());   // JQuery
                    $('#servicios_venta_cantidad'+i).attr('data-id-servicio' , $('#servicios_venta_id_servicio'+i).select2().find(":selected").val());   // JQuery

                    //aaaaaa




                   if(document.getElementById('servicios_venta_cantidad'+i).value!=''){
                       var cantidadServicio=document.getElementById('servicios_venta_cantidad'+i).value;
                       console.log('DISTINTO DE VACIO')
                     

                       var total_DetalleServicio= cantidadServicio * $('#servicios_venta_id_servicio'+i).select2().find(":selected").data("servicio-precio");
                       $('#servicios_venta_total_detalle'+i).val(formato_moneda(total_DetalleServicio));
                       calcularTotalVenta();

                   } 
  
               });


               



               $('#servicios_venta_cantidad'+i).on('change',function(e){
                console.log('CAMBIO');
         
                   var cantidadServicio=document.getElementById('servicios_venta_cantidad'+i).value;

                   
                   console.log('PRECIO: ' + $('#servicios_venta_id_servicio'+i).select2().find(":selected").data("servicio-precio"));
                console.log('CANTIDAD:' +cantidadServicio)
                   //DEFINIR TOTAL DETALLE
                   var total_DetalleServicio= cantidadServicio * $('#servicios_venta_id_servicio'+i).select2().find(":selected").data("servicio-precio");
                   
                   $('#servicios_venta_total_detalle'+i).val(formato_moneda(total_DetalleServicio));
                   calcularTotalVenta();
                   console.log(total_DetalleServicio);
               }); 




            });
            
            //ELIMINAR ROW TABLA SERVICIOS
            $(".eliminar_servicio").on('click', function() {

                let id2=($('.case:checkbox:checked').attr('id'));      
                var idd= $('#servicios_venta_id_servicio'+id2).select2().find(":selected").val();
             
                $('.case:checkbox:checked').parents("tr").remove();
                $('#check_all').prop("checked", false); 


                var myIndex = ServiciosMarcados.indexOf(idd);

                if (myIndex !== -1) {
                ServiciosMarcados.splice(myIndex, 1);
                }
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
                $('#form').attr('action', "{{route('compras.eliminar', '')}}"+"/"+$(this).data('venta_id'));
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