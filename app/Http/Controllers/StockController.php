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
        ->select('stocks.*', 'products.name as product_name')
        ->where(function($query) use ($request) {
            $query->where('products.name', 'like', '%'.$request->query("search").'%')
                  ->orWhereNull('products.name');
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
    
        // Store the original quantity and status
        $originalQuantity = $stock->quantity;
        $originalStatus = $stock->status;
    
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
            // Determine how to adjust the quantity based on status
            if ($originalStatus == '1' || $originalStatus == '2') {
                // Calculate the quantity change based on the original status
                if ($originalStatus == '1') {
                    $product->quantity += $originalQuantity;
                } elseif ($originalStatus == '2') {
                    $product->quantity -= $originalQuantity;
                }
            }
    
            // Apply new quantity based on the updated status
            if ($request->input('status') == '1') {
                // Increase product quantity
                $product->quantity += $request->input('quantity');
            } elseif ($request->input('status') == '2') {
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

    
}
