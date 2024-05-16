<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_name',
        'description',
        'price'
    ];

    public function image()
    {
        return $this->hasMany(Image::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}