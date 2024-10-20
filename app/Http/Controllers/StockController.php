<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Status;
use Auth;
use Illuminate\Http\Request;
use App\Models\Stock;

class StockController extends Controller
{
    public function Stock(Request $request) {
        $status = Status::all();
        $rowLength = $request->query('row_length', 10);
        $stocks = Stock::leftJoin('products', 'products.id', '=', 'stocks.product_id')
        ->leftJoin('users', 'users.id', '=', 'stocks.user_id')
        ->select('stocks.*', 'products.name as product_name', 'users.name as user_name')
        ->where(function($query) use ($request) {
            $query->where('products.name', 'like', '%'.$request->query("search").'%')
                  ->orWhereNull('products.name');
        })
        ->where(function($query) use ($request) {
            $query->where('stocks.status', 'like', '%'.$request->query("status_name").'%')
                  ->orWhereNull('stocks.status');
        })
        ->when($request->has('start_date') && $request->has('end_date'), function ($query) use ($request) {
            $query->whereBetween('stocks.date', [$request->query('start_date'), $request->query('end_date')]);
        })
        ->orderBy('stocks.id', 'asc')
        ->paginate($rowLength);
        
        return view('page.stocks.index', [
            'stocks'=>$stocks, 
            'status' => $status,
        ]);
    }

    public function Insert() {
        $products = Product::all();
        return view('page.stocks.insert', 
        [
            'products'=>$products,
        ]);
    }

    public function InsertData(Request $request) {

        $sku = $this->generateSku($request->input('product_id'));
        $stock = new Stock();
        $stock->user_id = Auth::id();
        $stock->reference_no = $request->input('reference_no');
        $stock->quantity = $request->input('quantity');
        $stock->price = $request->input('price');
        $stock->product_id = $request->input('product_id');
        $stock->date = $request->input('date');
        $stock->sku = $sku;
        $stock->status = $request->input('status');
        $stock->amount = $request->input('quantity') * $request->input('price');

        $stock->save();

        $product = Product::find($stock->product_id); 
        if ($product) {
            $product->quantity += $stock->quantity; 
            $product->save();
        }

        return redirect()->route('stock')->with('message', 'Stock Inserted Successfully');
    }

    // update 
    public function Update($id) {
        $products = Product::all();
        $status = Status::all();
        $stock = Stock::find($id);

        return view('page.stocks.edit', [
            'stock' => $stock, 
            'products'=>$products,
            'status'=>$status
        ]);
    }

    public function DataUpdate(Request $request, $id)
    {
        // Find the stock item
        $stock = Stock::find($id);
    
        // Update the stock item with new values
        $stock->reference_no = $request->input('reference_no');
        $stock->quantity = $request->input('quantity');
        $stock->price = $request->input('price');
        $stock->product_id = $request->input('product_id');
        $stock->status = $request->input('status');
        $stock->date = $request->input('date');
        $stock->amount = $request->input('quantity') * $request->input('price');
        $stock->update(); // Use save() instead of update()
    
        // Update quantity on product
        $product = Product::find($stock->product_id);
        
        if ($product) {
            // Apply new quantity based on the updated status
            if ($request->input('status') == 'In') {
                // Increase product quantity
                $product->quantity += $request->input('quantity');
            } elseif ($request->input('status') == 'Out') {
                // Decrease product quantity
                $product->quantity -= $request->input('quantity');
            }
    
            // Ensure product quantity doesn't go negative
            $product->quantity = max($product->quantity, 0);
            $product->update();
        }
    
        return redirect()->route('stock')->with('message', 'Stock Updated Successfully');
    }

    // delete 
    public function Delete(Request $request, $id){
        try {
            Stock::destroy($request->id);
            return redirect()->route('stock')->with('message','Delete Successfully');
        } catch(\Exception $e) {
            report($e);
        }
    }

    public function show($id)
    {
        $stock = Stock::findOrFail($id);

        return response()->json($stock); // Return as JSON for AJAX
    }

    private function generateSku($productName)
    {
        // Get the initials of the product name
        $initials = strtoupper(substr($productName, 0, 3));
        // Generate a random number
        $randomNumber = rand(100, 999);
        // Get current timestamp
        $timestamp = now()->format('YmdHis');
        // Concatenate to form the SKU
        return $initials . '-' . $randomNumber . '-' . $timestamp;
    }

    // insert stock out 

    
}
