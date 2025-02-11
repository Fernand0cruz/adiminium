<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'discount',
        'stock_quantity',
        'photo',
    ];

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product')
            ->using(OrderProduct::class)        
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }
}
