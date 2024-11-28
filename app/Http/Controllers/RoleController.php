<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use Carbon\Carbon;

class RoleController extends Controller
{
    public function Role(Request $request) {
        $roles = Role::all();
        return view('page.roles.index', ['roles'=>$roles]);
    }

    public function Insert() {
        $permissions = Permission::orderBy('name', 'ASC')->get();
        return view('page.roles.insert', ['permissions'=>$permissions]);
    }

    public function InsertData(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'permission' => 'array', 
        ]);
    
        // Create the new role
        $role = Role::create(['name' => $request->name]);
        
        // Attach selected permissions to the role
        if ($request->has('permission')) {
            $permissions = Permission::whereIn('name', $request->permission)->pluck('id');
            $role->permissions()->attach($permissions); 
        }

        return redirect()->route('role')->with('message', 'Role created and permissions assigned!');
    }

    // update 
    public function Update($id) {
        $role = Role::find($id);
        $permissions = Permission::orderBy('name', 'ASC')->get();
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('page.roles.edit', [
            'role' => $role, 
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions
        ]);
    }

    public function DataUpdate(Request $request, $id) {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'permission' => 'array', 
        ]);
    
        $role = Role::findOrFail($id);
        $role->name = $request->input('name');
        $role->updated_at = Carbon::now();
        $role->save();
    
        if ($request->has('permissions')) {
            // Fetch the permission IDs from the submitted form
            $permissions = $request->input('permissions');
            // Synchronize the role's permissions with the provided permission IDs
            $role->permissions()->sync($permissions);
        } else {
            // If no permissions are selected, detach all permissions from the role
            $role->permissions()->detach();
        }
        
        return redirect()->route('role')->with('message','Role Updated Successfully');
    }

    // delete 
    public function Delete(Request $request, $id){
        try {
            Role::destroy($request->id);
            return redirect()->route('role')->with('message','Delete Successfully');
        } catch(\Exception $e) {
            report($e);
        }
    }

    
}
