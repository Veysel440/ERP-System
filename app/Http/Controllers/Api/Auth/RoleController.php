<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        return Role::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:roles',
        ]);
        $role = Role::create($data);
        return response()->json($role, 201);
    }

    public function show(Role $role)
    {
        return $role;
    }

    public function update(Request $request, Role $role)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
        ]);
        $role->update($data);
        return $role;
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return response()->json(['message' => 'Rol silindi']);
    }
}
