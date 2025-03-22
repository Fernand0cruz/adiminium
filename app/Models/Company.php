<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'photo',
        'business_name',
        'cnpj',
        'phone',
        'email',
        'web_site',
        'address',
        'state',
        'city',
        'zip_code',
        'neighborhood',
        'street',
        'number',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
