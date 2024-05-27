<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;

class ImageController extends Controller
{
    public function getImagesByProductIds($ids)
    {
        return Image::whereIn('product_id', $ids)->get();
    }
}
