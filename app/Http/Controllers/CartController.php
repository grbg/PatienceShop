<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Models\Image;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Category;
use App\Models\Address;

class CartController extends Controller
{
    public function index() {
        $carts = Cart::where('user_id', Auth::id())->with('product')->get();

        return $carts;
    }

    public function addProductInCart(Request $request) {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'size_id' => 'required',
            'quantity' => 'required|integer|min:1',
        ]);

        $userId = Auth::id();
        $productId = $request->input('product_id');
        $sizeId = $request->input('size_id');
        $quantity = $request->input('quantity');

        $cartItem = Cart::updateOrCreate(
            [
                'user_id' => $userId,
                'product_id' => $productId,
                'size_id' => $sizeId
            ],
            [
                'quantity' => \DB::raw('quantity + ' . $quantity)
            ]
        );

        $cart = $this->getCart($userId);

        return response()->json(['success' => true, 'cart' => $cart]);
    }

    private function getCart($userId)   {
        $items = Cart::with('product', 'size')
                    ->where('user_id', $userId)
                    ->get();

        $totalPrice = $items->sum(function ($item) {
            $price = (float) str_replace(' ', '', $item->product->price);
            return $price * $item->quantity;
        });

        $cartItems = $items->map(function ($item) {
            $image = Image::where('product_id', $item->product_id)->first();
            $imageUrl = $image ? asset('storage/' . $image->url) : null;
            $product = app()->call('App\Http\Controllers\ProductController@getProductById', ['id' => $item->product_id]);
            $sizes = app()->call('App\Http\Controllers\SizeController@getAllSizes');
            

            return [
                'product_id' => $item->product_id,
                'product_name' => $product->product_name,
                'size_name' => $item->size['size'],
                'quantity' => $item->quantity,
                'price' => $product->price,
                'image_url' => $imageUrl
            ];
        });

        return [
            'items' => $cartItems,
            'total_price' => $totalPrice,
        ];
    }

    public function getUserCartTotalPrice() {
        $userId = Auth::id(); 

        $cartItems = Cart::with('product')
            ->where('user_id', $userId)
            ->get();

        $total_price = $cartItems->sum(function ($cartItem) {
            $price = (float) str_replace(' ', '', $cartItem->product->price);
            return $price * $cartItem->quantity;    
        });

        return $total_price;
    }

    public function showUserCart() {
        $user = Auth::user();

        $cartItems = Cart::where('user_id', $user->id)->get();

        $address = Address::where('user_id', $user->id)->first();

        if ($cartItems->isEmpty()) {
            return view('cart', ['cartItems' => [], 'total_price' => 0]);
        }

        $productIds = $cartItems->pluck('product_id')->unique();

        $products = app()->call('App\Http\Controllers\ProductController@getProductsByIds', ['ids' => $productIds]);
        $images = app()->call('App\Http\Controllers\ImageController@getImagesByProductIds', ['ids' => $productIds]);
        $sizes = app()->call('App\Http\Controllers\SizeController@getAllSizes');

        $cartData = $cartItems->map(function ($cartItem) use ($products, $images, $sizes) {
            $product = $products->firstWhere('id', $cartItem->product_id);
            $image = $images->firstWhere('product_id', $cartItem->product_id);
            $size = $sizes->firstWhere('id', $cartItem->size_id);

            return [
                'product_id' => $product->id,
                'product_name' => $product->product_name,
                'description' => $product->description,
                'price' => (int) str_replace(' ', '', $product->price),
                'quantity' => $cartItem->quantity,
                'size' => $size->size,
                'image_url' => asset('storage/' . $image->url),
            ];
        });

        // Подсчет общей суммы
        $totalPrice = $cartData->sum(function ($cartItem) {
            return $cartItem['price'] * $cartItem['quantity'];
        });

        // Передаем данные в представление
        return view('cart', ['cartItems' => $cartData, 'total_price' => $totalPrice, 'address' => $address]);
    }


    public function updateQuantity(Request $request)    {
        $cartItem = Cart::where('user_id', Auth::id())
                        ->where('product_id', $request->product_id)
                        ->first();

        if ($cartItem) {
            $cartItem->quantity = $request->quantity;
            $cartItem->save();

            $totalPrice = Cart::where('user_id', Auth::id())->get()->sum(function ($cartItem) {
                $product = app()->call('App\Http\Controllers\ProductController@getProductById', ['id' => $cartItem->product_id]);
                return (int)str_replace(' ', '', $product->price) * $cartItem->quantity;
            });

            return response()->json(['totalPrice' => $totalPrice, 'success' => true]);
        }

        return response()->json(['success' => false]);
    }

    public function deleteCartItem($productId)  {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Пользователь не авторизован.'], 401);
        }

        // Находим товар в корзине пользователя
        $cartItem = Cart::where('user_id', $user->id)
                            ->where('product_id', $productId)
                            ->first();

        if (!$cartItem) {
            return response()->json(['success' => false, 'message' => 'Товар не найден в корзине пользователя.'], 404);
        }

       
        $cartItem->delete();
        $total_price = $this->getUserCartTotalPrice();

        return response()->json(['success' => true, 'totalPrice' => $total_price]);
    }

    public function showSuccess() {
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

        return view('success', compact('products', 'images', 'categories', 'carts', 'sizes','total_price'));
    }
}
