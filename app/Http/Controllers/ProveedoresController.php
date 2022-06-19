<?php

namespace App\Http\Controllers;
use App\Models\Proveedor;
use RealRashid\SweetAlert\Facades\Alert;


use DataTables;
use Illuminate\Http\Request;

class ProveedoresController extends Controller
{
    public function index(Request $request)
    {
        return view('proveedores.index');        
    }

   

    public function crearProveedor()
    {
        $proveedor= New Proveedor();
        return view('proveedores.crear', compact('proveedor'));
    }

    public function guardarProveedor(Request $request)
    {
        try{
        
            if ( $request->id!=null ) { 

                $proveedor = Proveedor::findOrFail($request->id);
                $proveedor->update( $request->proveedor);   

            }else{
                $proveedorExistenente = Proveedor::where('nombre', $request->proveedor['nombre'])->first();
                if($proveedorExistenente == null){
                    $proveedor = Proveedor::create( $request->proveedor );
                }
                else{
                    alert()->error('Error','Ya existe un Proveedor con ese Nombre.');

                   
                    return redirect()->back()->withInput();
                   
                }
            } 
            alert()->success('¡Éxito!','Proveedor guardado satisfactoriamente');
            return redirect(route('proveedores.index'));
        }catch(Exception $e){
            alert()->error('Error','No se pudo guardar el proveedor, intente nuevamente');
            report($e);
            return redirect()->back()->withInput();
        }
    }



    public function editarProveedor($id)
    {
        $proveedor =  Proveedor::find($id);
        return view('proveedores.editar',compact('proveedor'));
    }


    

    public function eliminarProveedor($id){
        try {
            Proveedor::find($id)->delete();
            return redirect()->route('proveedores.index');
        } catch (Exception $e) {
            alert()->error('Error','No se pudo eliminar el proveedor, intente nuevamente');
            report($e);
            return redirect()->back();
        }
    }




    public function listar(Request $request) 
    {     
        if ($request->ajax()) {
            $data = Proveedor::all();     
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($proveedor){
               
                    $actionBtn = '<a href="'.route('proveedores.editar',$proveedor->id).'" class="edit btn btn-success btn-sm ">Editar</a> 
                    
                    <form action="'.route('proveedores.eliminar',$proveedor->id).'" class="d-inline js-form-eliminar" method="post">
                        <input type="hidden" name="_token" value="'.csrf_token().'">
                        <input type="hidden" name="_method" value="delete" />
                        <input class="delete btn btn-danger btn-sm" type="submit" value="Eliminar" />    
                    </form>';
                    return $actionBtn;
                
            })                     
            ->rawColumns(['action'])
            ->make(true);
        }
    }



}
