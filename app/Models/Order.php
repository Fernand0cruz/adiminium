<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'product_id',
        'quantity',
        'status'
    ];

    // Relacionamento com User (cliente)
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    // Relacionamento com Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
