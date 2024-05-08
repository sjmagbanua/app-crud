<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request){
        $products = Product::all();
        return view('products.index', [ 'products' => $products]);
    }

    public function create(){
        $products = Product::all();

        return view('products.create', [ 'products' => $products]);
    }

    public function store(Request $request){
        $data = $request->validate([
            'name' => 'required',
            'qty' => 'required',
            'price' => 'required|decimal:0,2',
            'description' => 'nullable',
        ]);
        $newProduct = Product::create($data);
    
        return redirect()->route('product.index');
    }
    

    
    public function edit($id)
    {
        $product = Product::find($id); // Assuming you have a Product model
        return response()->json($product);
    }
}
