<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
class ProductController extends Controller
{
    public function store(Request $request)
    {
        $product = new Product();
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        // Set other attributes as needed
        $product->save();

        // Optionally, you can return a response or redirect to a success page
        return redirect('/products')->with('success', 'Product added successfully');
    }
    public function list ()
    {
        $productslist=Product::all();
        return view("listproducts",['productslist'=>$productslist]);
    }
}
