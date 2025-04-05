@extends('layouts.admin')

@section('title', 'Dashboard')

@section('header', 'Dashboard')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-semibold text-gray-800">Edit Payment #{{ $payment->payment_id }}</h1>
                        <a href="{{ route('admin.payments.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                            Back to Payments
                        </a>
                    </div>

                    <!-- Validation Errors -->
                    @if ($errors->any())
                        <div class="mb-4">
                            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                                <p class="font-bold">Validation Error</p>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <!-- Payment Form -->
                    <form action="{{ route('admin.payments.update', $payment) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Order ID -->
                            <div>
                                <label for="order_id" class="block text-sm font-medium text-gray-700">Order</label>
                                <select id="order_id" name="order_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select Order</option>
                                    @foreach($orders as $order)
                                        <option value="{{ $order->order_id }}" {{ (old('order_id') ?? $payment->order_id) == $order->order_id ? 'selected' : '' }}>
                                            Order #{{ $order->order_id }} - ${{ number_format($order->total_amount, 2) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Amount -->
                            <div>
                                <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">$</span>
                                    </div>
                                    <input type="number" step="0.01" name="amount" id="amount" required 
                                           value="{{ old('amount') ?? $payment->amount }}" 
                                           class="pl-7 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                           placeholder="0.00">
                                </div>
                            </div>

                            <!-- Payment Method -->
                            <div>
                                <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                                <select id="payment_method" name="payment_method" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select Payment Method</option>
                                    @foreach($paymentMethods as $method)
                                        <option value="{{ $method }}" {{ (old('payment_method') ?? $payment->payment_method) == $method ? 'selected' : '' }}>
                                            {{ $method }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Transaction ID -->
                            <div>
                                <label for="transaction_id" class="block text-sm font-medium text-gray-700">Transaction ID</label>
                                <input type="text" name="transaction_id" id="transaction_id" 
                                       value="{{ old('transaction_id') ?? $payment->transaction_id }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                       placeholder="Transaction reference">
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select id="status" name="status" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select Status</option>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status }}" {{ (old('status') ?? $payment->status) == $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Payment Date (Read-only) -->
                            <div>
                                <label for="payment_date" class="block text-sm font-medium text-gray-700">Payment Date</label>
                                <input type="text" id="payment_date" readonly
                                       value="{{ $payment->payment_date->format('Y-m-d H:i:s') }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
                                <p class="text-xs text-gray-500 mt-1">Payment date is automatically set and cannot be edited</p>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Update Payment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection