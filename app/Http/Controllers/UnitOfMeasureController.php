<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\UnitOfMeasure;

class UnitOfMeasureController extends Controller
{
    public function UnitOfMeasure(Request $request) {
        $unit_of_measures = UnitOfMeasure::all();

        return view('page.unit-of-measure.index', ['unit_of_measures'=>$unit_of_measures]);
    }

    public function Insert() {
        return view('page.unit-of-measure.insert');
    }

    public function InsertData(Request $request) {
        $request->validate([
            'unit' => 'required|string|max:255',
            // Other validations
        ], [
            'unit.required' => 'Please enter unit.',
            // Custom messages for other fields
        ]);

        $unit_of_measures = new UnitOfMeasure();
        $unit_of_measures->unit = $request->input("unit");
       
        $unit_of_measures->save();

        return redirect()->route('unit-of-measure')->with('message', 'Unit of Measure Inserted Successfully');
    }

    // update 
    public function Update($id) {

        $unit_of_measure = UnitOfMeasure::find($id);

        return view('page.unit-of-measure.edit', ['unit_of_measure' => $unit_of_measure]);
    }

    public function DataUpdate(Request $request, $id) {
        $request->validate([
            'unit' => 'required|string|max:255',
            // Other validations
        ], [
            'unit.required' => 'Please enter unit.',
            // Custom messages for other fields
        ]);
        
        $unit_of_measure = UnitOfMeasure::find($id);
        $unit_of_measure->unit = $request->input("unit");
        
        $unit_of_measure->update();
        
        return redirect()->route('unit-of-measure')->with('message','Unit of Measure Updated Successfully');
    }

    // delete 
    public function Delete(Request $request, $id){
        try {   
            UnitOfMeasure::destroy($request->id);
            return redirect()->route('unit-of-measure');
        } catch(\Exception $e) {
            report($e);
        }
    }
}
