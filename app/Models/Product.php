<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model

{


    protected $fillable = ['name', 'price', 'stock', 'description', 'image'];
    // Yeh columns database mein save hona allow hain
    // protected $fillable = [
    //     'name', 
    //     'description', 
    //     'price', 
    //     'image',
    //     'stock'
    // ];
    protected $guarded = [];

}

