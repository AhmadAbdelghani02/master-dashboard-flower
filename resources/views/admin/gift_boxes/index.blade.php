
@extends('layouts.admin')

@section('title', 'Dashboard')

@section('header', 'Dashboard')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    @if (session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="flex justify-between mb-6">
                        <h3 class="text-lg font-semibold">All Gift Boxes</h3>
                        <a href="{{ route('admin.gift-boxes.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Add New Gift Box
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        ID
                                    </th>
                                    <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Order
                                    </th>
                                    <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Flower
                                    </th>
                                    <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Chocolate
                                    </th>
                                    <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Quantity
                                    </th>
                                    <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Price
                                    </th>
                                    <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Created
                                    </th>
                                    <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($giftBoxes as $giftBox)
                                    <tr>
                                        <td class="py-4 px-4 text-sm text-gray-500">
                                            {{ $giftBox->box_id }}
                                        </td>
                                        <td class="py-4 px-4 text-sm text-gray-500">
                                            {{ $giftBox->order ? "#" . $giftBox->order->order_id : 'No Order' }}
                                        </td>
                                        <td class="py-4 px-4 text-sm text-gray-500">
                                            {{ $giftBox->flower->name ?? 'N/A' }}
                                        </td>
                                        <td class="py-4 px-4 text-sm text-gray-500">
                                            {{ $giftBox->chocolate->name ?? 'N/A' }}
                                        </td>
                                        <td class="py-4 px-4 text-sm text-gray-500">
                                            {{ $giftBox->quantity }}
                                        </td>
                                        <td class="py-4 px-4 text-sm text-gray-500">
                                            ${{ number_format($giftBox->price, 2) }}
                                        </td>
                                        <td class="py-4 px-4 text-sm text-gray-500">
                                            {{ $giftBox->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="py-4 px-4 text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('admin.gift-boxes.show', $giftBox) }}" class="text-blue-600 hover:text-blue-900">
                                                    View
                                                </a>
                                                <a href="{{ route('admin.gift-boxes.edit', $giftBox) }}" class="text-indigo-600 hover:text-indigo-900">
                                                    Edit
                                                </a>
                                                <form action="{{ route('admin.gift-boxes.destroy', $giftBox) }}" method="POST" class="inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this gift box?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="py-4 px-4 text-sm text-gray-500 text-center">
                                            No gift boxes found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $giftBoxes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection