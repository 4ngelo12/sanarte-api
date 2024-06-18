<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $status = Status::all();

        if ($status->isEmpty()) {
            $data = [
                'message' => 'No status found',
                'status' => 200
            ];
            return response()->json($data, 200);
        }

        $data = [
            'message' => 'Status found',
            'status' => 200,
            'data' => $status
        ];

        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|min:3|unique:status',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validation->errors()
            ], 400);
        }

        // Obtén los datos validados
        $validatedData = $validation->validated();

        $status = Status::create($validatedData);

        if (!$status) {
            return response()->json([
                'message' => 'Error creating status',
                'status' => 500
            ], 500);
        }

        $response = [
            'message' => 'Status created',
            'status' => 201,
            'data' => $status
        ];

        return response()->json($response, 201);
    }
}
