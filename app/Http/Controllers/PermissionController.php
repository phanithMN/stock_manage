<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Permission;

class PermissionController extends Controller
{
    public function Permission(Request $request) {
        $permissions = Permission::all();
        return view('page.permissions.index', ['permissions'=>$permissions]);
    }

    public function Insert() {
        return view('page.permissions.insert');
    }

    public function InsertData(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            // Other validations
        ], [
            'name.required' => 'Please enter name.',
            // Custom messages for other fields
        ]);
        
        $permission = new Permission();
        $permission->name = $request->input('name');
        $permission->user_id = Auth::id();
       

        $permission->save();
        return redirect()->route('permission')->with('message', 'Product Inserted Successfully');
    }

    // update 
    public function Update($id) {
        $permission = Permission::find($id);
        return view('page.permissions.edit', [
            'permission' => $permission, 
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
        $permission->user_id = Auth::id();

        $permission->update();
        
        return redirect()->route('permission')->with('message','Product Updated Successfully');
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
