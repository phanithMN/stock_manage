<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;

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
            'name' => 'required', 
            'permission' => 'array',
            'permission.*' => 'exists:permissions,name', 
        ]);
    
        // Create the new role
        $role = Role::create(['name' => $request->name]);
        
        // Attach selected permissions to the role
        if ($request->has('permission')) {
            $permissions = Permission::whereIn('name', $request->permission)->pluck('id');
            $role->permissions()->attach($permissions);  // This will insert into the 'role_permission' table
        }

        return redirect()->route('role')->with('message', 'Role created and permissions assigned!');
    }

    // update 
    public function Update($id) {
        $roles = Role::find($id);
        $permissions = Permission::orderBy('name', 'ASC')->get();
        return view('page.roles.edit', [
            'roles' => $roles, 
            'permissions' => $permissions
        ]);
    }

    public function DataUpdate(Request $request, $id) {
        $request->validate([
            'name' => 'required|string|max:255',
            // Other validations
        ], [
            'name.required' => 'Please enter name.',
            // Custom messages for other fields
        ]);
        
        $roles = Role::find($id);
        $roles->name = $request->input('name');
        $roles->user_id = Auth::id();
       
        $roles->update();
        
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
