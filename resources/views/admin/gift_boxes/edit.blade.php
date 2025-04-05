@extends('layouts.admin')

@section('title', 'Dashboard')

@section('header', 'Dashboard')

@section('content')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('admin.gift-boxes.update', $giftBox) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-6">
                            <label for="order_id" class="block text-sm font-medium text-gray-700">Associated Order (Optional)</label>
                            <select id="order_id" name="order_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">-- No Associated Order --</option>
                                @foreach ($orders as $order)
                                    <option value="{{ $order->order_id }}" {{ $giftBox->order_id == $order->order_id ? 'selected' : '' }}>
                                        Order #{{ $order->order_id }}
                                    </option>
                                @endforeach
                            </select>
                            @error('order_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="flower_id" class="block text-sm font-medium text-gray-700">Flower</label>
                            <select id="flower_id" name="flower_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                <option value="">-- Select Flower --</option>
                                @foreach ($flowers as $flower)
                                    <option value="{{ $flower->product_id }}" {{ $giftBox->flower_id == $flower->product_id ? 'selected' : '' }}>
                                        {{ $flower->name }} - ${{ number_format($flower->price, 2) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('flower_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="chocolate_id" class="block text-sm font-medium text-gray-700">Chocolate</label>
                            <select id="chocolate_id" name="chocolate_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                <option value="">-- Select Chocolate --</option>
                                @foreach ($chocolates as $chocolate)
                                    <option value="{{ $chocolate->product_id }}" {{ $giftBox->chocolate_id == $chocolate->product_id ? 'selected' : '' }}>
                                        {{ $chocolate->name }} - ${{ number_format($chocolate->price, 2) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('chocolate_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="packaging_id" class="block text-sm font-medium text-gray-700">Packaging</label>
                            <select id="packaging_id" name="packaging_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                <option value="">-- Select Packaging --</option>
                                @foreach ($packagings as $packaging)
                                    <option value="{{ $packaging->product_id }}" {{ $giftBox->packaging_id == $packaging->product_id ? 'selected' : '' }}>
                                        {{ $packaging->name }} - ${{ number_format($packaging->price, 2) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('packaging_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                            <input type="number" name="quantity" id="quantity" value="{{ old('quantity', $giftBox->quantity) }}" min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            @error('quantity')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">$</span>
                                </div>
                                <input type="number" name="price" id="price" value="{{ old('price', $giftBox->price) }}" step="0.01" min="0" class="pl-7 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            </div>
                            @error('price')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="custom_message" class="block text-sm font-medium text-gray-700">Custom Message (Optional)</label>
                            <textarea name="custom_message" id="custom_message" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('custom_message', $giftBox->custom_message) }}</textarea>
                            @error('custom_message')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <a href="{{ route('admin.gift-boxes.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Cancel
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Gift Box
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script src="{{ asset('js/gift-box-calculator.js') }}"></script>
@endsection