<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $service = Service::all();

        if ($service->isEmpty()) {
            $data = [
                'message' => 'No services found',
                'status' => 200
            ];
            return response()->json($data, 200);
        }

        $data = [
            'message' => 'Services found',
            'status' => 200,
            'data' => $service
        ];

        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|min:3|unique:services',
            'description' => 'string|min:10',
            'image' => 'required|string',
            'price' => 'numeric|regex:/^\d+(\.\d{1,2})?$/',
            'duration' => 'integer',
            'category_id' => 'required|integer'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validation->errors()
            ], 400);
        }

        // Obtén los datos validados
        $validatedData = $validation->validated();

        $service = Service::create($validatedData);

        if (!$service) {
            return response()->json([
                'message' => 'Error creating service',
                'status' => 500
            ], 500);
        }

        $response = [
            'message' => 'Service created',
            'status' => 201,
            'data' => $service
        ];

        return response()->json($response, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $service = Service::find($id);

        if (!$service) {
            $data = [
                'message' => 'Service don\'t exist',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'message' => 'Service found',
            'status' => 200,
            'data' => $service
        ];

        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json([
                'message' => 'Service not found',
                'status' => 404
            ], 404);
        }

        $validation = Validator::make($request->all(), [
            'name' => 'required|string|min:3|unique:categories,name,' . $id,
            'description' => 'string|min:10',
            'image' => 'required|string',
            'price' => 'decimal:2',
            'duration' => 'integer',
            'category_id' => 'required|integer'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validation->errors()
            ], 400);
        }

        // Obtén los datos validados
        $validatedData = $validation->validated();

        $service->fill($validatedData);

        if (!$service->save()) {
            return response()->json([
                'message' => 'Error updating service',
                'status' => 500
            ], 500);
        }

        $response = [
            'message' => 'Service updated',
            'status' => 200,
            'data' => $service
        ];

        return response()->json($response, 200);
    }

    public function updatePartial(Request $request, string $id)
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json([
                'message' => 'Service not found',
                'status' => 404
            ], 404);
        }

        $validation = Validator::make($request->all(), [
            'name' => 'string|min:3|unique:categories,name,' . $id,
            'description' => 'string|min:10',
            'image' => 'string',
            'price' => 'decimal:2',
            'duration' => 'integer',
            'category_id' => 'integer'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validation->errors()
            ], 400);
        }

        // Obtén los datos validados
        $validatedData = $validation->validated();

        $service->update($validatedData);

        $response = [
            'message' => 'Service updated',
            'status' => 200,
            'data' => $service
        ];

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json([
                'message' => 'Service not found',
                'status' => 404
            ], 404);
        }

        if (!$service->delete()) {
            return response()->json([
                'message' => 'Error deleting service',
                'status' => 500
            ], 500);
        }

        $service->delete();

        $response = [
            'status' => 204
        ];

        return response()->json($response, 204);
    }
}
