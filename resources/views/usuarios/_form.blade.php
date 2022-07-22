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
            <form action="{{route('usuarios.guardar')}}" method="POST" enctype="multipart/form-data" id="form">
                @csrf

                <div class="row">


					@if ( @isset($usuario->id)  )
					<h1>EDITAR USUARIO</h1>                               
					@else
					<h1>AGREGAR USUARIO</h1>
					@endif
					  

                   
                    <hr class="mb-2 w-100">


                    <div class="mb-md-3 mb-2 mt-3 ">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input maxlength="50" required type="text" name="usuario[nombre]" id="usuario_nombre" placeholder="" value="{{old('usuario.nombre',$usuario->name)}}"
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
                        <label for="nombre" class="form-label">Correo Electrónico</label>
                        <input maxlength="50" type="email" required name="usuario[email]" id="usuario_email" value="{{old('usuario.email',$usuario->email)}}"
                        class="form-control @error('email') is-invalid @enderror" >
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div> 
                </div> 

                <div class="row">
                    <div class="mb-md-3 mb-2 mt-3 ">
					

                        <label for="nombre" class="form-label">Contraseña</label>
                        <input maxlength="50" required type="password" name="usuario[contrasena]" id="usuario_contrasena"
                        class="form-control @error('comuna') is-invalid @enderror" >
                        @error('comuna')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

						<h6 style="color: red;" class="mt-2 mb-0" id="textoerror"></h6>
                    </div> 
                </div> 


				<div class="row">
                    <div class="mb-md-3 mb-2 mt-3 ">
                        <label for="nombre" class="form-label">Confirmar Contraseña</label>
                        <input maxlength="50" required type="password" name="usuario[contrasena2]" id="usuario_contrasena2"
                        class="form-control @error('comuna') is-invalid @enderror" >
                        @error('comuna')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div> 
                </div> 
                
            


                
                <hr class="mb-3 mt-3 w-100">

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 mx-auto mr-auto">
                        <input type="hidden" name="id" value="{{$usuario->id ?? ''}}">
                        <a class="btn btn-dark" href="{{url()->previous()}}" name="aceptarBtn">Volver</a>
                        <button class="btn btn-primary" id="guardar-btn"  type="submit" name="aceptarBtn" style="float: right">Guardar</button>
                        @isset($usuario->id)
                            <button type="submit" class="btn btn-danger" style='float: right; margin-right: 1%' id="btn-eliminar" data-usuario_id="{{$usuario->id}}">Eliminar</button>
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
                $('#form').attr('action', "{{route('usuarios.eliminar', '')}}"+"/"+$(this).data('usuario_id'));
                $('#form').submit();
            }
            else{
                return false;
            }
    });



})



$('#usuario_contrasena').on('change',function(e){
	if(this.value!=   $('#usuario_contrasena2').val() ){
		$( '#guardar-btn' ). prop( 'disabled' , true );
        document.getElementById("textoerror").innerHTML = "Las contraseñas deben coincidir.";
	}else{
		$( '#guardar-btn' ). prop( 'disabled' , false );
        document.getElementById("textoerror").innerHTML = "";
	}

});



$('#usuario_contrasena2').on('change',function(e){
	if(this.value!=   $('#usuario_contrasena').val() ){
		$( '#guardar-btn' ). prop( 'disabled' , true );
        document.getElementById("textoerror").innerHTML = "Las contraseñas deben coincidir.";
	}else{
		$( '#guardar-btn' ). prop( 'disabled' , false );
        document.getElementById("textoerror").innerHTML = "";
	}

});


















</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" integrity="sha512-aOG0c6nPNzGk+5zjwyJaoRUgCdOrfSDhmMID2u4+OIslr0GjpLKo7Xm0Ao3xmpM4T8AmIouRkqwj1nrdVsLKEQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

@endsection