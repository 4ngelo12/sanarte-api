<?php

namespace App\Http\Controllers;

use App\Models\Personal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PersonalController extends Controller
{
    public function index()
    {
        $personal = Personal::all();

        if ($personal->isEmpty()) {
            $data = [
                'message' => 'No personal found',
                'status' => 200
            ];
            return response()->json($data, 200);
        }

        $data = [
            'message' => 'personal found',
            'status' => 200,
            'data' => $personal
        ];

        return response()->json($data, 200);
    }

    public function personalActiveByServiceId(string $id)
    {
        $personal = Personal::where('service_id', $id)->where('status', true)->get();

        if ($personal->isEmpty()) {
            $data = [
                'message' => 'No hay personal activo disponible',
                'data' => [],
                'status' => 200
            ];
            return response()->json($data, 200);
        }

        $data = [
            'message' => 'Personal encontrada',
            'status' => 200,
            'data' => $personal
        ];

        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|min:3',
            'lastname' => 'required|string|min:3',
            'phone' => 'required|string|min:9|max:9|regex:/^[9]{1}[0-9]{8}$/|unique:personal',
            'service_id' => 'required|integer'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' => 'Hubo un error al validar los datos, por favor verifica los campos',
                'errors' => $validation->errors()
            ], 400);
        }

        // Obtén los datos validados
        $validatedData = $validation->validated();

        $personal = Personal::create($validatedData);

        if (!$personal) {
            return response()->json([
                'message' => 'Error al crear el personal',
                'status' => 500
            ], 500);
        }

        $response = [
            'message' => 'personal registrado correctamente',
            'status' => 201,
            'data' => $personal
        ];

        return response()->json($response, 201);
    }


    public function show(string $id)
    {
        $personal = Personal::find($id);

        if (!$personal) {
            $data = [
                'message' => 'El personal no existe',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'message' => 'personal encontrado',
            'status' => 200,
            'data' => $personal
        ];

        return response()->json($data, 200);
    }

    public function update(Request $request, string $id)
    {
        $personal = Personal::find($id);

        if (!$personal) {
            return response()->json([
                'message' => 'personal not found',
                'status' => 404
            ], 404);
        }

        $validation = Validator::make($request->all(), [
            'name' => 'required|string|min:3',
            'lastname' => 'required|string|min:3',
            'phone' => 'required|string|max:9|regex:/^[9]{1}[0-9]{8}$/|unique:personal,phone,' . $id,
            'service_id' => 'required|integer',
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

        $personal->fill($validatedData);

        if (!$personal->save()) {
            return response()->json([
                'message' => 'Error actualizando los datos del personal',
                'status' => 500
            ], 500);
        }

        $response = [
            'message' => 'Datos del personal actualizados correctamente',
            'status' => 200,
            'data' => $personal
        ];

        return response()->json($response, 200);
    }

    public function updatePartial(Request $request, string $id)
    {
        $personal = Personal::find($id);

        if (!$personal) {
            return response()->json([
                'message' => 'personal not found',
                'status' => 404
            ], 404);
        }

        $validation = Validator::make($request->all(), [
            'name' => 'string|min:3',
            'lastname' => 'string|min:3',
            'phone' => 'string|max:9|regex:/^[9]{1}[0-9]{8}$/|unique:personal,phone,' . $id,
            'service_id' => 'integer',
            'status' => 'required|boolean'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' => 'Hubo un error al validar los datos, por favor verifica los campos',
                'errors' => $validation->errors()
            ], 400);
        }

        // Obtén los datos validados
        $validatedData = $validation->validated();

        $personal->fill($validatedData);

        if (!$personal->save()) {
            return response()->json([
                'message' => 'Error actualizando los datos del personal',
                'status' => 500
            ], 500);
        }

        $response = [
            'message' => 'Datos del personal actualizados correctamente',
            'status' => 200,
            'data' => $personal
        ];

        return response()->json($response, 200);
    }


    public function destroy(string $id)
    {
        $personal = Personal::find($id);

        if (!$personal) {
            return response()->json([
                'message' => 'personal no encontrado',
                'status' => 404
            ], 404);
        }

        $personal->status = false;

        if (!$personal->save()) {
            return response()->json([
                'message' => 'Error al desactivar el personal',
                'status' => 500
            ], 500);
        }


        $response = [
            'status' => 204
        ];

        return response()->json($response, 204);
    }
}
