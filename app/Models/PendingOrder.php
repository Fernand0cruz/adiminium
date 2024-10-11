<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'order_data',
        'status',
    ];

    protected $casts = [
        'order_data' => 'array',
    ];

    // Relacionamento com User (cliente)
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
