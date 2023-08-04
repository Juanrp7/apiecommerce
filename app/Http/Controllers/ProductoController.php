<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productos;


class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Obtiene todos los productos de la BD mediante el model Productos
        $productos = Productos::all();
        return $productos;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      
        //Se validan los datos de entrada            
        $validacion = $request->validate([
            'nombre' => 'required|max:100',
            'cantidad' => 'required|numeric',
            'precio' => 'required|numeric',
            'categoria' => 'required',
        ]);

        //Si los datos de entrada pasan, se crean los registros en la BD
        $productos = Productos::create($request->all());
        //Respuesta del servidor en JSON
        return response()->json($productos, 200);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //Se pasa como para el id del producto a ser consultado
        $producto = Productos::find($id);
        //Si no encuenta el producto por el id, retorna mensaje de error
        if(is_null($producto)){
            return response()->json(["message"=>"Registro no encontrado"], 404);
        }
        //retorno del producto consultado
        return response()->json($producto, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        //Se validan los datos a actualizar          
        $validacion = $request->validate([
            'nombre' => 'max:100',
            'cantidad' => 'numeric',
            'precio' => 'numeric',
            'categoria' => 'max:100',
        ]);

        //Se pasa por parametro el id del producto a modificar
        $producto = Productos::find($id);
        //Si no encuentra el id en la BD, arroja mensaje de error
        if(is_null($producto)){
            return response()->json(["message"=>"Registro no encontrado"],404);
        }
        //Si todo va bien, actualiza el registro
        $producto->update($request->all());
        //retorna el producto actualizado
        return response()->json($producto, 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //Se pasa por parametro el id del producto a eliminar y se consulta
        $producto = Productos::find($id);
        //Si no encuentra el producto en la BD, arroja mensaje de error
        if(is_null($producto)){
            return response()->json(["message"=>"Registro no encontrado"], 404);
        }
        //Si todo va bien, eliminar el registro
        $producto->delete();
        return response()->json(["message"=>"Registro Eliminado"], 200);
    }
}
