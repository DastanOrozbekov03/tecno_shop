<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $categoriesCount = Category::count();
        $productsCount = Product::count();
        $totalCount = Order::count();
        $totalProfit = Order::where('payment_status', 'paid')
            ->where('received_status', 'received')
            ->sum('total');
        $newOrdersToday = Order::whereDate('created_at', today())->count();

        $ordersData = [];
        $weekLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $weekLabels[] = $date->translatedFormat('d F');
            $ordersData[] = Order::whereDate('created_at', $date)->count();
        }

        $weeklySalesData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $weeklySalesData[] = Order::where('payment_status', 'paid')
                ->where('received_status', 'received')
                ->whereDate('created_at', $date)
                ->sum('total');
        }

        $monthlySalesData = [];
        $monthLabels = [];
        $startOfMonth = Carbon::today()->startOfMonth();
        $endOfMonth = Carbon::today()->endOfMonth();
        $daysInMonth = $startOfMonth->daysUntil($endOfMonth)->count();

        for ($i = 0; $i < $daysInMonth; $i++) {
            $date = $startOfMonth->copy()->addDays($i);
            $monthLabels[] = $date->translatedFormat('d F');
            $monthlySalesData[] = Order::where('payment_status', 'paid')
                ->where('received_status', 'received')
                ->whereDate('created_at', $date)
                ->sum('total');
        }

        // Данные для круговой диаграммы по категориям
        $categorySales = Category::select('categories.name as category_name')
            ->join('products', 'categories.id', '=', 'products.category_id')
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.payment_status', 'paid')
            ->where('orders.received_status', 'received')
            ->groupBy('categories.id', 'categories.name')
            ->selectRaw('SUM(orders.total) as total_sales')
            ->get();

        $categoryLabels = $categorySales->pluck('category_name')->toArray();
        $categorySalesData = $categorySales->pluck('total_sales')->toArray();

        return view('admin.dashboard', compact(
            'categoriesCount',
            'productsCount',
            'totalCount',
            'totalProfit',
            'newOrdersToday',
            'ordersData',
            'weekLabels',
            'weeklySalesData',
            'monthlySalesData',
            'monthLabels',
            'categoryLabels',
            'categorySalesData'
        ));
    }
}
