<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
    use HasFactory;

    public function products ()
    {
        return $this->belongsToMany('App\Models\Product','command_products');
    }
    public function sizes ()
    {
        return $this->belongsToMany('App\Models\Size','command_products');
    }
}
