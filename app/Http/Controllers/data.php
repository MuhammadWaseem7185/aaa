<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class data extends Controller
{
   function adddata(request $req)
   { 
  DB::table('products')->insert([
    'name' => 'Sample Product',
    'description' => 'This is a sample product description.',
    'price' => 19.99,
    'image' => 'sample-product.jpg',
    'category' => 'Sample Category',
    'stock' => 100,

]);
}
   
}       