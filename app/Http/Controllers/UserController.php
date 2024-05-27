<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;


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

        if (Auth::attempt(['email' => $request->email_login, 'password' => $request->password_login])) {
            $user = Auth::user();

            $carts = Cart::where('user_id', Auth::id())->with('product')->get();

            return redirect()->back()->with(['user' => $user], ['carts' => $carts]);
        }

        return redirect('/');
    }


}
