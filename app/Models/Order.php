<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'phone',
        'address',
        'status',
        'total',
        'user_id',
        'delivery_method',
        'payment_status',
        'received_status',
        'paid_at',
        'received_at', // Добавляем поле received_at
        'transaction_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'paid_at',
        'received_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'received_at' => 'datetime',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
