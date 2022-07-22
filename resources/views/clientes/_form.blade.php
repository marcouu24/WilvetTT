@extends("layouts.master")

<script src="jquery.rut.js"></script>
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

					@if ( @isset($cliente->rut)  )
					<h1>EDITAR CLIENTE</h1>                               
					@else
					<h1>AGREGAR CLIENTE</h1>
					@endif
                   
                    <hr class="mb-2 w-100">



                    <div class="row">
                        <div class="mb-md-3 mb-2 mt-3 ">
                            <label for="cliente[rut]" class="form-label">RUT</label>
                            
                            <input type="text" id="rut"  name="cliente[rut]" class="form-control" required value="{{old('cliente.rut',$cliente->rut)}}">

{{--                             <input maxlength="10" type="text" name="cliente[rut]" id="cliente_rut" value="{{old('cliente.rut',$cliente->rut)}}"
                            class="form-control @error('rut') is-invalid @enderror" required> --}}

                            <h6 style="color: red;" class="mt-2 mb-0" id="textoerror"></h6>

                        </div> 
                    </div> 

                    <div class="mb-md-3 mb-2 mt-3 ">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input maxlength="30" required type="text" name="cliente[nombre]" id="cliente_nombre" placeholder="" value="{{old('cliente.nombre',$cliente->nombre)}}"
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
                        <input maxlength="30" required type="text" name="cliente[comuna]" id="cliente_comuna" value="{{old('cliente.comuna',$cliente->comuna)}}"
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
                        <input maxlength="70" required type="text" name="cliente[direccion]" id="cliente_direccion" value="{{old('cliente.direccion',$cliente->direccion)}}"
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
                        <input required maxlength="9" type="text" name="cliente[telefono]" id="cliente_telefono" value="{{old('cliente.telefono',$cliente->telefono)}}"
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
                        <input maxlength="50" required type="email" name="cliente[email]" id="cliente_email" value="{{old('cliente.email',$cliente->email)}}"
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
                        <button class="btn btn-primary" id="guardar-btn" float-right" type="submit" name="aceptarBtn" style="float: right">Guardar</button>
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
@include('sweetalert::alert') 
<script src="jquery.rut.js"></script>
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


document.addEventListener('DOMContentLoaded', function(){ 
   /*  var marcados= [];
    var ServiciosMarcados= []; */

$("input#rut").rut({
    useThousandsSeparator : false,
	formatOn: 'keyup',
    minimumLength: 8, // validar largo mínimo; default: 2
	validateOn: 'change',
    
    // si no se quiere validar, pasar null
}



);




$('#rut').on('change',function(e){

    if($.validateRut(this.value)) {
	
    $( '#guardar-btn' ). prop( 'disabled' , false );
    document.getElementById("textoerror").innerHTML = "";
    }else{
        
        $( '#guardar-btn' ). prop( 'disabled' , true );
        document.getElementById("textoerror").innerHTML = "Ingrese RUT valido.";
    }

});

$('#cliente_rut').on('change',function(e){
    console.log('a');

    var Fn = {
	// Valida el rut con su cadena completa "XXXXXXXX-X"
	validaRut : function (rutCompleto) {
		rutCompleto = rutCompleto.replace("‐","-");
		if (!/^[0-9]+[-|‐]{1}[0-9kK]{1}$/.test( rutCompleto ))
			return false;
		var tmp 	= rutCompleto.split('-');
		var digv	= tmp[1]; 
		var rut 	= tmp[0];
		if ( digv == 'K' ) digv = 'k' ;
		
		return (Fn.dv(rut) == digv );
	},
	dv : function(T){
		var M=0,S=1;
		for(;T;T=Math.floor(T/10))
			S=(S+T%10*(9-M++%6))%11;
		return S?S-1:'k';
	}
}


if (Fn.validaRut( $("#cliente_rut").val() )){
		alert("El rut ingresado es válido :D");
	} else {
		alert("El Rut no es válido :'( ");
	}



});
});


