<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\GiftBox;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Get counts for stats cards
        $totalOrders = Order::count();
        $totalUsers = User::count();
        $totalGiftBoxes = GiftBox::count();
        $totalRevenue = Order::sum('total_amount');
        
        // Calculate month-over-month growth percentages
        $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();
        $currentMonthStart = Carbon::now()->startOfMonth();
        
        $lastMonthOrders = Order::whereBetween('order_date', [$lastMonthStart, $lastMonthEnd])->count();
        $lastMonthUsers = User::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count();
        $lastMonthGiftBoxes = GiftBox::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count();
        $lastMonthRevenue = Order::whereBetween('order_date', [$lastMonthStart, $lastMonthEnd])->sum('total_amount');
        
        $currentMonthOrders = Order::where('order_date', '>=', $currentMonthStart)->count();
        $currentMonthUsers = User::where('created_at', '>=', $currentMonthStart)->count();
        $currentMonthGiftBoxes = GiftBox::where('created_at', '>=', $currentMonthStart)->count();
        $currentMonthRevenue = Order::where('order_date', '>=', $currentMonthStart)->sum('total_amount');
        
        // Calculate growth percentages
        $orderGrowth = $this->calculateGrowthPercentage($lastMonthOrders, $currentMonthOrders);
        $userGrowth = $this->calculateGrowthPercentage($lastMonthUsers, $currentMonthUsers);
        $giftBoxGrowth = $this->calculateGrowthPercentage($lastMonthGiftBoxes, $currentMonthGiftBoxes);
        $revenueGrowth = $this->calculateGrowthPercentage($lastMonthRevenue, $currentMonthRevenue);
        
        // Get recent orders with user information
        $recentOrders = Order::with('user')
            ->orderBy('order_date', 'desc')
            ->take(4)
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->order_id,
                    'customer' => $order->user->first_name . ' ' . $order->user->last_name,
                    'date' => Carbon::parse($order->order_date)->format('M d, Y'),
                    'total' => $order->total_amount,
                    'status' => $order->status
                ];
            });
        
        // Get low stock products
        $lowStockProducts = Product::with('category')
            ->where('stock_quantity', '<=', 12)
            ->orderBy('stock_quantity', 'asc')
            ->take(4)
            ->get()
            ->map(function ($product) {
                $status = $product->stock_quantity <= 5 ? 'critical' : 'low';
                return [
                    'name' => $product->name,
                    'category' => $product->category->name,
                    'stock' => $product->stock_quantity,
                    'image_url' => $product->image_url,
                    'status' => $status
                ];
            });
        
        // Get recent reviews
        $recentReviews = Review::with(['user', 'product'])
            ->orderBy('created_at', 'desc')
            ->take(2)
            ->get()
            ->map(function ($review) {
                return [
                    'customer' => $review->user->first_name . ' ' . substr($review->user->last_name, 0, 1) . '.',
                    'rating' => $review->rating,
                    'date' => Carbon::parse($review->created_at)->format('M d, Y'),
                    'comment' => $review->comment,
                    'product' => $review->product->name
                ];
            });
        
        return view('admin.dashboard', compact(
            'totalOrders', 'totalUsers', 'totalGiftBoxes', 'totalRevenue',
            'orderGrowth', 'userGrowth', 'giftBoxGrowth', 'revenueGrowth',
            'recentOrders', 'lowStockProducts', 'recentReviews'
        ));
    }
    
    private function calculateGrowthPercentage($lastValue, $currentValue)
    {
        if ($lastValue == 0) {
            return $currentValue > 0 ? 100 : 0;
        }
        
        return round((($currentValue - $lastValue) / $lastValue) * 100, 1);
    }
}