<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    
    public function allSizes()
    {
        return Size::all();
    }
}
