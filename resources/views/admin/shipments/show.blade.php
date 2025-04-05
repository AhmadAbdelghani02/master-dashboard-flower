@extends('layouts.admin')

@section('title', 'Dashboard')

@section('header', 'Dashboard')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Shipment Details #{{ $shipment->shipment_id }}</h2>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.shipments.edit', $shipment->shipment_id) }}" class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 transition">
                                Edit
                            </a>
                            <a href="{{ route('admin.shipments.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition">
                                Back to Shipments
                            </a>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-3">Shipment Information</h3>
                                <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">Shipment ID</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $shipment->shipment_id }}</dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">Order ID</dt>
                                        <dd class="mt-1 text-sm text-gray-900">#{{ $shipment->order_id }}</dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                                        <dd class="mt-1 text-sm">
                                            <span class="px-2 py-1 text-xs rounded-full 
                                                @if($shipment->status == 'Delivered') 
                                                    bg-green-100 text-green-800
                                                @elseif($shipment->status == 'In Transit') 
                                                    bg-blue-100 text-blue-800
                                                @elseif($shipment->status == 'Processing') 
                                                    bg-yellow-100 text-yellow-800
                                                @elseif($shipment->status == 'Cancelled') 
                                                    bg-red-100 text-red-800
                                                @else 
                                                    bg-gray-100 text-gray-800
                                                @endif
                                            ">
                                                {{ $shipment->status }}
                                            </span>
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                            
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-3">Timeline</h3>
                                <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                                    {{-- <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">Created At</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $shipment->order_date->format('Y-m-d H:i') }}</dd>
                                    </div> --}}
                                    {{-- <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $shipment->updated_at->format('Y-m-d H:i') }}</dd>
                                    </div> --}}
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">Shipping Date</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $shipment->shipping_date ? $shipment->shipping_date->format('Y-m-d') : 'Not set' }}</dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">Estimated Delivery</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $shipment->estimated_delivery ? $shipment->estimated_delivery->format('Y-m-d') : 'Not set' }}</dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">Actual Delivery</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $shipment->actual_delivery ? $shipment->actual_delivery->format('Y-m-d') : 'Not delivered yet' }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>

                        <div class="mt-8">
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-3">Order Information</h3>
                            @if($shipment->order)
                                <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-3">
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">Order Date</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $shipment->order->order_date->format('Y-m-d') }}</dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">Order Status</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $shipment->order->status ?? 'N/A' }}</dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">Customer</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $shipment->order->user->first_name ." ". $shipment->order->user->last_name ?? 'N/A' }}</dd>
                                    </div>
                                </dl>
                                <div class="mt-4">
                                    <a href="{{ route('admin.orders.show', $shipment->order_id) }}" class="text-blue-600 hover:text-blue-900">
                                        View full order details →
                                    </a>
                                </div>
                            @else
                                <p class="text-sm text-gray-500">Order information not available.</p>
                            @endif
                        </div>

                        <div class="mt-8 flex justify-between">
                            <form action="{{ route('admin.shipments.destroy', $shipment->shipment_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this shipment?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                                    Delete Shipment
                                </button>
                            </form>
                            
                            <a href="{{ route('admin.shipments.edit', $shipment->shipment_id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                                Edit Shipment
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/shipments.js') }}"></script>
@endsection