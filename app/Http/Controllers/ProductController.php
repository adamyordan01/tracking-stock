<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductStockLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $adminId = Auth::user()->id;
        // dd($adminId);
        $products = Product::orderby('created_at', 'DESC')->paginate(10);
        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'category_id' => 'required',
            'product_code' => 'required',
            'product_name' => 'required',
            'stock' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        if ($request->act == "add") {
            $product = new Product;
            $product->category_id = $request->category_id;
            $product->product_code = $request->product_code;
            $product->product_name = $request->product_name;
            $product->stock = $request->stock;
            $product->price = $request->price;
            $product->save();

            $log = new ProductStockLog;
            $log->product_id = $product->id;
            $log->stock = $product->stock;
            $log->description = 'Init';
            $log->user_id = Auth::id();
            $log->save();
        }

        return redirect()->route('product.index')->with(['success' => 'Product has been added.']);
    }

    public function save(Request $request, $id)
    {
        $this->validate($request, [
            'category_id' => 'required',
            'product_code' => 'required',
            'product_name' => 'required',
            'stock' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        if ($request->act == "add") {
            $product = new Product;
            $product->category_id = $request->category_id;
            $product->product_code = $request->product_code;
            $product->product_name = $request->product_name;
            $product->stock = $request->stock;
            $product->price = $request->price;
            $product->save();

            $log = new ProductStockLog;
            $log->product_id = $product->id;
            $log->stock = $product->stock;
            $log->description = 'Init';
            $log->user_id = Auth::id();
            $log->save();
        } elseif ($request->act =="edit") {
            $product = new Product;

            $oldRecord = Product::find($id);
            
            if ($oldRecord->stock == $request->stock) {
                $product = Product::find($id);
                $product->update([
                    'category_id' => $request->category_id,
                    'product_code' => $request->product_code,
                    'product_name' => $request->product_name,
                    'stock' => $request->stock,
                    'price' => $request->price,
                ]);

                return redirect()->route('product.index')->with('success', 'Product has been updated.');
            } elseif ($oldRecord->stock < $request->stock) {
                $product = Product::find($id);

                // Insert data product stock log dahulu baru update data product
                $log = new ProductStockLog;
                $log->product_id = $product->id;
                $log->stock = abs($product->stock - $request->stock);
                $log->description = 'Update';
                $log->user_id = Auth::id();
                $log->save();

                // setelah data product stock log ter insert selanjutnya adalah update data product
                $product->update([
                    'category_id' => $request->category_id,
                    'product_code' => $request->product_code,
                    'product_name' => $request->product_name,
                    'stock' => $request->stock,
                    'price' => $request->price,
                ]);

                return redirect()->route('product.index')->with('success', 'Product has been updated.');
            } elseif ($oldRecord->stock > $request->stock) {
                $product = Product::find($id);

                // Insert data product stock log dahulu baru update data product
                $log = new ProductStockLog;
                $log->product_id = $product->id;
                $log->stock = abs($request->stock - $product->stock);
                $log->description = 'Update';
                $log->user_id = Auth::id();
                $log->save();

                // setelah data product stock log ter insert selanjutnya adalah update data product
                $product->update([
                    'category_id' => $request->category_id,
                    'product_code' => $request->product_code,
                    'product_name' => $request->product_name,
                    'stock' => $request->stock,
                    'price' => $request->price,
                ]);
                return redirect()->route('product.index')->with('success', 'Product has been updated.');
            }
            return redirect()->route('product.index')->with('success', 'Product has been updated.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

        $stockLog = ProductStockLog::with(['user', 'product'])->where('product_id', $product->id)->get();

        return view('products.show', [
            'product' => $product,
            'stockLog' => $stockLog,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        $categories = Category::get();

        return view('products.edit', [
            'product' => $product,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
