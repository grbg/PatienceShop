<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Image;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Address;


class UserController extends Controller
{
    public function userRegister(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'birthday' => 'required|date',
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 422);
        }

        $user = new User();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->birthday = $request->birthday;
        $user->email = $request->email;
        $user->password = bcrypt($request->password); // Хешируем пароль

        $user->save();

        return response()->json(['success' => true]);
    }

    public function userLogin(Request $request) {
        $validator = Validator::make($request->all(), [
            'email_login' => 'required|string|email|max:191',
            'password_login' => 'required|string|min:8',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 422);
        }
        if (Auth::attempt(['email' => $request->email_login, 'password' => $request->password_login])) {
            $user = Auth::user();

            $carts = Cart::where('user_id', Auth::id())->with('product')->get();

            return response()->json(['success' => true, 'user' => $user, 'carts' => $carts]);
        }
        else {
           $errors = ['Неверный логин или пароль'];

            $errors[] = 'Неверный логин или пароль';

            return response()->json(['errors' => $errors], 422);
        }
    }

    public function showUserData()  {
        $user = auth()->user();
        $orders = Order::where('user_id', $user->id)->get();
        $products = Product::all();
        $images = Image::all();
        $address = Address::where('user_id', $user->id)->first();
    
        $orderItems = OrderItem::whereIn('order_id', $orders->pluck('id'))->get();
    
        $orders->each(function($order) use ($orderItems) {
            $order->orderItems = $orderItems->where('order_id', $order->id);
        });

        $carts = app()->call('App\Http\Controllers\CartController@index');

        $total_price = app()->call('App\Http\Controllers\CartController@getUserCartTotalPrice');

        $sizes = app()->call('App\Http\Controllers\SizeController@getAllSizes');

        return view('profile', compact('user', 'orders','address', 'carts', 'total_price', 'sizes', 'products', 'images'));
    }

    public function update(Request $request)    {
        $user = Auth::user();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        // Предполагая, что формат даты в БД такой же, как и в форме
        $user->birthday = \Carbon\Carbon::createFromFormat('d.m.Y', $request->input('birthday'))->format('Y-m-d');
        $user->save();

        // Обновление данных в сессии
        $request->session()->put('user', $user);

        return redirect()->back()->with('success', 'Информация успешно обновлена');
    }

    public function deleteAccount(Request $request) {
        $user = Auth::user();
        // Удалите аккаунт пользователя (ваша реализация удаления аккаунта)


        // Выход из сессии
        Auth::logout();

        $user->delete();
        
        $request->session()->forget('user');

        return redirect('/')->with('success', 'Ваш аккаунт успешно удален и вы вышли из системы.');
    }

    public function logout()    {
        Auth::logout();

        return redirect('/')->with('success', 'Ваш аккаунт успешно удален и вы вышли из системы.');
    }
}
