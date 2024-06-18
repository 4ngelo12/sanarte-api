<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function show(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            $data = [
                'message' => 'Service don\'t exist',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'message' => 'Service found',
            'status' => 200,
            'data' => $user
        ];

        return response()->json($data, 200);
    }
}
