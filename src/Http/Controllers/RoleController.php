<?php

namespace Ameth\Diamanka\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{

    public function index()
    {
        $roles = Role::with('permissions')->paginate(10);
        return view('diamanka::roles.index', compact('roles'));
    }


    public function create()
    {
        $permissions = Permission::all();
        return view('diamanka::roles.create', compact('permissions'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create(['name' => $request->name]);
        
        if($role){

            $permission_names = Permission::query()->whereIn('id',$request->permissions)->pluck('name')->toArray();

            $role->syncPermissions($permission_names);

            app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
            cache()->flush();
             return redirect()->route('diamanka.roles.index')->with('success', 'Role created');

        }
        

        return redirect()->route('diamanka.roles.index')->with('error', 'Something wrong !');
    }


    public function show(Role $role)
    {
        return view('diamanka::roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('diamanka::roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
        ]);

        $updated = $role->update(['name' => $request->name]);

        if($updated){

            $permission_names = Permission::query()->whereIn('id',$request->permissions)->pluck('name')->toArray();

            $role->syncPermissions($permission_names);

            app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
            cache()->flush();
            
            return redirect()->route('diamanka.roles.index')->with('success', 'Role is updated');
        }

        return redirect()->route('diamanka.roles.index')
            ->with('error', 'Something wrong !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {

        $permissionNameOfRoles = $role->permissions->pluck('name');

        if($role->permissions->count() > 0){
            foreach ($permissionNameOfRoles as $value) {
                $role->revokePermissionTo($value);
            }
        }

        $role->delete();
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        cache()->flush();

        return redirect()->back()->with('success', 'Rôle supprimé !');
    }
}