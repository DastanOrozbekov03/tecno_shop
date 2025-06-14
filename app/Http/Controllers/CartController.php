<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = CartItem::with('product')->where('user_id', Auth::id())->get();
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request, Product $product)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Пожалуйста, войдите в систему',
            ], 401);
        }

        $quantity = max(1, (int) $request->input('quantity', 1));

        $cartItem = CartItem::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            CartItem::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
        }

        session()->forget('cart'); // Очистка устаревших данных сессии

        return response()->json([
            'success' => true,
            'message' => 'Товар добавлен в корзину',
        ]);
    }

    public function remove(Product $product)
    {
        CartItem::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->delete();

        session()->forget('cart'); // Очистка устаревших данных сессии

        return redirect()->route('cart.index')->with('success', 'Товар удален из корзины');
    }

    public function update(Request $request, Product $product)
    {
        $quantity = max(1, (int) $request->input('quantity'));

        $cartItem = CartItem::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->quantity = $quantity;
            $cartItem->save();

            session()->forget('cart'); // Очистка устаревших данных сессии

            $subtotal = $product->price * $quantity;
            $cart = CartItem::with('product')->where('user_id', Auth::id())->get();
            $total = $cart->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });

            return response()->json([
                'success' => true,
                'subtotal' => $subtotal,
                'total' => $total,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Товар не найден в корзине',
        ], 404);
    }
}
