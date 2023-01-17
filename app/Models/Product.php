<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'photo',
    ];

    public function colors() {
        return $this->belongsToMany('App\Color')->withTimestamps();
    }
    
    public function likedBy() {
        return $this->belongsToMany('App\User') ; 
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function sizes()
    {
        return $this->belongsToMany('App\Models\Size','product_sizes');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category','products_categories');
    }

    public function photos()
    {
        return $this->hasMany('App\Models\ProductPicture');
    }

}
