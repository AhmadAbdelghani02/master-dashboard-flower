@extends('layouts.admin')

@section('title', 'Dashboard')

@section('header', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Stats cards -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="bg-indigo-100 rounded-full p-3">
                    <i class="fas fa-shopping-cart text-indigo-500"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-gray-500 text-sm font-medium">Total Orders</h3>
                    <p class="text-2xl font-bold">{{ $totalOrders }}</p>
                    <p class="{{ $orderGrowth >= 0 ? 'text-green-500' : 'text-red-500' }} text-sm">
                        {{ $orderGrowth >= 0 ? '+' : '' }}{{ $orderGrowth }}% from last month
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="bg-green-100 rounded-full p-3">
                    <i class="fas fa-users text-green-500"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-gray-500 text-sm font-medium">Total Users</h3>
                    <p class="text-2xl font-bold">{{ $totalUsers }}</p>
                    <p class="{{ $userGrowth >= 0 ? 'text-green-500' : 'text-red-500' }} text-sm">
                        {{ $userGrowth >= 0 ? '+' : '' }}{{ $userGrowth }}% from last month
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="bg-blue-100 rounded-full p-3">
                    <i class="fas fa-gift text-blue-500"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-gray-500 text-sm font-medium">Gift Boxes Sold</h3>
                    <p class="text-2xl font-bold">{{ $totalGiftBoxes }}</p>
                    <p class="{{ $giftBoxGrowth >= 0 ? 'text-green-500' : 'text-red-500' }} text-sm">
                        {{ $giftBoxGrowth >= 0 ? '+' : '' }}{{ $giftBoxGrowth }}% from last month
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="bg-purple-100 rounded-full p-3">
                    <i class="fas fa-dollar-sign text-purple-500"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-gray-500 text-sm font-medium">Total Revenue</h3>
                    <p class="text-2xl font-bold">${{ number_format($totalRevenue, 2) }}</p>
                    <p class="{{ $revenueGrowth >= 0 ? 'text-green-500' : 'text-red-500' }} text-sm">
                        {{ $revenueGrowth >= 0 ? '+' : '' }}{{ $revenueGrowth }}% from last month
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Recent Orders -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b">
                <h2 class="text-lg font-medium text-gray-900">Recent Orders</h2>
                <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View all</a>
                {{-- {{ route('admin.orders.index') }} --}}
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recentOrders as $order)
                            <tr>
                                <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900">#{{ $order['id'] }}</td>
                                <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order['customer'] }}</td>
                                <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order['date'] }}</td>
                                <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($order['total'], 2) }}</td>
                                <td class="px-3 py-4 whitespace-nowrap">
                                    @php
                                        $statusColor = [
                                            'pending' => 'yellow',
                                            'processing' => 'yellow',
                                            'shipped' => 'blue',
                                            'delivered' => 'green',
                                            'cancelled' => 'red'
                                        ][$order['status']] ?? 'gray';
                                    @endphp
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-{{ $statusColor }}-100 text-{{ $statusColor }}-800">
                                        {{ ucfirst($order['status']) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-3 py-4 text-center text-sm text-gray-500">No recent orders found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Low Stock Products -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b">
                <h2 class="text-lg font-medium text-gray-900">Low Stock Products</h2>
                <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View all</a>
                {{-- {{ route('admin.products.index') }} --}}
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($lowStockProducts as $product)
                            <tr>
                                <td class="px-3 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0 bg-gray-200 rounded">
                                            @if($product['image_url'])
                                                <img src="{{ asset($product['image_url']) }}" alt="{{ $product['name'] }}" class="h-10 w-10 object-cover rounded">
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $product['name'] }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product['category'] }}</td>
                                <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900">{{ $product['stock'] }}</td>
                                <td class="px-3 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-{{ $product['status'] === 'critical' ? 'red' : 'yellow' }}-100 text-{{ $product['status'] === 'critical' ? 'red' : 'yellow' }}-800">
                                        {{ ucfirst($product['status']) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-3 py-4 text-center text-sm text-gray-500">No low stock products found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- payments widget --}}
    <div class="grid grid-cols-1 gap-6">

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Recent Payments</h2>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($recentPayments as $payment)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $payment->payment_id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $payment->order_id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    ${{ number_format($payment->amount, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $payment->payment_date->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $payment->status == 'completed' ? 'bg-green-100 text-green-800' : 
                                           ($payment->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                           ($payment->status == 'failed' ? 'bg-red-100 text-red-800' : 
                                            'bg-gray-100 text-gray-800')) }}">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.payments.show', $payment) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    No recent payments found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4 text-right">
                <a href="{{ route('admin.payments.index') }}" class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                    View all payments →
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6">
        <!-- Recent Reviews -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b">
                <h2 class="text-lg font-medium text-gray-900">Recent Reviews</h2>
                <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View all</a>
                {{-- {{ route('admin.reviews.index') }} --}}
            </div>
            <div class="p-6">
                <div class="space-y-6">
                    @forelse($recentReviews as $review)
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-600 font-medium">{{ substr($review['customer'], 0, 1) }}</span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="flex items-center">
                                    <h4 class="text-sm font-bold text-gray-900">{{ $review['customer'] }}</h4>
                                    <div class="ml-2 flex">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review['rating'])
                                                <i class="fas fa-star text-yellow-400"></i>
                                            @else
                                                <i class="far fa-star text-yellow-400"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="ml-2 text-sm text-gray-500">{{ $review['date'] }}</span>
                                </div>
                                <div class="mt-1 text-sm text-gray-700">
                                    <p>{{ $review['comment'] }}</p>
                                </div>
                                <div class="mt-2 text-sm font-medium text-gray-500">
                                    Product: {{ $review['product'] }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-sm text-gray-500">No recent reviews found</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection