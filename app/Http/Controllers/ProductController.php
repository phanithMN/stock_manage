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
