<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Carbon\Carbon;

class ProductController extends Controller
{
    // Display the form and the table
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->get();
        $totalValueSum = $products->sum(function($product) {
            return $product->quantity * $product->price;
        });
        return view('products.index', compact('products', 'totalValueSum'));
    }

    // Store the product
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        Product::create([
            'product_name' => $request->product_name,
            'quantity' => $request->quantity,
            'price' => $request->price,
        ]);

        return response()->json(['success' => 'Product added successfully!']);
    }

    // Save to JSON file
    private function saveToJson()
    {
        $products = Product::all();
        $jsonData = json_encode($products, JSON_PRETTY_PRINT);
        file_put_contents(storage_path('app/public/products.json'), $jsonData);
    }

    // Save to XML file
    private function saveToXml()
    {
        $products = Product::all();
        $xml = new \SimpleXMLElement('<products/>');
        foreach ($products as $product) {
            $prod = $xml->addChild('product');
            $prod->addChild('product_name', $product->product_name);
            $prod->addChild('quantity', $product->quantity);
            $prod->addChild('price', $product->price);
            $prod->addChild('created_at', $product->created_at);
            $prod->addChild('total_value', $product->quantity * $product->price);
        }
        $xml->asXML(storage_path('app/public/products.xml'));
    }
}