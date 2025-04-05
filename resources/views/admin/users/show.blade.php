@extends('layouts.admin')

@section('title', 'Dashboard')

@section('header', 'Dashboard')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">User Details</h1>
            <div class="flex space-x-2">
                <a href="{{ route('admin.users.edit', $user->user_id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Edit User
                </a>
                <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Back to List
                </a>
            </div>
        </div>

        <!-- User Information Card -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
            <div class="px-4 py-5 sm:px-6 bg-gray-50">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    User Information
                </h3>
            </div>
            <div class="border-t border-gray-200">
                <dl>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">ID</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $user->user_id }}</dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Full name</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $user->first_name }} {{ $user->last_name }}</dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Email address</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $user->email }}</dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Phone</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $user->phone ?? 'Not provided' }}</dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Role</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->is_admin ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                {{ $user->is_admin ? 'Administrator' : 'Customer' }}
                            </span>
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Created At</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $user->created_at->format('F d, Y h:i A') }}</dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $user->updated_at->format('F d, Y h:i A') }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- User Related Data Tabs -->
        <div x-data="{ activeTab: 'addresses' }" class="bg-white shadow-md rounded-lg overflow-hidden">
            <!-- Tab Navigation -->
            <div class="border-b border-gray-200">
                <nav class="flex -mb-px">
                    <button @click="activeTab = 'addresses'" :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'addresses', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'addresses' }" class="w-1/5 py-4 px-1 text-center border-b-2 font-medium text-sm">
                        Addresses ({{ count($user->addresses) }})
                    </button>
                    <button @click="activeTab = 'orders'" :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'orders', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'orders' }" class="w-1/5 py-4 px-1 text-center border-b-2 font-medium text-sm">
                        Orders ({{ count($user->orders) }})
                    </button>
                    <button @click="activeTab = 'cartItems'" :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'cartItems', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'cartItems' }" class="w-1/5 py-4 px-1 text-center border-b-2 font-medium text-sm">
                        Cart Items ({{ count($user->cartItems) }})
                    </button>
                    <button @click="activeTab = 'wishlists'" :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'wishlists', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'wishlists' }" class="w-1/5 py-4 px-1 text-center border-b-2 font-medium text-sm">
                        Wishlists ({{ count($user->wishlists) }})
                    </button>
                    <button @click="activeTab = 'reviews'" :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'reviews', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'reviews' }" class="w-1/5 py-4 px-1 text-center border-b-2 font-medium text-sm">
                        Reviews ({{ count($user->reviews) }})
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="p-4">
                <!-- Addresses Tab -->
                <div x-show="activeTab === 'addresses'" x-cloak>
                    @if(count($user->addresses) > 0)
                        <div class="space-y-4">
                            @foreach($user->addresses as $address)
                                <div class="border rounded-md p-4">
                                    <h4 class="font-medium">{{ $address->address_type ?? 'Address' }}</h4>
                                    <p class="text-sm">{{ $address->street_address }}, {{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}</p>
                                    <p class="text-sm">{{ $address->country }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">No addresses found for this user.</p>
                    @endif
                </div>

                <!-- Orders Tab -->
                <div x-show="activeTab === 'orders'" x-cloak>
                    @if(count($user->orders) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($user->orders as $order)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $order->order_id }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $order->created_at->format('M d, Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $order->status }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">${{ number_format($order->total_amount, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">No orders found for this user.</p>
                    @endif
                </div>

                <!-- Cart Items Tab -->
                <div x-show="activeTab === 'cartItems'" x-cloak>
                    @if(count($user->cartItems) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Added On</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($user->cartItems as $item)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $item->product_id }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $item->quantity }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $item->created_at->format('M d, Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">No cart items found for this user.</p>
                    @endif
                </div>

                <!-- Wishlists Tab -->
                <div x-show="activeTab === 'wishlists'" x-cloak>
                    @if(count($user->wishlists) > 0)
                        <div class="space-y-4">
                            @foreach($user->wishlists as $wishlist)
                                <div class="border rounded-md p-4">
                                    <h4 class="font-medium">{{ $wishlist->name }}</h4>
                                    <p class="text-sm text-gray-500">Created: {{ $wishlist->created_at->format('M d, Y') }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">No wishlists found for this user.</p>
                    @endif
                </div>

                <!-- Reviews Tab -->
                <div x-show="activeTab === 'reviews'" x-cloak>
                    @if(count($user->reviews) > 0)
                        <div class="space-y-4">
                            @foreach($user->reviews as $review)
                                <div class="border rounded-md p-4">
                                    <div class="flex justify-between">
                                        <h4 class="font-medium">Product ID: {{ $review->product_id }}</h4>
                                        <div class="flex items-center">
                                            <span class="text-yellow-400">★</span>
                                            <span class="ml-1 text-sm">{{ $review->rating }}/5</span>
                                        </div>
                                    </div>
                                    <p class="text-sm mt-2">{{ $review->comment }}</p>
                                    <p class="text-xs text-gray-500 mt-1">Posted: {{ $review->created_at->format('M d, Y') }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">No reviews found for this user.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection