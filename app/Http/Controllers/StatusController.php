<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;

class StatusController extends Controller
{
    public function Status(Request $request) {
        $status = Status::all();
        return view('page.status.index', ['status'=>$status]);
    }

    public function Insert() {
        return view('page.status.insert');
    }

    public function InsertData(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            // Other validations
        ], [
            'name.required' => 'Please enter name.',
            // Custom messages for other fields
        ]);

        $status = new Status();
        $status->name = $request->input("name");
        $status->save();

        return redirect()->route('status')->with('message', 'Status Inserted Successfully');
    }

    // update 
    public function Update($id) {

        $status = Status::find($id);

        return view('page.status.edit', ['status' => $status]);
    }

    public function DataUpdate(Request $request, $id) {
        $request->validate([
            'name' => 'required|string|max:255',
            // Other validations
        ], [
            'name.required' => 'Please enter name.',
            // Custom messages for other fields
        ]);

        $status = Status::find($id);
        $status->name = $request->input("name");
        $status->update();
        
        return redirect()->route('status')->with('message','Status Updated Successfully');
    }

    // delete 
    public function Delete(Request $request, $id){
        try {   
            Status::destroy($request->id);
            return redirect()->route('status');
        } catch(\Exception $e) {
            report($e);
        }
    }
}
