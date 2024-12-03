<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'status',
        'products_data',
    ];

    protected $casts = [
        'products_data' => 'array',
    ];

    // Relacionamento com User (cliente)
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    // Relacionamento com Product
    public function product()
    {
        return $this->belongsToMany(Product::class);
    }
}
