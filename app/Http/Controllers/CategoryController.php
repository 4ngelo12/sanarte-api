<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();

        if ($categories->isEmpty()) {
            $data = [
                'message' => 'No categories found',
                'status' => 200
            ];
            return response()->json($data, 200);
        }

        $response = [
            'message' => 'Categorias no encontradas',
            'status' => 200,
            'data' => $categories
        ];

        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|min:3|unique:categories',
            'description' => 'required|min:10',
            'image' => 'required|string',
            'warning' => 'nullable|string|min:10'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' => 'Hubo un error al validar los datos, por favor verifica los campos',
                'errors' => $validation->errors()
            ], 400);
        }

        // Obtén los datos validados
        $validatedData = $validation->validated();

        $categories = Category::create($validatedData);

        if (!$categories) {
            return response()->json([
                'message' => 'Hubo un problema, intente nuevamente',
                'status' => 500
            ], 500);
        }

        $response = [
            'message' => 'Categoria creada correctamente',
            'status' => 201,
            'data' => $categories
        ];

        return response()->json($response, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'La categoría que buscas no existe',
                'status' => 404
            ], 404);
        }

        $response = [
            'message' => 'Category Encontrada',
            'status' => 200,
            'data' => $category
        ];

        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'Category not found',
                'status' => 404
            ], 404);
        }

        $validation = Validator::make($request->all(), [
            'name' => 'required|string|min:3|unique:categories,name,' . $id,
            'description' => 'required|min:10',
            'image' => 'required|string',
            'warning' => 'nullable|string|min:10',
            'state' => 'required|boolean',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' => 'Hubo un error al validar los datos, por favor verifica los campos',
                'errors' => $validation->errors()
            ], 400);
        }

        // Obtén los datos validados
        $validatedData = $validation->validated();

        $category->update($validatedData);

        $response = [
            'message' => 'Datos Actualizados',
            'status' => 200,
            'data' => $category
        ];

        return response()->json($response, 200);
    }

    public function updatePartial(Request $request, string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'Categoria no encontrada',
                'status' => 404
            ], 404);
        }

        $validation = Validator::make($request->all(), [
            'name' => 'string|min:3|unique:categories,name,' . $id,
            'description' => 'min:10',
            'image' => 'string',
            'warning' => 'string',
            'state' => 'boolean',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' => 'Hubo un error al validar los datos, por favor verifica los campos',
                'errors' => $validation->errors()
            ], 400);
        }

        // Obtén los datos validados
        $validatedData = $validation->validated();

        $category->update($validatedData);

        $response = [
            'message' => 'Category updated',
            'status' => 200,
            'data' => $category
        ];

        return response()->json($response, 200);
    }

    /**Z
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'Category not found',
                'status' => 404
            ], 404);
        }

        // Actualizar el estado del servicio a false
        $category->state = false;

        // Guardar los cambios en la base de datos
        if (!$category->save()) {
            return response()->json([
                'message' => 'Error al desactivar la categoria',
                'status' => 500
            ], 500);
        }

        $response = [
            'status' => 204
        ];

        return response()->json($response, 204);
    }
}
