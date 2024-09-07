<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
       $products = Product::all();
       $categories = Category::all();
       $stocks = Stock::all();
       $users = User::all();
       $qty_products = $products->sum('quantity');

        return view('home', [
            'qty_products'=>$qty_products,
            'categories'=>$categories,
            'stocks'=>$stocks,
            'users'=>$users
        ]);
    }
}