;(function($){
	var defaults = {
		validateOn: 'blur',
		formatOn: 'blur',
		ignoreControlKeys: true,
		useThousandsSeparator: true,
		minimumLength: 2
	};

	//private methods
	function clearFormat(value) {
		return value.replace(/[\.\-\_]/g, "");
	}

	function format(value, useThousandsSeparator) {
		var rutAndDv = splitRutAndDv(value);
		var cRut = rutAndDv[0]; var cDv = rutAndDv[1];
		if(!(cRut && cDv)) { return cRut || value; }
		var rutF = "";
		var thousandsSeparator = useThousandsSeparator ? "." : "";
		while(cRut.length > 3) {
			rutF = thousandsSeparator + cRut.substr(cRut.length - 3) + rutF;
			cRut = cRut.substring(0, cRut.length - 3);
		}
		return cRut + rutF + "-" + cDv;
	}

	function isControlKey(e) {
		return e.type && e.type.match(/^key(up|down|press)/) &&
			(
				e.keyCode ===  8 || // del
				e.keyCode === 16 || // shift
				e.keyCode === 17 || // ctrl
				e.keyCode === 18 || // alt
				e.keyCode === 20 || // caps lock
				e.keyCode === 27 || // esc
				e.keyCode === 37 || // arrow
				e.keyCode === 38 || // arrow
				e.keyCode === 39 || // arrow
				e.keyCode === 40 || // arrow
				e.keyCode === 91    // command
			);
	}

	function isValidRut(rut, options) {
		if(typeof(rut) !== 'string') { return false; }
		var cRut = clearFormat(rut);
		// validar por largo mínimo, sin guiones ni puntos:
		// x.xxx.xxx-x
		if ( typeof options.minimumLength === 'boolean' ) {
			if ( options.minimumLength && cRut.length < defaults.minimumLength ) {
				return false;
			}
		} else {
			var minLength = parseInt( options.minimumLength, 10 );
			if ( cRut.length < minLength ) {
				return false;
			}
		}
		var cDv = cRut.charAt(cRut.length - 1).toUpperCase();
		var nRut = parseInt(cRut.substr(0, cRut.length - 1));
		if(isNaN(nRut)){ return false; }
		return computeDv(nRut).toString().toUpperCase() === cDv;
	}

	function computeDv(rut) {
		var suma	= 0;
		var mul		= 2;
		if(typeof(rut) !== 'number') { return; }
		rut = rut.toString();
		for(var i=rut.length -1;i >= 0;i--) {
			suma = suma + rut.charAt(i) * mul;
			mul = ( mul + 1 ) % 8 || 2;
		}
		switch(suma % 11) {
			case 1	: return 'k';
			case 0	: return 0;
			default	: return 11 - (suma % 11);
		}
	}

	function formatInput($input, useThousandsSeparator) {
		$input.val(format($input.val(), useThousandsSeparator));
	}

	function validateInput($input) {
		if(isValidRut($input.val(), $input.opts)) {
			$input.trigger('rutValido', splitRutAndDv($input.val()));
		} else {
			$input.trigger('rutInvalido');
		}
	}

	function splitRutAndDv(rut) {
		var cValue = clearFormat(rut);
		if(cValue.length === 0) { return [null, null]; }
		if(cValue.length === 1) { return [cValue, null]; }
		var cDv = cValue.charAt(cValue.length - 1);
		var cRut = cValue.substring(0, cValue.length - 1);
		return [cRut, cDv];
	}

	// public methods
	var methods = {
		init: function(options) {
			if (this.length > 1) {
				/* Valida multiples objetos a la vez */
				for (var i = 0; i < this.length; i++) {
					console.log(this[i]);
					$(this[i]).rut(options);
				}
			} else {
				var that = this;
				that.opts = $.extend({}, defaults, options);
				that.opts.formatOn && that.on(that.opts.formatOn, function(e) {
					if(that.opts.ignoreControlKeys && isControlKey(e)) { return; }
					formatInput(that, that.opts.useThousandsSeparator);
				});
				that.opts.validateOn && that.on(that.opts.validateOn, function() {
					validateInput(that);
				});
			}
			return this;
		}
	};

	$.fn.rut = function(methodOrOptions) {
		if(methods[methodOrOptions]) {
			return methods[methodOrOptions].apply(this, Array.prototype.slice.call( arguments, 1 ));
		} else if ( typeof methodOrOptions === 'object' || ! methodOrOptions ) {
			return methods.init.apply( this, arguments );
		} else {
			$.error("El método " + methodOrOptions + " no existe en jQuery.rut");
		}
	};

	$.formatRut = function (rut, useThousandsSeparator) {
		if(useThousandsSeparator===undefined) { useThousandsSeparator = true; }
		return format(rut, useThousandsSeparator);
	};

	$.computeDv = function(rut){
		var cleanRut = clearFormat(rut);
		return computeDv( parseInt(cleanRut, 10) );
	};

	$.validateRut = function(rut, fn, options) {
		options = options || {};
		if(isValidRut(rut, options)) {
			var rd = splitRutAndDv(rut);
			$.isFunction(fn) && fn(rd[0], rd[1]);
			return true;
		} else {
			return false;
		}
	};
})(jQuery);


</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" integrity="sha512-aOG0c6nPNzGk+5zjwyJaoRUgCdOrfSDhmMID2u4+OIslr0GjpLKo7Xm0Ao3xmpM4T8AmIouRkqwj1nrdVsLKEQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

@endsection