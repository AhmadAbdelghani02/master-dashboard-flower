@extends('layouts.admin')

@section('title', 'Dashboard')

@section('header', 'Dashboard')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-semibold text-gray-900">Edit Order #{{ $order->order_id }}</h1>
                <div>
                    <a href="{{ route('admin.orders.show', $order) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </a>
                </div>
            </div>
            
            @if ($errors->any())
                <div class="mt-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="mt-6">
                @csrf
                @method('PUT')
                
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6 bg-gray-50">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Order Details</h3>
                    </div>
                    <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <div class="sm:col-span-3">
                                <label for="user_id" class="block text-sm font-medium text-gray-700">Customer</label>
                                <select id="user_id" name="user_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    @foreach($users as $user)
                                        <option value="{{ $user->user_id }}" {{ $order->user_id == $user->user_id ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="sm:col-span-3">
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select id="status" name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    @foreach($statuses as $value => $label)
                                        <option value="{{ $value }}" {{ $order->status == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="sm:col-span-3">
                                <label for="order_date" class="block text-sm font-medium text-gray-700">Order Date</label>
                                <div class="mt-1">
                                    <input type="text" name="order_date" id="order_date" value="{{ $order->order_date->format('Y-m-d H:i:s') }}" disabled class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md bg-gray-100">
                                    <p class="mt-1 text-sm text-gray-500">Order date cannot be changed</p>
                                </div>
                            </div>
                            
                            <div class="sm:col-span-3">
                                <label for="total_amount" class="block text-sm font-medium text-gray-700">Total Amount</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">$</span>
                                    </div>
                                    <input type="number" name="total_amount" id="total_amount" value="{{ $order->total_amount }}" step="0.01" min="0" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>
                            
                            <div class="sm:col-span-3">
                                <label for="shipping_address_id" class="block text-sm font-medium text-gray-700">Shipping Address</label>
                                <select id="shipping_address_id" name="shipping_address_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    @foreach($addresses as $address)
                                        <option value="{{ $address->address_id }}" {{ $order->shipping_address_id == $address->address_id ? 'selected' : '' }}>
                                            {{ $address->street_address }}, {{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="sm:col-span-3">
                                <label for="billing_address_id" class="block text-sm font-medium text-gray-700">Billing Address</label>
                                <select id="billing_address_id" name="billing_address_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    @foreach($addresses as $address)
                                        <option value="{{ $address->address_id }}" {{ $order->billing_address_id == $address->address_id ? 'selected' : '' }}>
                                            {{ $address->street_address }}, {{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="sm:col-span-6">
                                <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                                <div class="mt-1">
                                    <textarea id="notes" name="notes" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ $order->notes }}</textarea>
                                </div>
                                <p class="mt-2 text-sm text-gray-500">Brief description or notes about this order.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Applied Promotions -->
                <div class="mt-6 bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6 bg-gray-50">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Applied Promotions</h3>
                    </div>
                    <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                        <div class="space-y-4">
                            @foreach($promotions as $index => $promotion)
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="promotion_{{ $promotion->id }}" name="promotion_ids[]" type="checkbox" value="{{ $promotion->id }}" 
                                            {{ $order->promotions->contains($promotion->id) ? 'checked' : '' }}
                                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="promotion_{{ $promotion->id }}" class="font-medium text-gray-700">{{ $promotion->name }}</label>
                                        <p class="text-gray-500">Code: {{ $promotion->code }}</p>
                                    </div>
                                    <div class="ml-auto">
                                        <label for="discount_{{ $promotion->id }}" class="sr-only">Discount amount</label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 sm:text-sm">$</span>
                                            </div>
                                            <input type="number" name="discount_amounts[]" id="discount_{{ $promotion->id }}" 
                                                value="{{ $order->promotions->contains($promotion->id) ? $order->promotions->find($promotion->id)->pivot->discount_amount : '0.00' }}" 
                                                step="0.01" min="0" 
                                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            
                            @if($promotions->isEmpty())
                                <p class="text-sm text-gray-500">No promotions available</p>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end">
                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Update Order
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endsection