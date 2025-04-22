<?php

namespace App\Models;

use App\Enums\OrderStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public $timestamps = false;

    public static function getIdByStatus(OrderStatusEnum $status): ?int
    {
        return self::where('name', $status->value)->value('id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
