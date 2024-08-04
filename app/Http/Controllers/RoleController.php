<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Response;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        if ($roles->isEmpty()) {
            return response()->json(['message' => 'Roles is Empty'], Response::HTTP_NOT_FOUND);
        }
        return response()->json(['message' => 'Roles Data', 'roles' => $roles], Response::HTTP_OK);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        $role = Role::create($request->validated());
        if (!$role) {
            return response()->json(["result" => 'false', 'message' => 'Failed to Store'], Response::HTTP_NOT_FOUND);
        }
        return response()->json(["result" => 'true', 'message' => 'Roles Created', 'roles' => $role], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return response()->json(["result" => 'true', 'message' => 'Role', 'roles' => $role], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role = $request->validated();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        if (!$role) {
        }
    }
}
