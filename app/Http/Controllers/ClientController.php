<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $client = Client::all();

        if ($client->isEmpty()) {
            $data = [
                'message' => 'No clients found',
                'status' => 200
            ];
            return response()->json($data, 200);
        }

        $data = [
            'message' => 'Clients found',
            'status' => 200,
            'data' => $client
        ];

        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|min:3',
            'lastname' => 'required|string|min:3',
            'email' => 'nullable|email|unique:clients',
            'phone' => 'required|string|min:9|max:9|regex:/^[9]{1}[0-9]{8}$/|unique:clients'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' => 'Hubo un error al validar los datos, por favor verifica los campos',
                'errors' => $validation->errors()
            ], 400);
        }

        // Obtén los datos validados
        $validatedData = $validation->validated();

        $client = Client::create($validatedData);

        if (!$client) {
            return response()->json([
                'message' => 'Error al crear el cliente',
                'status' => 500
            ], 500);
        }

        $response = [
            'message' => 'Cliente registrado correctamente',
            'status' => 201,
            'data' => $client
        ];

        return response()->json($response, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $client = Client::find($id);

        if (!$client) {
            $data = [
                'message' => 'El cliente no existe',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'message' => 'Client encontrado',
            'status' => 200,
            'data' => $client
        ];

        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $client = Client::find($id);

        if (!$client) {
            return response()->json([
                'message' => 'Client not found',
                'status' => 404
            ], 404);
        }

        $validation = Validator::make($request->all(), [
            'name' => 'required|string|min:3',
            'lastname' => 'required|string|min:3',
            'email' => 'nullable|unique:clients,email,' . $id,
            'phone' => 'required|string|max:9|regex:/^[9]{1}[0-9]{8}$/|unique:clients,phone,' . $id,
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

        $client->fill($validatedData);

        if (!$client->save()) {
            return response()->json([
                'message' => 'Error actualizando los datos del cliente',
                'status' => 500
            ], 500);
        }

        $response = [
            'message' => 'Datos del cliente actualizados correctamente',
            'status' => 200,
            'data' => $client
        ];

        return response()->json($response, 200);
    }

    public function updatePartial(Request $request, string $id)
    {
        $client = Client::find($id);

        if (!$client) {
            return response()->json([
                'message' => 'Client not found',
                'status' => 404
            ], 404);
        }

        $validation = Validator::make($request->all(), [
            'name' => 'string|min:3',
            'lastname' => 'string|min:3',
            'email' => 'nullable|email|unique:clients,email,' . $id,
            'phone' => 'string|max:9|regex:/^[9]{1}[0-9]{8}$/|unique:clients,phone,' . $id,
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

        $client->update($validatedData);

        $response = [
            'message' => 'Datos del cliente actualizados correctamente',
            'status' => 200,
            'data' => $client
        ];

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = Client::find($id);

        if (!$client) {
            return response()->json([
                'message' => 'Cliente no encontrado',
                'status' => 404
            ], 404);
        }

        $client->state = false;

        if (!$client->save()) {
            return response()->json([
                'message' => 'Error al desactivar el cliente',
                'status' => 500
            ], 500);
        }


        $response = [
            'status' => 204
        ];

        return response()->json($response, 204);
    }
}
