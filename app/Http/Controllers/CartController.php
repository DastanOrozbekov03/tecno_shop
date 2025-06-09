<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller  // <-- именно здесь наследование!
{
    public function __construct()
    {
        $this->middleware('auth'); // Обязательно защити все методы от неавторизованных
    }

    public function index()
    {
        $cart = CartItem::with('product')->where('user_id', Auth::id())->get();
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request, Product $product)
    {
        if (!Auth::check()) {
            return response()->json([
                'unauthorized' => true,
                'message' => 'Вы должны войти или зарегистрироваться, чтобы добавить товар в корзину.'
            ]);
        }

        // Получаем количество из запроса, если не указано — по умолчанию 1
        $quantity = max((int) $request->input('quantity', 1), 1);

        $cartItem = CartItem::firstOrNew([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
        ]);

        $cartItem->quantity = ($cartItem->exists ? $cartItem->quantity : 0) + $quantity;
        $cartItem->save();

        return response()->json([
            'success' => true,
            'message' => "Добавлено $quantity шт. в корзину."
        ]);
    }


    public function remove(Product $product)
    {
        CartItem::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->delete();

        return back()->with('success', 'Товар удалён из корзины');
    }
}


