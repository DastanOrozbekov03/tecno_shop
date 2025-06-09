<?php

// app/Models/Category.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Чтобы использовать slug в маршрутах
    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Связь с товарами
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
