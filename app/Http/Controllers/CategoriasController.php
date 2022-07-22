<?php

namespace App\Http\Controllers;
use App\Models\Categoria;
use Exception;
use RealRashid\SweetAlert\Facades\Alert;


use DataTables;
use Illuminate\Http\Request;

class CategoriasController extends Controller
{
    public function index(Request $request)
    {
        return view('categorias.index');        
    }

    public function crearCategoria()
    {
        $categoria= New Categoria();
        return view('categorias.crear', compact('categoria'));
    }


    public function guardarCategoria(Request $request)
    {
        try{
            if ( $request->id ) {
                $categoria_existente = Categoria::where('nombre', $request->categoria['nombre'])->first();
                if($categoria_existente != null && $categoria_existente->id != $request->id){
                    alert()->error('Error','Ya exite una categoría con ese nombre');
                    return redirect()->back()->withInput();
                }
                $categoria = Categoria::findOrFail($request->id);
                $categoria->update( $request->categoria);   
            }else{
                $categoria_existente = Categoria::where('nombre', $request->categoria['nombre'])->first();
                if($categoria_existente == null){
                    $categoria = Categoria::create( $request->categoria );
                }
                else{
                    alert()->error('Error','Ya exite una categoría con ese nombre');
                    return redirect()->back()->withInput();
                }
            } 
            alert()->success('¡Éxito!','Categoría guardada satisfactoriamente');
            return redirect(route('categorias.index'));
        }catch(Exception $e){
            alert()->error('Error','No se pudo guardar la categoría, intente nuevamente');
            report($e);
            return redirect()->back()->withInput();
        }
    }

/*     public function guardarCategoria(Request $request)
    {
        try{
        
            if ( $request->id!=null ) { 

                $categoria = Categoria::findOrFail($request->id);
                $categoria->update( $request->categoria);   

            }else{
                $categoriaExistenente = Categoria::where('nombre', $request->categoria['nombre'])->first();
                if($categoriaExistenente == null){
                    $categoria = Categoria::create( $request->categoria );
                }
                else{
                    alert()->error('Error','Ya existe una categoría con ese nombre.');

                   
                    return redirect()->back()->withInput();
                   
                }
            } 
            alert()->success('¡Éxito!','Categoría guardado satisfactoriamente');
            return redirect(route('categorias.index'));
        }catch(Exception $e){
            alert()->error('Error','No se pudo guardar la categoría, intente nuevamente');
            report($e);
            return redirect()->back()->withInput();
        }
    } */


    public function editarCategoria($id)
    {
        $categoria =  Categoria::find($id);
        return view('categorias.editar',compact('categoria'));
    }



    public function eliminarCategoria($id){
        try {
            Categoria::find($id)->delete();
            alert()->success('Éxito','Categoría eliminada correctamente.');
            return redirect()->route('categorias.index');
        } catch (Exception $e) {
            alert()->error('Error','No se pudo eliminar la categoría, intente nuevamente');
            report($e);
            return redirect()->back();
        }
    }



    public function listar(Request $request) 
    {     
        if ($request->ajax()) {
            $data = Categoria::all();     
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($categoria){
               
                    $actionBtn = '<a href="'.route('categorias.editar',$categoria->id).'" class="edit btn btn-warning btn-sm ">Editar</a> 
                    
                    <form action="'.route('categorias.eliminar',$categoria->id).'" class="d-inline js-form-eliminar" method="post">
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
