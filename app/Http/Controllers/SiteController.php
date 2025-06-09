<?php

// app/Http/Controllers/SiteController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class SiteController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Поиск по имени
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

        return view('home', [
            'products' => $query->paginate(20)->withQueryString(),
            'categories' => Category::all()
        ]);
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('product', compact('product'));
    }
}
