@extends('layouts.admin')

@section('title', 'Dashboard')

@section('header', 'Dashboard')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Product Details</h2>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.products.edit', $product->product_id) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Edit
                            </a>
                            <a href="{{ route('admin.products.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Back to Products
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Product Image -->
                        <div class="md:col-span-1">
                            @if ($product->image_url)
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-auto object-cover rounded-lg shadow">
                            @else
                                <div class="w-full h-64 bg-gray-200 rounded-lg shadow flex items-center justify-center">
                                    <span class="text-gray-500">No image available</span>
                                </div>
                            @endif
                        </div>

                        <!-- Product Details -->
                        <div class="md:col-span-2 space-y-6">
                            <div>
                                <div class="flex justify-between items-center">
                                    <h3 class="text-xl font-bold text-gray-900">{{ $product->name }}</h3>
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $product->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">Product ID: {{ $product->product_id }}</p>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Category</h4>
                                    <p class="text-base text-gray-900">{{ $product->category->name ?? 'N/A' }}</p>
                                </div>
                                
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Price</h4>
                                    <p class="text-base text-gray-900">${{ number_format($product->price, 2) }}</p>
                                </div>
                                
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Stock Quantity</h4>
                                    <p class="text-base text-gray-900">{{ $product->stock_quantity }}</p>
                                </div>
                                
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Created</h4>
                                    <p class="text-base text-gray-900">{{ $product->created_at->format('M d, Y') }}</p>
                                </div>
                                
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Last Updated</h4>
                                    <p class="text-base text-gray-900">{{ $product->updated_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                            
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Description</h4>
                                <div class="mt-2 prose max-w-none text-gray-900">
                                    {{ $product->description ?? 'No description available.' }}
                                </div>
                            </div>
                            
                            <!-- Related Information -->
                            <div class="pt-4 border-t border-gray-200">
                                <h4 class="text-lg font-medium text-gray-700 mb-3">Related Information</h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <h5 class="text-sm font-medium text-gray-500">Reviews</h5>
                                        <p class="text-base text-gray-900">{{ $product->reviews->count() }} review(s)</p>
                                    </div>
                                    
                                    <div>
                                        <h5 class="text-sm font-medium text-gray-500">Gift Boxes</h5>
                                        <p class="text-base text-gray-900">
                                            Used in {{ $product->flowerGiftBoxes->count() + $product->chocolateGiftBoxes->count() + $product->packagingGiftBoxes->count() }} gift box(es)
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection