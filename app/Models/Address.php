<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{

    protected $fillable = [
        'user_id', 
        'street', 
        'city',  
        'house',
        'zip_code', 
        'country'
    ];

    public function user(): BelongsTo   {
        return $this->belongsTo(User::class);
    }
}
