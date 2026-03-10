<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem; 

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'address',
        'phone',
        'image',
        'total_amount',
        'payment_method',
        'status',
    ];

    public function orderItems()
                            {
                                return $this->hasMany(OrderItem::class);
                            }
                        }
                        