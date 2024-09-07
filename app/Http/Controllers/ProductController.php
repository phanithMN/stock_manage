<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Support\Facades\DB;
use App\Models\UnitOfMeasure;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function Product(Request $request) {
        $status = Status::all();
        $categories = Category::all();
        $search_value = $request->query("search");
        $rowLength = $request->query('row_length', 10);
        $products = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id') 
            ->join('unit_of_measure', 'products.uom_id', '=', 'unit_of_measure.id') 
            ->select('products.*', 'categories.name as category_name', 'unit_of_measure.unit as uom_unit')
            ->where('products.name', 'like', '%'.$request->input('search').'%')
            ->where('categories.name', 'like', '%'.$request->query("category").'%')
            ->paginate($rowLength);

        return view('page.products.index', [
            'products'=>$products, 
            'search_value'=>$search_value,
            'status'=>$status,
            'categories'=>$categories
        ]);
    }

    public function Insert() {
        $categories = Category::all();
        $unit_of_measures = UnitOfMeasure::all();
        $status = Status::all();
        return view('page.products.insert', 
        [
            'categories'=>$categories,
            'unit_of_measures'=>$unit_of_measures,
            'status'=>$status
        ]);
    }

    public function InsertData(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'status_id' => 'required|string|max:255',
            'quantity' => 'required|string|max:255',
            'category_id' => 'required|string|max:255',
            'price' => 'required|string|max:255',
            'cost_price' => 'required|string|max:255',
            'uom_id' => 'required|string|max:255',
            'image' => 'required|string|max:255',
            // Other validations
        ], [
            'name.required' => 'Please enter name.',
            'status_id.required' => 'Please select status.',
            'category_id.required' => 'Please select category.',
            'price.required' => 'Please enter price.',
            'cost_price.required' => 'Please enter cost price.',
            'quantity.required' => 'Please enter quantity.',
            'uom_id.required' => 'Please select uom.',
            'image.required' => 'Please enter image.',
            // Custom messages for other fields
        ]);

        $products = new Product();
        $products->name = $request->input('name');
        $products->quantity = $request->input('quantity');
        $products->description = $request->input('description');
        $products->category_id = $request->input('category_id');
        $products->uom_id = $request->input('uom_id');
        $products->price = $request->input('price');
        $products->cost_price = $request->input('cost_price');
        if($request->hasFile('image'))
        {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); 
            $filename = time().'.'.$extension;
            $file->move('uploads/products', $filename);
            $products->image = $filename;
        }
        $products->save();
        return redirect()->route('product')->with('message', 'Product Inserted Successfully');
    }

    // update 
    public function Update($id) {
        $product = Product::find($id);
        $categories = Category::all();
        $unit_of_measures = UnitOfMeasure::all();
        $status = Status::all();
        return view('page.products.edit', [
            'product' => $product, 
            'categories'=>$categories,
            'unit_of_measures'=>$unit_of_measures,
            'status'=>$status
        ]);
    }

    public function DataUpdate(Request $request, $id) {
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|string|max:255',
            'category_id' => 'required|string|max:255',
            'price' => 'required|string|max:255',
            'cost_price' => 'required|string|max:255',
            'uom_id' => 'required|string|max:255',
            // Other validations
        ], [
            'name.required' => 'Please enter name.',
            'category_id.required' => 'Please select category.',
            'price.required' => 'Please enter price.',
            'cost_price.required' => 'Please enter cost price.',
            'quantity.required' => 'Please enter quantity.',
            'uom_id.required' => 'Please select uom.',
            // Custom messages for other fields
        ]);
        
        $products = Product::find($id);
        $products->name = $request->input('name');
        $products->quantity = $request->input('quantity');
        $products->description = $request->input('description');
        $products->category_id = $request->input('category_id');
        $products->uom_id = $request->input('uom_id');
        $products->price = $request->input('price');
        $products->cost_price = $request->input('cost_price');
        if($request->hasFile('image'))
        {
            $destination = 'uploads/products'. $products->image;
            if(Product::exists($destination))
            {
                Product::destroy($destination);
            }
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); 
            $filename = time().'.'.$extension;
            $file->move('uploads/products', $filename);
            $products->image = $filename;
            
        }
        $products->update();
        
        return redirect()->route('product')->with('message','Product Updated Successfully');
    }

    // delete 
    public function Delete(Request $request, $id){
        try {
            Product::destroy($request->id);
            return redirect()->route('product')->with('message','Delete Successfully');
        } catch(\Exception $e) {
            report($e);
        }
    }

    
}
