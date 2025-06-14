<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        $query = Order::with('items.product', 'user')->latest();

        // Фильтры
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }
        if ($request->filled('received_status')) {
            $query->where('received_status', $request->received_status);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        if ($request->filled('received_from')) {
            $query->whereDate('received_at', '>=', $request->received_from);
        }
        if ($request->filled('received_to')) {
            $query->whereDate('received_at', '<=', $request->received_to);
        }

        $orders = $query->paginate(20);
        $profit = Order::where('payment_status', 'paid')
            ->where('received_status', 'received')
            ->sum('total');
        $totalCount = Order::count();

        return view('admin.orders.index', compact('orders', 'profit', 'totalCount'));
    }

    public function markReceived($id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->update([
                'received_status' => 'received',
                'received_at' => now(),
            ]);
            Log::info('Order marked as received', [
                'order_id' => $id,
                'received_at' => $order->received_at,
                'received_status' => $order->received_status
            ]);
            return back()->with('success', 'Заказ отмечен как полученный');
        } catch (\Exception $e) {
            Log::error('Failed to mark order as received', [
                'order_id' => $id,
                'error' => $e->getMessage()
            ]);
            return back()->with('error', 'Ошибка при отметке заказа как полученного: ' . $e->getMessage());
        }
    }

    public function markPaid($id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->update([
                'payment_status' => 'paid',
                'paid_at' => now(),
            ]);
            Log::info('Order marked as paid', [
                'order_id' => $id,
                'paid_at' => $order->paid_at,
                'payment_status' => $order->payment_status
            ]);
            return back()->with('success', 'Оплата заказа подтверждена');
        } catch (\Exception $e) {
            Log::error('Failed to mark order as paid', [
                'order_id' => $id,
                'error' => $e->getMessage()
            ]);
            return back()->with('error', 'Ошибка при подтверждении оплаты: ' . $e->getMessage());
        }
    }

    public function deleteUncollected(Request $request)
    {
        $request->validate(['days' => 'required|integer|min:1']);
        $days = $request->input('days');
        $uncollectedOrders = Order::where('received_status', 'pending')
            ->where('created_at', '<', now()->subDays($days))
            ->delete();
        Log::info('Uncollected orders deleted', ['count' => $uncollectedOrders]);
        return back()->with('success', "Удалено $uncollectedOrders неподтвержденных заказов");
    }
}
