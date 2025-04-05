@extends('layouts.admin')

@section('title', 'Dashboard')

@section('header', 'Dashboard')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Shipments</h2>
                        <a href="{{ route('admin.shipments.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                            Add New Shipment
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-3 px-4 text-left">ID</th>
                                    <th class="py-3 px-4 text-left">Order ID</th>
                                    <th class="py-3 px-4 text-left">Shipping Date</th>
                                    <th class="py-3 px-4 text-left">Estimated Delivery</th>
                                    <th class="py-3 px-4 text-left">Actual Delivery</th>
                                    <th class="py-3 px-4 text-left">Status</th>
                                    <th class="py-3 px-4 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($shipments as $shipment)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3 px-4">{{ $shipment->shipment_id }}</td>
                                        <td class="py-3 px-4">{{ $shipment->order_id }}</td>
                                        <td class="py-3 px-4">{{ $shipment->shipping_date ? $shipment->shipping_date->format('Y-m-d') : 'N/A' }}</td>
                                        <td class="py-3 px-4">{{ $shipment->estimated_delivery ? $shipment->estimated_delivery->format('Y-m-d') : 'N/A' }}</td>
                                        <td class="py-3 px-4">{{ $shipment->actual_delivery ? $shipment->actual_delivery->format('Y-m-d') : 'N/A' }}</td>
                                        <td class="py-3 px-4">
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
                                        </td>
                                        <td class="py-3 px-4">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('admin.shipments.show', $shipment->shipment_id) }}" class="text-blue-600 hover:text-blue-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>
                                                <a href="{{ route('admin.shipments.edit', $shipment->shipment_id) }}" class="text-yellow-600 hover:text-yellow-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                                <form action="{{ route('admin.shipments.destroy', $shipment->shipment_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this shipment?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-3 px-4 text-center text-gray-500">No shipments found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $shipments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/shipments.js') }}"></script>
@endsection