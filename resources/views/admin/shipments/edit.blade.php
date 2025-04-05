@extends('layouts.admin')

@section('title', 'Dashboard')

@section('header', 'Dashboard')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Edit Shipment #{{ $shipment->shipment_id }}</h2>
                        <a href="{{ route('admin.shipments.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition">
                            Back to Shipments
                        </a>
                    </div>

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.shipments.update', $shipment->shipment_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="order_id" class="block text-sm font-medium text-gray-700">Order</label>
                                <select id="order_id" name="order_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                    <option value="">Select an Order</option>
                                    @foreach ($orders as $order)
                                        <option value="{{ $order->order_id }}" {{ (old('order_id', $shipment->order_id) == $order->order_id) ? 'selected' : '' }}>
                                            #{{ $order->order_id }} - {{ $order->order_date->format('Y-m-d') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select id="status" name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                    <option value="">Select a Status</option>
                                    <option value="Processing" {{ old('status', $shipment->status) == 'Processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="Packed" {{ old('status', $shipment->status) == 'Packed' ? 'selected' : '' }}>Packed</option>
                                    <option value="In Transit" {{ old('status', $shipment->status) == 'In Transit' ? 'selected' : '' }}>In Transit</option>
                                    <option value="Delivered" {{ old('status', $shipment->status) == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="Cancelled" {{ old('status', $shipment->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>

                            <div>
                                <label for="shipping_date" class="block text-sm font-medium text-gray-700">Shipping Date</label>
                                <input type="date" name="shipping_date" id="shipping_date" 
                                    value="{{ old('shipping_date', $shipment->shipping_date ? $shipment->shipping_date->format('Y-m-d') : '') }}" 
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div>
                                <label for="estimated_delivery" class="block text-sm font-medium text-gray-700">Estimated Delivery Date</label>
                                <input type="date" name="estimated_delivery" id="estimated_delivery" 
                                    value="{{ old('estimated_delivery', $shipment->estimated_delivery ? $shipment->estimated_delivery->format('Y-m-d') : '') }}" 
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div>
                                <label for="actual_delivery" class="block text-sm font-medium text-gray-700">Actual Delivery Date</label>
                                <input type="date" name="actual_delivery" id="actual_delivery" 
                                    value="{{ old('actual_delivery', $shipment->actual_delivery ? $shipment->actual_delivery->format('Y-m-d') : '') }}" 
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                                Update Shipment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/shipments.js') }}"></script>
@endsection