<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Status;
use Illuminate\Http\Request;
use App\Models\Stock;

class StockController extends Controller
{
    public function Stock(Request $request) {
        $status = Status::all();
        $rowLength = $request->query('row_length', 10);
        $stocks = Stock::join('products', 'stocks.product_id', '=', 'products.id') 
        ->join('status', 'stocks.status_id', '=' , 'status.id')
        ->select('stocks.*', 'products.name as product_name', 'status.name as status_name')
        ->where('stocks.status', 'like', '%'.$request->query("status_name").'%')
        ->where('products.name', 'like', '%'.$request->query("search").'%')
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
        $stock->quantity = $request->input('quantity');
        $stock->price = $request->input('price');
        $stock->product_id = $request->input('product_id');
        $stock->sku = $sku;
        $stock->status_id = $request->input('status_id');

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
        $stock = Stock::find($id);

        // Update stock data (except quantity)
        $stock->price = $request->input('price');
        $stock->product_id = $request->input('product_id');
        $stock->status_id = $request->input('status_id');


        // Find the related product
        $product = Product::find($stock->product_id);

        $product = Product::find($stock->product_id); 
        if ($product) {
            $product->quantity += $stock->quantity; 
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
