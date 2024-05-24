<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Models\Cart;

class CartController extends Controller
{
    public function index()
    {
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
            return $item->product->price * $item->quantity;
        });

        $cartItems = $items->map(function ($item) {
            return [
                'product_name' => $item->product->name,
                'size_name' => $item->size->name,
                'quantity' => $item->quantity,
            ];
        });

        return [
            'items' => $cartItems,
            'total_price' => $totalPrice,
        ];
    }

    public function getUserCartTotalPrice()
    {
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
}
