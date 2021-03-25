<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ProductStockLog;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $product = Product::count();
        $category = Category::count();
        $user = User::count();
        $stockLog = ProductStockLog::count();
        // dd($product);
        return view('dashboard.index', [
            'product' => $product,
            'category' => $category,
            'user' => $user,
            'stockLog' => $stockLog,
        ]);
    }
}
