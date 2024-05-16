<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Image;
use App\Models\Category;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        $images = Image::all();
        $categories = Category::all();

        if (request()->ajax()) {
            return response()->json([
                'products' => $products,
                'images' => $images
            ]);
        }

        return view('shop', compact('products', 'images', 'categories'));
    }

    public function getManSection(Request $request) {
        $products = Product::where('gender', 'man')->get();
        $images = Image::whereIn('product_id', $products->pluck('id'))->get();
        $categories = Category::all();

        return response()->json([
                'products' => $products,
                'images' => $images
        ]);
    }

    public function getWomanSection(Request $request) {
        $products = Product::where('gender', 'woman')->get();
        $images = Image::whereIn('product_id', $products->pluck('id'))->get();
        $categories = Category::all();

        return response()->json([
                'products' => $products,
                'images' => $images
        ]);
    }

    public function getAllProducts(Request $request)
    {
        $products = Product::all();
        $images = Image::whereIn('product_id', $products->pluck('id'))->get();

        if ($request->ajax()) {
            return response()->json([
                'products' => $products,
                'images' => $images
            ]);
        }
        $categories = Category::all();
        return view('shop', compact('products', 'images', 'categories'));
    }

    public function filterProducts(Request $request)
    {
        $category_id = $request->input('category_id');
        $section = $request->input('section');

        if ($section == 'man') {
            $query = Product::where('category', 'man');
        } elseif ($section == 'woman') {
            $query = Product::where('category', 'woman');
        }

        if ($category_id) {
            $query->whereHas('categories', function($q) use ($category_id) {
                $q->where('id', $category_id);
            });
        }

        $products = $query->get();
        $images = Image::whereIn('product_id', $products->pluck('id'))->get();

        return response()->json([
            'products' => $products,
            'images' => $images
        ]);
    }
}


