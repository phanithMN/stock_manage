<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Status;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportRevenueController extends Controller
{
    public function ReportRevenue (Request $request) {
        $currentDate = Carbon::now()->toDateString(); 
        $rowLength = $request->query('add_row_length', 10);
        $search_value = $request->query("search");
        $date = $request->query('date', $currentDate);
        $categories = Category::all();
        $status = Status::all();

        if ($request->has('start_date') && $request->has('end_date')) {
            $report_product = Product::whereBetween('products.created_at', [
                $request->input('start_date'), 
                $request->input('end_date')
            ])
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id') 
            ->leftJoin('unit_of_measure', 'products.uom_id', '=', 'unit_of_measure.id') 
            ->select('products.*', 'categories.name as category_name')
            ->where('products.name', 'like', '%'.$request->input('search').'%')
            ->paginate($rowLength);
        } else {
            $report_product = Product::leftJoin('categories', 'products.category_id', '=', 'categories.id') 
            ->leftJoin('stocks', 'products.id','=','stocks.product_id') 
            ->select('products.*', 'categories.name as category_name', 'stocks.price as stock_price', 'stocks.quantity as stock_quantity', 'stocks.status as status')
            ->where('products.name', 'like', '%'.$request->input('search').'%')
            ->whereDate('products.created_at', Carbon::today()) 
            ->paginate($rowLength);
    
        }
        return view('page.report-revenue.index', [
            'report_product'=>$report_product,
            'categories'=>$categories,
            'status'=>$status,
            'search_value'=>$search_value,
            'date'=>$date
        ]);
    }

    public function ExportCSV()
{
    $filename = 'products.csv';

    $headers = [
        'Content-Type' => 'text/csv; charset=UTF-8',
        'Content-Disposition' => "attachment; filename=\"$filename\"",
        'Pragma' => 'no-cache',
        'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
        'Expires' => '0',
    ];

    return response()->stream(function () {
        $handle = fopen('php://output', 'w');

        // Add BOM (Byte Order Mark) to support special characters in Excel
        fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

        // Add CSV headers
        fputcsv($handle, [
            'ID',
            'Name',
            'Quantity',
            'Price',
            'Category',
            'Status',
            'Created At',
        ]);

        // Fetch products with relations and output them in chunks to avoid memory issues
        Product::with(['category', 'status', 'uom'])->chunk(25, function ($products) use ($handle) {
            foreach ($products as $product) {
                // Extract data from each product along with the joined category, status, and UOM.
                $data = [
                    isset($product->id) ? $product->id : '',
                    isset($product->name) ? $product->name : '',
                    isset($product->quantity) ? number_format($product->quantity).' '.$product->uom->unit : '',
                    isset($product->price) ? $product->price.'៛' : '',
                    isset($product->category->name) ? $product->category->name : '', // Access category name
                    isset($product->status->name) ? $product->status->name : '',     // Access status name
                    isset($product->created_at) ? $product->created_at->format('Y-m-d') : '',
                ];

                // Write data to a CSV file, ensuring it supports all languages (UTF-8)
                fputcsv($handle, $data);
            }
        });

        // Close CSV file handle
        fclose($handle);
    }, 200, $headers);
    }

    
}
