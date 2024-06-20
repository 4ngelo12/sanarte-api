<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $role = Role::all();

        if ($role->isEmpty()) {
            $data = [
                'message' => 'No hay roles registrados',
                'status' => 200
            ];
            return response()->json($data, 200);
        }

        $data = [
            'message' => 'Roles encontrados',
            'status' => 200,
            'data' => $role
        ];

        return response()->json($data, 200);
    }

    public function show(string $id)
    {
        $role = Role::find($id);

        if (!$role) {
            $data = [
                'message' => 'Role no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        return response()->json($role, 200);
    }
}
