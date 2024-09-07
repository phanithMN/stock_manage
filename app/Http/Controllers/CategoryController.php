<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function Category(Request $request) {
        $search_value = $request->query("search");
        $rowLength = $request->query('row_length', 10);
        $categories = Category::where('name', 'like', '%'.$request->input('search').'%')->paginate($rowLength);
        return view('page.categorys.index', ['categories'=>$categories, 'search_value'=>$search_value]);
    }

    public function Insert(Request $request) {
        return view('page.categorys.insert');
    }

    public function InsertData(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            // Other validations
        ], [
            'name.required' => 'Please enter name.',
            // Custom messages for other fields
        ]);
        $categories = new Category();
        $categories->name = $request->input('name');

        $categories->save();
        return redirect()->route('category')->with('message', 'Product Inserted Successfully');
    }

    // update 
    public function Update($id) {
        $categories = Category::find($id);
        return view('page.categorys.edit', [
            'categories' => $categories, 
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
        
        $category = Category::find($id);
        $category->name = $request->input('name');
       
        $category->update();
        
        return redirect()->route('category')->with('message','Product Updated Successfully');
    }

    // delete 
    public function Delete(Request $request, $id){
        try {
            Category::destroy($request->id);
            return redirect()->route('category')->with('message','Delete Successfully');
        } catch(\Exception $e) {
            report($e);
        }
    }

    
}
