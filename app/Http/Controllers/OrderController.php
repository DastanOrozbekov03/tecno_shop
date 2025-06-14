<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkout()
    {
        if (!Auth::check()) {
            \Log::warning('User not authenticated');
            return redirect()->route('login')->with('error', 'Пожалуйста, войдите в систему для оформления заказа');
        }

        $cart = CartItem::with('product')->where('user_id', Auth::id())->get();

        if ($cart->isEmpty()) {
            \Log::warning('Cart is empty for user', ['user_id' => Auth::id()]);
            return redirect()->route('cart.index')->with('error', 'Корзина пуста');
        }

        return view('order.checkout', compact('cart'));
    }

    public function store(Request $request)
    {
        \Log::info('Store method called', $request->all());

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'delivery_method' => 'required|in:pickup,delivery',
            'address' => 'required_if:delivery_method,delivery|string|nullable|max:500',
        ]);

        $cart = CartItem::with('product')->where('user_id', Auth::id())->get();
        \Log::info('Cart items', ['count' => $cart->count(), 'user_id' => Auth::id()]);

        if ($cart->isEmpty()) {
            \Log::warning('Cart is empty for user', ['user_id' => Auth::id()]);
            return redirect()->route('cart.index')->with('error', 'Корзина пуста');
        }

        DB::beginTransaction();

        try {
            $total = $cart->sum(function ($item) {
                if (!$item->product) {
                    \Log::error('Product not found for cart item', ['cart_item_id' => $item->id]);
                    throw new \Exception('Продукт не найден для элемента корзины');
                }
                return $item->product->price * $item->quantity;
            });
            \Log::info('Calculated total', ['total' => $total]);

            $order = Order::create([
                'user_id' => Auth::id(),
                'customer_name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->delivery_method === 'delivery' ? $request->address : 'Самовывоз',
                'delivery_method' => $request->delivery_method,
                'status' => 'new',
                'total' => $total,
            ]);
            \Log::info('Order created', ['order_id' => $order->id]);

            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product->id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
            }
            \Log::info('Order items created', ['order_id' => $order->id]);

            CartItem::where('user_id', Auth::id())->delete();
            \Log::info('Cart cleared', ['user_id' => Auth::id()]);

            session()->forget('cart'); // Очистка устаревших данных сессии

            DB::commit();
            \Log::info('Transaction committed', ['order_id' => $order->id]);

            return redirect()->route('checkout.thankyou')
                ->with('success', 'Ваш заказ успешно оформлен!')
                ->with('order_id', $order->id)
                ->with('delivery_method', $request->delivery_method);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Order creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->withErrors('Ошибка при оформлении заказа: ' . $e->getMessage());
        }
    }

    public function thankyou()
    {
        $order_id = session('order_id');
        if (!$order_id) {
            \Log::warning('Order ID not found in session');
            return redirect()->route('home')->with('error', 'Ошибка: заказ не найден');
        }
        return view('order.thankyou', compact('order_id'));
    }
}
