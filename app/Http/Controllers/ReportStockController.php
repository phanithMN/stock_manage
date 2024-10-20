<?php

namespace App\Http\Controllers;

use App\Exports\ExportStock;
use App\Imports\StockImportClass;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Models\Category;
use App\Models\ReportStock;
use App\Models\Status;
use Illuminate\Http\Request;
use App\Models\Stock;

class ReportStockController extends Controller
{
    public function ReportStock(Request $request) {
        $currentDate = Carbon::now()->toDateString(); 
        $rowLength = $request->query('row_length', 10);
        $search_value = $request->query("search");
        $date = $request->query('date', $currentDate);
        $categories = Category::all();
        $status = Status::all();

        $rowLength = $request->query('row_length', 10);
       


        if ($request->has('start_date') && $request->has('end_date')) {
            $report_stocks = Stock::whereBetween('stocks.created_at', [
                $request->input('start_date'), 
                $request->input('end_date')
            ])
            ->where(function($query) use ($request) {
                $query->where('products.name', 'like', '%'.$request->query("search").'%')->orWhereNull('products.name');
            })
            ->leftJoin('products', 'products.id', '=', 'stocks.product_id') 
            ->select('stocks.*', 'products.name as product_name')
            ->paginate($rowLength);
        } else {
            $report_stocks = Stock::leftJoin('products', 'products.id', '=', 'stocks.product_id') 
            ->select('stocks.*', 'products.name as product_name')
            ->where(function($query) use ($request) {
                $query->where('products.name', 'like', '%'.$request->query("search").'%')->orWhereNull('products.name');
            })
            ->whereDate('stocks.created_at', Carbon::today()) 
            ->paginate($rowLength);
    
        }
        return view('page.report-stock.index', [
            'report_stocks'=>$report_stocks,
            'categories'=>$categories,
            'status'=>$status,
            'search_value'=>$search_value,
            'date'=>$date
        ]);
    }


    public function ExportCSV()
    {
        $filename = 'stock.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () {
            $handle = fopen('php://output', 'w');

            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            // Add CSV headers
            fputcsv($handle, [
                'ID',
                'Date',
                'Name',
                'Status',
                'Price',
                'Quantity',
                'Total',
            ]);

            Stock::with(['category', 'status', 'product'])->chunk(25, function ($stocks) use ($handle) {
                foreach ($stocks as $stock) {
                    $data = [
                        isset($stock->id) ? $stock->id : '',
                        isset($stock->created_at) ? $stock->created_at->format('Y-m-d') : '',
                        isset($stock->product->name) ? $stock->product->name : '', 
                        isset($stock->status) ? $stock->status : '',    
                        isset($stock->price) ? number_format($stock->price, 2).'៛' : '0',  
                        isset($stock->quantity) ? $stock->quantity : '0',  
                        isset($stock->quantity) ? number_format($stock->quantity * $stock->price, 2).'៛' : '0', 
                    ];

                    fputcsv($handle, $data);
                }
            });

            // Close CSV file handle
            fclose($handle);
        }, 200, $headers);
    }


    public function ImportCSV (Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        Excel::import(new StockImportClass, $request->file('file'));

        return back()->with('success', 'All good!');
    }
}
