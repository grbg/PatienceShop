<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Size;
use App\Models\Product;
use App\Models\Cart;
use App\Models\OrderItem;

class OrderController extends Controller
{
    public function createOrder(Request $request) {
        $request->validate([
            'user_id' => 'required',
            'total_price' => 'required',
            'country' => 'required|string',
            'city' => 'required|string',
            'street' => 'required|string',
            'zip' => 'required|min:6',
            'house' => 'required|string',
        ]);

        if ($request->has('products') && !empty($request->products)) {

            $order = Order::create([
                'user_id' => $request->user_id,
                'total_price' => $request->total_price,
                'order_country' => $request->country,
                'order_city' => $request->city,
                'street' => $request->street,
                'zip_code' => $request->zip,
                'house_num' => $request->house,
                'delivery_method' => 'mail'
            ]);

            $products = json_decode($request->products, true);

            if (is_array($products)) {
                foreach ($products as $product) {
                    $order_product = Product::find($product['product_id']);
                    $cart = Cart::where('product_id', $product['product_id'])
                            ->where('user_id', $request->user_id)
                            ->first();
            
                    if ($cart) {
                        $size = Size::find($cart->size_id);

                        OrderItem::create([
                            'order_id' => $order->id,
                            'product_id' => $order_product->id,
                            'price' => (float) str_replace(' ', '', $order_product->price),
                            'size_id' => $size->id,
                            'quantity' => $cart->quantity
                        ]);

                        $cart->delete();
                    }
                }
            }
            session()->flash('order_success', true);
            
            return response()->json(['success' => true], 200);
        }
    }
}