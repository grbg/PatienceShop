<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Image;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Size;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\User; 

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $products = Product::all();
        $images = Image::all();
        $categories = Category::all();

        if (request()->ajax()) {
            return response()->json([
                'products' => $products,
                'images' => $images
            ]);
        }

        return view('home', compact('products', 'images', 'categories'));
    }

    public function store() {
        $products = Product::all();
        $images = Image::all();
        $categories = Category::all();

        if (request()->ajax()) {
            return response()->json([
                'products' => $products,
                'images' => $images
            ]);
        }

        $carts = app()->call('App\Http\Controllers\CartController@index');

        $sizes = app()->call('App\Http\Controllers\SizeController@getAllSizes');

        $total_price = app()->call('App\Http\Controllers\CartController@getUserCartTotalPrice');

        return view('shop', compact('products', 'images', 'categories', 'carts', 'sizes','total_price'));
    }

    public function getProductsByIds($ids)  {
        return Product::whereIn('id', $ids)->get();
    }

    public function getProductById($id) {
        return Product::find($id);
    }

    public function indexProduct()  {
        $products = Product::all();
        $images = Image::whereIn('product_id', $products->pluck('id'))->get();
        $categories = Category::all();
        $product_category = DB::table('category_product')->get();

        if (request()->ajax()) {
            return response()->json([
                'products' => $products,
                'images' => $images
            ]);
        }

        // foreach ($products as $product) {
        //     $product_categories = DB::table('category_product')
        //         ->join('categories', 'category_product.category_id', '=', 'categories.id')
        //         ->where('category_product.product_id', $product->id)
        //         ->select('categories.category_name', 'categories.id')
        //         ->get();

        //     $product->categories = $product_categories;
        // }

        return view('manager', compact('products', 'images', 'categories', 'product_category'));
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

    public function getAllProducts(Request $request) {
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

    public function filterProducts(Request $request) {
        $category_id = $request->input('category_id');
        $section = $request->input('section');

        if ($section == 'man') {
            $query = Product::where('category', 'man');
        } elseif ($section == 'woman') {
            $query = Product::where('category', 'woman');
        } elseif ($section == 'all') {
            $query = Product::all();
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

    public function filterByCategory($gender, $category) {
        // Получить ID категории по имени (если нужно)
        $categoryModel = Category::where('id', $category)->first();
        
        if (!$categoryModel) {
            return response()->json(['products' => [], 'images' => []]);
        }
        if ($gender === 'all') {
            $products = Product::whereHas('categories', function($query) use ($categoryModel) {
               $query->where('category_id', $categoryModel->id);
               })
               ->get();

            $images = Image::whereIn('product_id', $products->pluck('id'))->get();

            return response()->json(['products' => $products, 'images' => $images]);
        }
    
        $products = Product::where('gender', $gender)
           ->whereHas('categories', function($query) use ($categoryModel) {
           $query->where('category_id', $categoryModel->id);
           })
           ->get();

        // Получение изображений для продуктов
        $images = Image::whereIn('product_id', $products->pluck('id'))->get();

        $categories = Category::all();

        
        $product_categories = DB::table('category_product')->get();

        return response()->json([
            'products' => $products, 
            'images' => $images,
            'categories' => $categories,
            'product_categories' => $product_categories
        ]);
    }

    public function updateProduct(Request $request) {
         $validatedData = $request->validate([
             'product_id' => 'required|exists:products,id',
             'product_name' => 'required|string|max:255',
             'product_desc' => 'nullable|string',
             'product_price' => 'required',
             'gender' => 'required|in:man,woman',
             'categories' => 'array|nullable',
         ]);

        $product = Product::find($request->product_id);
        
        $product->product_name = $request->product_name;
        $product->description = $request->product_desc;
        $product->price = $request->product_price;
        $product->gender = $request->gender;
        $product->save();
        
        if (isset($request->categories)) {
            $product->categories()->sync($request->categories);
        }

        if ($request->hasFile('product_image')) {
            $imagePath = $request->file('product_image')->store('assets/products', 'public');
            
            $image = Image::updateOrCreate(
                ['product_id' => $product->id],
                ['url' => $imagePath]
            );

            $imageUrl = Storage::url($imagePath);
        } else {
            $image = Image::where('product_id', $product->id)->first();
            $imagePath = $image ? $image->url : null;
        }

        return response()->json([
            'success' => true,
            'imageUrl' => Storage::url($imagePath),
        ]);
    }

    public function addProduct(Request $request) {
        // Валидация данных
        $validatedData = $request->validate([
            'insert_name' => 'required|string|max:255',
            'product_desc' => 'nullable|string',
            'insert_price' => 'required',
            'gender' => 'required|in:man,woman',
            'categories' => 'array|nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Создание нового продукта
        $product = new Product();
        $product->product_name = $validatedData['insert_name'];
        $product->description = $validatedData['product_desc'];
        $product->price = $validatedData['insert_price'];
        $product->gender = $validatedData['gender'];
        $product->save();

        // Обработка изображения, если оно загружено
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('assets/products', 'public');

            $image = new Image();
            $image->product_id = $product->id;
            $image->url = $imagePath;
            $image->save();
        }

        // Обновление категорий продукта
        if (isset($request->categories)) {
            $product->categories()->sync($request->categories);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product added successfully!',
        ]);
    }

    public function destroy($id) {
        $product = Product::find($id);

        if ($product) {
            $product->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Продукт не найден']);
        }
    }

    public function show($id)   {
        $product = Product::findOrFail($id);
        $products = Product::all();
        $images = Image::all();
        $sizes = Size::all();
        
        $productCategories = DB::table('category_product')
            ->where('product_id', $id)
            ->pluck('category_id');
            
        $categories = Category::whereIn('id', $productCategories)->first();

        $total_price = app()->call('App\Http\Controllers\CartController@getUserCartTotalPrice');

        $carts = app()->call('App\Http\Controllers\CartController@index');
        
        return view('product', compact('product','products', 'images', 'sizes', 'categories', 'total_price', 'carts'));
    }
}


