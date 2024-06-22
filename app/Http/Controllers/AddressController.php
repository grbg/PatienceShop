<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Address;
use App\User;

class AddressController extends Controller
{
    public function updateAddressData(Request $request)    {
        $validator = Validator::make($request->all(), [
            'country' => 'string|max:255',
            'city' => 'string|max:255',
            'street' => 'string|max:255',
            'house' => 'string|max:255',
            'zip_code' => 'string|min:6',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = Auth::user();

        $address = Address::updateOrCreate(
            ['user_id' => $user->id],
            [
                'country' => $request->country,
                'city' => $request->city,
                'street' => $request->street,
                'house' => $request->house,
                'zip_code' => $request->zip_code,
            ]
        );

        return response()->json(['success' => true]);
    }
}
