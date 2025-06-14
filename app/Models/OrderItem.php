<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;

    // Заполняемые поля для массового присвоения
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    /**
     * Связь с моделью продукта
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Связь с моделью заказа
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Получить общую стоимость позиции (цена * количество)
     */
    public function getTotalAttribute()
    {
        return $this->price * $this->quantity;
    }
}
