@extends('layouts.admin')


@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Review Details</h1>
                <div>

                    <a href="{{ route('admin.reviews.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                        Back to Reviews
                    </a>
                </div>
            </div>

            <!-- Review Details Card -->
            <div class="bg-white shadow-sm rounded-md overflow-hidden">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Review Info -->
                        <div>
                            <dl>
                                <div class="mb-4">
                                    <dt class="text-sm font-medium text-gray-500">Review ID</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $review->review_id }}</dd>
                                </div>
                                <div class="mb-4">
                                    <dt class="text-sm font-medium text-gray-500">User</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $review->user->first_name . ' ' . $review->user->last_name ?? 'N/A' }}
                                        @if ($review->user)
                                            <span class="text-gray-500">({{ $review->user->email }})</span>
                                        @endif
                                    </dd>
                                </div>
                                <div class="mb-4">
                                    <dt class="text-sm font-medium text-gray-500">Product</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $review->product->name ?? 'N/A' }}</dd>
                                </div>
                                <div class="mb-4">
                                    <dt class="text-sm font-medium text-gray-500">Rating</dt>
                                    <dd class="mt-1 flex items-center">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg class="w-5 h-5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.799-2.034c-.784-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                </path>
                                            </svg>
                                        @endfor
                                        <span class="ml-2 text-sm text-gray-900">{{ $review->rating }}/5</span>
                                    </dd>
                                </div>
                                <div class="mb-4">
                                    <dt class="text-sm font-medium text-gray-500">Date Created</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $review->created_at->format('F d, Y \a\t h:i A') }}</dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Comment Section -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Comment</h3>
                            <div class="mt-2 bg-gray-50 p-4 rounded-md border border-gray-200 min-h-32">
                                <p class="text-sm text-gray-700 whitespace-pre-line">
                                    {{ $review->comment ?? 'No comment provided.' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Button -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md"
                                onclick="return confirm('Are you sure you want to delete this review?')">
                                Delete Review
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
