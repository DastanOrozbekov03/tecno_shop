<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class SiteController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Поиск по имени продукта
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Фильтр по категории (slug)
        if ($request->filled('category')) {
            $categorySlug = $request->category;
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        // Получаем все категории для меню
        $categories = Category::all();

        // Пагинация продуктов
        $products = $query->paginate(20)->withQueryString();

        return view('home', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.product', compact('product'));
    }
}
