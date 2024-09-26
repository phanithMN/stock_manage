<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Status;
use App\Models\UnitOfMeasure;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function Product(Request $request) {
        $categories = Category::all();
        $search_value = $request->query("search");
        $rowLength = $request->query('row_length', 10);
        $products = Product::leftJoin('categories', 'products.category_id', '=', 'categories.id') 
            ->leftJoin('unit_of_measure', 'products.uom_id', '=', 'unit_of_measure.id') 
            ->select('products.*', 'categories.name as category_name', 'unit_of_measure.unit as uom_unit')
            ->where('products.name', 'like', '%'.$request->input('search').'%')
            ->where(function($query) use ($request) {
                $query->where('categories.name', 'like', '%'.$request->query("category").'%')->orWhereNull('categories.name');
            })
            ->paginate($rowLength);


        return view('page.products.index', [
            'products'=>$products, 
            'search_value'=>$search_value,
            'categories'=>$categories
        ]);
    }

    public function Insert() {
        $permissions = Permission::join('role_permissions', 'role_permissions.permission_id', '=', 'permissions.id')
        ->select('permissions.name')
        ->where('role_permissions.role_id', Auth::user()->role)
        ->where('permissions.name', 'Add New Product')
        ->get();
        if(count($permissions) == 0) {
            return redirect()->route('product')->with('error', 'You have no permission');
        }

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
        $permissions = Permission::join('role_permissions', 'role_permissions.permission_id', '=', 'permissions.id')
        ->select('permissions.name')
        ->where('role_permissions.role_id', Auth::user()->role)
        ->where('permissions.name', 'Update Product')
        ->get();
        if(count($permissions) == 0) {
            return redirect()->route('product')->with('error', 'You have no permission');
        }

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
        $permissions = Permission::join('role_permissions', 'role_permissions.permission_id', '=', 'permissions.id')
        ->select('permissions.name')
        ->where('role_permissions.role_id', Auth::user()->role)
        ->where('permissions.name', 'Delete Product')
        ->get();

        if(count($permissions) == 0) {
            return redirect()->route('product')->with('error', 'You have no permission');
        }
        
        try {
            Product::destroy($request->id);
            return redirect()->route('product')->with('message','Delete Successfully');
        } catch(\Exception $e) {
            report($e);
        }
    }

    
}
