<?php

namespace App\Http\Controllers;
use App\Http\Requests\ClientesRequest;
use Illuminate\Http\Request;
use App\Models\Cliente;

use DataTables;
class ClientesController extends Controller
{

    public function tablero(Request $request)
    {
        return view('tablero');        
    }


    public function index(Request $request)
    {
        return view('clientes.agregar');        
    }


    public function crearCliente()
    {
        $cliente= New Cliente();
        return view('clientes.crear', compact('cliente'));
    }

    public function editarCliente($rut)

    {
       
    
        $cliente =  Cliente::where('rut', $rut)->first();
       
        
        return view('clientes.editar',compact('cliente'));
    }

    public function guardarCliente(ClientesRequest $request)

    {
      
        try{
            if ( Cliente::where('rut',$request->cliente['rut'])->exists() ) {       
                        
                $cliente = Cliente::where('rut',$request->cliente['rut'])->first();
                $cliente->rut = $request->cliente['rut'];
                $cliente->nombre = $request->cliente['nombre'];
                $cliente->comuna = $request->cliente['comuna'];
                $cliente->direccion = $request->cliente['direccion'];
                $cliente->telefono = $request->cliente['telefono'];
                $cliente->email = $request->cliente['email'];
                $cliente->save();
            }else{
                $cliente = Cliente::create( $request->cliente );
            } 
             Alert()->success('¡Éxito!','Cliente guardado satisfactoriamente'); 
            return redirect(route('clientes.index'));
        }catch(Exception $e){
          
            Alert()->error('Error','No se pueden guardar los datos, intente nuevamente'); 
            report($e);
            dd($e);
            return redirect()->back()->withInput();
        }
    }


    
    public function listar(Request $request)
    
    {
        if ($request->ajax()) {
            $data = Cliente::all();     

            
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($cliente){
               
                    $actionBtn = '<a href="'.route('clientes.editar',$cliente->rut).'" class="edit btn btn-success btn-sm ">Editar</a> 
                    
                    <form action="'.route('clientes.eliminar',$cliente->rut).'" class="d-inline js-form-eliminar" method="post">
                        <input type="hidden" name="_token" value="'.csrf_token().'">
                        <input type="hidden" name="_method" value="delete" />
                        <input class="delete btn btn-danger btn-sm" type="submit" value="Eliminar" />    
                    </form>';
                    return $actionBtn;
                
            })      
            
            ->addColumn('rut', function($cliente){
                
                return '<label for="precio" class="form-label ">'.$cliente->rut.'</label>';
                              
            })        
            ->rawColumns(['action','rut'])
            ->make(true);
        }
    }


    public function eliminarCliente($rut){
        try{
            Cliente::where('rut',$rut)->delete();
            return redirect()->route('clientes.index');
        }catch(Exception $e){
            report($e);
            alert()->error('Error','No se pudo eliminar el cliente, intente nuevamente');
        }
    }
}
