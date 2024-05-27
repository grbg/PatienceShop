<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Size;

class SizeController extends Controller
{
    public function getSizeById(int $size_id) {
        $size = Size::where('id', $size_id);
        return $size;
    }

    public function getAllSizes() {
        return Size::all();
    }

}
