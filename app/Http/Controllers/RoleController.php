<?php

namespace App\Http\Controllers;

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
        return view('page.roles.insert');
    }

    public function InsertData(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            // Other validations
        ], [
            'name.required' => 'Please enter name.',
            // Custom messages for other fields
        ]); 

        $roles = new Role();
        $roles->name = $request->input('name');
        $roles->user_id = Auth::id();

        $roles->save();
        return redirect()->route('role')->with('message', 'Role Inserted Successfully');
    }

    // update 
    public function Update($id) {
        $roles = Role::find($id);
        return view('page.roles.edit', [
            'roles' => $roles, 
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
