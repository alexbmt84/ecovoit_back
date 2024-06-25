<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index() {
        $roles = Role::all();
        return response()->json($roles);
    }

    public function store(Request $request) {

        try {

            $validateData = $request->validate([
                'label' => 'required|string|max:50'
            ]);

            $role = Role::create([
                'label' => $validateData['label']
            ]);

            return response()->json($role);

        } catch (\Exception) {

            return response()->json(['message' => 'Error while trying to save role.'], 422);

        }

    }

    public function read($roleId) {

        $role = Role::query()->where('id', $roleId)->first();

        if(!$role) {
            return response()->json(['message' => 'No role found.'], 404);
        }

        return response()->json($role);
    }

    public function update(Request $request, $id)
    {
        try {

            $role = Role::findOrFail($id);

            $validateData = $request->validate([
                'label' => 'required|string|max:50',
            ]);

            $role->update([
                'label' =>  $validateData['label'],
            ]);

            return response()->json($role);


        } catch (\Exception) {

            return response()->json(['message' => 'Error while trying to update role.'], 422);

        }

    }

    public function delete($roleId)
    {

        try {

            $role = Role::findOrFail($roleId);
            $role->delete();

            return response()->json(['message' => 'Role has been successfully deleted.']);

        } catch (\Exception) {

            return response()->json(['message' => 'Error while trying to delete role.'], 422);

        }

    }
}
