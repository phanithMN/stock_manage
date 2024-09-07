<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Status;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportProductController extends Controller
{
    public function ReportProduct(Request $request) {
        $categories = Category::all();
        $status  = Status::all();
        $currentDate = Carbon::now()->toDateString(); 
        $rowLength = $request->query('row_length', 10);
        $search_value = $request->query("search");
        $date = $request->query('date', $currentDate);
        $categories = Category::all();
        $status = Status::all();

        $products = Product::join('categories', 'products.category_id', '=', 'categories.id') 
        ->join('status', 'products.status_id', '=', 'status.id') 
        ->join('unit_of_measure', 'products.uom_id', '=', 'unit_of_measure.id') 
        ->select('products.*', 'categories.name as category_name', 'status.name as status_name', 'unit_of_measure.unit as uom_name')
        ->where('products.name', 'like', '%'.$request->input('search').'%')
        ->where('status.name', 'like', '%'.$request->query("status_name").'%')
        ->where('categories.name', 'like', '%'.$request->query("category").'%')
        ->whereDate('products.created_at', $date)
        ->paginate($rowLength);

        return view('page.report-product.index',
        [
            'categories'=>$categories,
            'status' => $status,
            'search_value' => $search_value,
            'products' => $products,
            'date' => $date,
        ]);
    }

    public function ExportCSV()
    {
        $filename = 'products.csv';
    
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];
    
        return response()->stream(function () {
            $handle = fopen('php://output', 'w');
    
            // Add CSV headers
            fputcsv($handle, [
                'ID',
                'Name',
                'Quanity',
                'Price',
                'Category',
                'Status',
                'UOM',
                'Created At',
            ]);
    
            Product::with(['category', 'status', 'uom'])->chunk(25, function ($products) use ($handle) {
                foreach ($products as $product) {
                    // Extract data from each product along with the joined category and status.
                    $data = [
                        isset($product->id) ? $product->id : '',
                        isset($product->name) ? $product->name : '',
                        isset($product->quantity) ? $product->quantity : '',
                        isset($product->price) ? $product->price : '',
                        isset($product->category->name) ? $product->category->name : '', // Access category name
                        isset($product->status->name) ? $product->status->name : '',     // Access status name
                        isset($product->uom->unit) ? $product->uom->unit : '',     // Access status name
                        isset($product->created_at) ? $product->created_at->format('Y-m-d') : '',
                    ];
            
                    // Write data to a CSV file.
                    fputcsv($handle, $data);
                }
            });
    
            // Close CSV file handle
            fclose($handle);
        }, 200, $headers);
    }
}
