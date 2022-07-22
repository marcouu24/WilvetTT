<?php

namespace App\Http\Controllers;
use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\UsuariosRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use DataTables;
class UsuariosController extends Controller
{
    public function index(Request $request)
    {
        return view('usuarios.index');        
    }

    public function eliminarUsuario($id){
        try{
            User::where('id',$id)->delete();
            alert()->success('Éxito','Usuario eliminado correctamente');
            return redirect()->route('usuarios.index');
            
        }catch(Exception $e){
            report($e);
            alert()->error('Error','No se pudo eliminar el usuario, intente nuevamente');
            return redirect()->back();
        }
    }



    public function crearUsuario()
    {
        $usuario= New User();
        return view('usuarios.crear', compact('usuario'));
    }



    public function editarUsuario($id)

    { 
        $usuario =  User::where('id', $id)->first();   
        return view('usuarios.editar',compact('usuario'));
    }


    public function guardarUsuario(UsuariosRequest $request)
    {

      

        try{
            
            if ( $request->id ) {
                $usuario_existente = User::where('id', $request->id)->first();
               
                $usuario_existenteCorreo='a';
                
                $usuario_existenteCorreo = User::where('email', $request->usuario['email'])->first();
               

                if($usuario_existenteCorreo!=''){
                    if($usuario_existente != null && $usuario_existenteCorreo->id !=  $request->id){
                        alert()->error('Error','Ya exite un usuario con ese correooo');
                        return redirect()->back()->withInput();
                    }
                }

               
                
                $usuario = User::where('id',$request->id)->first();
              
                $usuario->name = $request->usuario['nombre'];
                $usuario->email = $request->usuario['email'];
                $usuario->password = Hash::make($request->usuario['contrasena']);
                $usuario->save();


            }else{
                $usuario = User::where('email', $request->usuario['email'])->first();
                if($usuario == null){
                   
                    $usuario = User::create(
                        [
                            'name' => $request->usuario['nombre'],
                            'email' => $request->usuario['email'],
                            'password' => Hash::make($request->usuario['contrasena'])
                        ]
                    );
                }
                else{
                    alert()->error('Error','Ya exite un usuario con ese correo');
                    return redirect()->back()->withInput();
                }
            } 
            alert()->success('¡Éxito!','Usuario guardado satisfactoriamente');
            return redirect(route('usuarios.index'));
        }catch(Exception $e){
            alert()->error('Error','No se pudo guardar el usuario, intente nuevamente');
           
            return redirect()->back()->withInput();
        }


      
        
    }




    public function listar(Request $request)
    
    {

        if ($request->ajax()) {
            $data = User::all();     

           
            
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($usuario){
               
                   
                    
                    if($usuario->id==auth()->user()->id){
                        $actionBtn = '<a href="'.route('usuarios.editar',$usuario->id).'" class="edit btn btn-warning btn-sm ">Editar</a>
                        <form action="'.route('usuarios.eliminar',$usuario->id).'" class="d-inline js-form-eliminar" method="post">
                        <input type="hidden" name="_token" value="'.csrf_token().'">
                        <input type="hidden" name="_method" value="delete" />
                        <input class="delete btn btn-danger btn-sm" disabled type="submit" value="Eliminar" />    
                    </form>';
                    return $actionBtn;
                    }else{
                        $actionBtn = '<a href="'.route('usuarios.editar',$usuario->id).'" class="edit btn btn-warning btn-sm ">Editar</a>
                        <form action="'.route('usuarios.eliminar',$usuario->id).'" class="d-inline js-form-eliminar" method="post">
                        <input type="hidden" name="_token" value="'.csrf_token().'">
                        <input type="hidden" name="_method" value="delete" />
                        <input class="delete btn btn-danger btn-sm"  type="submit" value="Eliminar" />    
                    </form>';
                    return $actionBtn;
                    }
                    
                
            })      
            
           
            ->rawColumns(['action'])
            ->make(true);
        }
    }


}
