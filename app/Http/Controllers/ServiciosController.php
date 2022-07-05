<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicio;
use RealRashid\SweetAlert\Facades\Alert;


use DataTables;
class ServiciosController extends Controller
{
    public function index(Request $request)
    {
        return view('servicios.index');        
    }

   

    public function crearServicio()
    {
        $servicio= New Servicio();
        return view('servicios.crear', compact('servicio'));
    }



    public function guardarServicio(Request $request)
    {
        try{
            if ( $request->id ) {
                $servicio_existente = Servicio::where('nombre', $request->servicio['nombre'])->first();
                if($servicio_existente != null && $servicio_existente->id != $request->id){
                    alert()->error('Error','Ya exite un servicio con ese nombre');
                    return redirect()->back()->withInput();
                }
                $servicio = Servicio::findOrFail($request->id);
                $servicio->update( $request->servicio);   
            }else{
                $servicio_existente = Servicio::where('nombre', $request->servicio['nombre'])->first();
                if($servicio_existente == null){
                    $servicio = Servicio::create( $request->servicio );
                }
                else{
                    alert()->error('Error','Ya exite un servicio con ese nombre');
                    return redirect()->back()->withInput();
                }
            } 
            alert()->success('¡Éxito!','Servicio guardado satisfactoriamente');
            return redirect(route('servicios.index'));
        }catch(Exception $e){
            alert()->error('Error','No se pudo guardar el servicio, intente nuevamente');
            report($e);
            return redirect()->back()->withInput();
        }
    }

/*     public function guardarServicio(Request $request)
    {
        try{
        
            if ( $request->id!=null ) { 

                $servicio = Servicio::findOrFail($request->id);
                $servicio->update( $request->servicio);   

            }else{
                $servicioExistenente = Servicio::where('nombre', $request->servicio['nombre'])->first();
                if($servicioExistenente == null){
                    $servicio = Servicio::create( $request->servicio );
                }
                else{
                    alert()->error('Error','Ya existe un servicio con ese nombre.');

                   
                    return redirect()->back()->withInput();
                   
                }
            } 
            alert()->success('¡Éxito!','Servicio guardado satisfactoriamente');
            return redirect(route('servicios.index'));
        }catch(Exception $e){
            alert()->error('Error','No se pudo guardar el servicio, intente nuevamente');
            report($e);
            return redirect()->back()->withInput();
        }
    } */


    public function editarServicio($id)
    {
        $servicio =  Servicio::find($id);
        return view('servicios.editar',compact('servicio'));
    }


    public function eliminarServicio($id){
        try {
            Servicio::find($id)->delete();
            return redirect()->route('servicios.index');
        } catch (Exception $e) {
            alert()->error('Error','No se pudo eliminar el servicio, intente nuevamente');
            report($e);
            return redirect()->back();
        }
    }


    public function listar(Request $request) 
    {     
        if ($request->ajax()) {
            $data = Servicio::all();     
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($servicio){
               
                    $actionBtn = '<a href="'.route('servicios.editar',$servicio->id).'" class="edit btn btn-warning btn-sm ">Editar</a> 
                    
                    <form action="'.route('servicios.eliminar',$servicio->id).'" class="d-inline js-form-eliminar" method="post">
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
