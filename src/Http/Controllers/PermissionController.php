<?php

namespace Ameth\Diamanka\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{

    public function index()
    {
        $permissions = Permission::paginate(10);
        return view('diamanka::permissions.index', compact('permissions'));
    }


    public function create()
    {
        return view('diamanka::permissions.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        Permission::create(['name' => $request->name]);

        return redirect()->route('diamanka.permissions.index')
            ->with('success', 'Permission créée avec succès !');
    }


    public function edit(Permission $permission)
    {
        return view('diamanka::permissions.edit', [
        'permission' => $permission,
        'roles' => Role::all()
    ]);
    }


    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update(['name' => $request->name]);

        return redirect()->route('diamanka.permissions.index')
            ->with('success', 'Permission mise à jour !');
    }


    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('diamanka.permissions.index')
            ->with('success', 'Permission supprimée !');
    }
}