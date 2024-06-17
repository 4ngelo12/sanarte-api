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
                'message' => 'Validation failed',
                'errors' => $validation->errors()
            ], 400);
        }

        // Obtén los datos validados
        $validatedData = $validation->validated();

        $client = Client::create($validatedData);

        if (!$client) {
            return response()->json([
                'message' => 'Error creating client',
                'status' => 500
            ], 500);
        }

        $response = [
            'message' => 'Client created',
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
                'message' => 'Client don\'t exist',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'message' => 'Client found',
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
            'phone' => 'required|string|max:9|regex:/^[9]{1}[0-9]{8}$/|unique:clients,phone,' . $id
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validation->errors()
            ], 400);
        }

        // Obtén los datos validados
        $validatedData = $validation->validated();

        $client->fill($validatedData);

        if (!$client->save()) {
            return response()->json([
                'message' => 'Error updating client',
                'status' => 500
            ], 500);
        }

        $response = [
            'message' => 'Client updated',
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
            'phone' => 'string|max:9|regex:/^[9]{1}[0-9]{8}$/|unique:clients,phone,' . $id
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validation->errors()
            ], 400);
        }

        // Obtén los datos validados
        $validatedData = $validation->validated();

        $client->update($validatedData);

        $response = [
            'message' => 'Client updated',
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
                'message' => 'Client not found',
                'status' => 404
            ], 404);
        }

        if (!$client->delete()) {
            return response()->json([
                'message' => 'Error deleting client',
                'status' => 500
            ], 500);
        }

        $client->delete();

        $response = [
            'status' => 204
        ];

        return response()->json($response, 204);
    }
}
