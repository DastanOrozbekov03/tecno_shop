<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // Список категорий
    public function index()
    {
        $categories = Category::paginate(20);
        return view('admin.categories.index', compact('categories'));
    }

    // Форма создания
    public function create()
    {
        return view('admin.categories.create');
    }

    // Сохранение новой категории
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'slug' => 'required|string|max:255|unique:categories,slug',
        ]);

        Category::create($request->only('name', 'slug'));

        return redirect()->route('admin.categories.index')->with('success', 'Категория создана');
    }

    // Форма редактирования
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    // Обновление категории
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'slug' => 'required|string|max:255|unique:categories,slug,' . $category->id,
        ]);

        $category->update($request->only('name', 'slug'));

        return redirect()->route('admin.categories.index')->with('success', 'Категория обновлена');
    }

    // Удаление категории
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Категория удалена');
    }
}
