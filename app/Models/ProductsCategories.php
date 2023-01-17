<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsCategories extends Model
{
    use HasFactory;

    public function following()
    {
        return $this->belongsToMany(Product::class, 'products_categories', 'follower_profile_id', 'followed_profile_id');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'friends', 'followed_profile_id', 'follower_profile_id');
    }
}
