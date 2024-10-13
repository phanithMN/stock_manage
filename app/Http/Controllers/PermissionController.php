<?php

namespace App\Http\Controllers;

use App\Models\PermissionKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Permission;

class PermissionController extends Controller
{
    public function Permission() {
        $permissions = Permission::all();
        return view('page.permissions.index', ['permissions'=>$permissions]);
    }

    public function Insert() {
        $permission_keys = PermissionKey::$permission_key;
        return view('page.permissions.insert', ['permission_keys'=>$permission_keys]);
    }

    public function InsertData(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'permission_key' => 'required|string|max:255',
            // Other validations
        ], [
            'name.required' => 'Please enter name.',
            'permission_key.required' => 'Please select key.',
            // Custom messages for other fields
        ]);
        
        $permission = new Permission();
        $permission->name = $request->input('name');
        $permission->permission_key = $request->input('permission_key');
        $permission->user_id = Auth::id();
       

        $permission->save();
        return redirect()->route('permission')->with('message', 'Permission Inserted Successfully');
    }

    // update 
    public function Update($id) {
        $permission_keys = PermissionKey::$permission_key;
        $permission = Permission::find($id);
        return view('page.permissions.edit', [
            'permission' => $permission, 
            'permission_keys' => $permission_keys
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
        
        $permission = Permission::find($id);
        $permission->name = $request->input('name');
        $permission->permission_key = $request->input('permission_key');
        $permission->user_id = Auth::id();

        $permission->update();
        
        return redirect()->route('permission')->with('message','Permission Updated Successfully');
    }

    // delete 
    public function Delete(Request $request, $id){
        try {
            Permission::destroy($request->id);
            return redirect()->route('permission')->with('message','Delete Successfully');
        } catch(\Exception $e) {
            report($e);
        }
    }

    
}
