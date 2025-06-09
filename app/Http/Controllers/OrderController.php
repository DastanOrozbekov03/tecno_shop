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
        $cart = CartItem::with('product')->where('user_id', Auth::id())->get();

        if ($cart->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Корзина пуста');
        }

        return view('order.checkout', compact('cart'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'delivery_method' => 'required|in:pickup,delivery',
            'payment_method' => 'required|in:mbank,elsom,optima,cash',
            'address' => 'required_if:delivery_method,delivery|string|nullable|max:500',
        ]);

        $cart = CartItem::with('product')->where('user_id', Auth::id())->get();

        if ($cart->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Корзина пуста');
        }

        DB::beginTransaction();

        try {
            $total = $cart->sum(fn($item) => $item->product->price * $item->quantity);

            $order = Order::create([
                'user_id' => Auth::id(),
                'customer_name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->delivery_method === 'delivery' ? $request->address : 'Самовывоз',
                'delivery_method' => $request->delivery_method,
                'payment_method' => $request->payment_method,
                'status' => 'new',
                'total' => $total,
            ]);

            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product->id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
            }

            CartItem::where('user_id', Auth::id())->delete();

            DB::commit();

            return redirect()->route('checkout.thankyou')->with('success', 'Ваш заказ успешно оформлен!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Ошибка при оформлении заказа: ' . $e->getMessage());
        }
    }

    public function thankyou()
    {
        return view('order.thankyou');
    }
}
