<!-- resources/views/layouts/admin.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - GiftBox Admin</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Optional: Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Alpine.js for interactivity (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    @yield('styles')
</head>
<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64 bg-gray-800">
                <div class="flex items-center justify-center h-16 bg-gray-900">
                    <span class="text-white font-bold text-lg">GiftBox Admin</span>
                </div>
                <div class="flex flex-col flex-grow overflow-y-auto">
                    <nav class="flex-1 px-2 py-4 space-y-1">
                        <x-admin-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            {{-- {{ route('admin.dashboard') }} --}}
                            <i class="fas fa-home mr-3"></i>
                            Dashboard
                        </x-admin-link>

                        <x-admin-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')">
                            <i class="fas fa-users mr-3"></i>
                            Users
                        </x-admin-link>
                        <x-admin-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.index')">
                        <i class="fas fa-box mr-3"></i>
                            Products
                        </x-admin-link>
                        <x-admin-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.index')">
                            {{-- {{ route('admin.dashboard') }} --}}
                            <i class="fas fa-tag mr-3"></i>
                            Categories
                        </x-admin-link>

                        <x-admin-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.index')">
                            {{-- {{ route('admin.dashboard') }} --}}
                            <i class="fas fa-shopping-cart mr-3"></i>
                            Orders
                        </x-admin-link>
                        <x-admin-link :href="route('admin.gift-boxes.index')" :active="request()->routeIs('admin.gift-boxes.index')">
                            {{-- {{ route('admin.dashboard') }} --}}
                            <i class="fas fa-gift mr-3"></i>
                            Gift Boxes
                        </x-admin-link>
                        <x-admin-link :href="route('admin.promotions.index')" :active="request()->routeIs('admin.promotions.index')">
                            {{-- {{ route('admin.promotions') }} --}}
                            <i class="fas fa-percent mr-3"></i>
                            Promotions
                        </x-admin-link>
                        <a href="#" class="flex items-center px-4 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-gray-700 hover:text-white">
                            {{-- {{ route('admin.reviews') }} --}}
                            <i class="fas fa-star mr-3"></i>
                            Reviews
                        </a>

                        <x-admin-link :href="route('admin.shipments.index')" :active="request()->routeIs('admin.shipments.index')">
                            {{-- {{ route('admin.promotions') }} --}}
                            <i class="fas fa-truck mr-3"></i>
                            Shipments
                        </x-admin-link>

                        <x-admin-link :href="route('admin.payments.index')" :active="request()->routeIs('admin.payments.index')">
                            {{-- {{ route('admin.promotions') }} --}}
                            <i class="fas fa-credit-card mr-3"></i>
                            Payments
                        </x-admin-link>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Top navigation -->
            <header class="bg-white shadow">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16">
                        <!-- Mobile menu button -->
                        <div class="flex items-center md:hidden">
                            <button type="button" class="text-gray-500 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                                <i class="fas fa-bars"></i>
                            </button>
                        </div>
                        
                        <!-- Page title -->
                        <div class="flex-1 flex justify-between px-4 md:px-0">
                            <div class="flex-1">
                                <h2 class="text-2xl font-bold text-gray-800">@yield('header', 'Dashboard')</h2>
                            </div>
                            
                            <!-- User Dropdown -->
<div class="ml-4 flex items-center md:ml-6" x-data="{ open: false }">
    <div class="relative">
        <button @click="open = !open" type="button" class="flex items-center max-w-xs rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <img class="h-8 w-8 rounded-full" src="https://via.placeholder.com/40" alt="User profile">
            <span class="ml-2 text-gray-700">Admin User</span>
            <i class="fas fa-chevron-down ml-1 text-gray-400"></i>
        </button>

        <!-- Dropdown Menu -->
        <div x-show="open" @click.outside="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg z-50">
            <!-- Profile Link -->
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                Profile
                {{-- {{ route('profile.show') }} --}}
            </a>

            <!-- Logout Form -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    Log Out
                </button>
            </form>
        </div>
    </div>
</div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page content -->
            <main class="flex-1 overflow-y-auto bg-gray-100 p-6">
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Mobile sidebar overlay -->
    <div class="md:hidden">
        <!-- Mobile menu, show/hide based on mobile menu state -->
        <div class="fixed inset-0 z-40 flex">
            <!-- Off-canvas menu overlay, show/hide based on off-canvas menu state -->
            <div class="fixed inset-0">
                <div class="absolute inset-0 bg-gray-600 opacity-75"></div>
            </div>
            
            <!-- Off-canvas menu, show/hide based on off-canvas menu state -->
            <div class="relative flex-1 flex flex-col max-w-xs w-full bg-gray-800">
                <div class="absolute top-0 right-0 -mr-12 pt-2">
                    <button type="button" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                        <span class="sr-only">Close sidebar</span>
                        <i class="fas fa-times text-white"></i>
                    </button>
                </div>
                
                <div class="flex items-center justify-center h-16 bg-gray-900">
                    <span class="text-white font-bold text-lg">GiftBox Admin</span>
                </div>
                
                <div class="mt-5 flex-1 h-0 overflow-y-auto">
                    <nav class="px-2 space-y-1">
                        <!-- Same links as sidebar -->
                        <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md text-white bg-gray-700">
                            {{-- {{ route('admin.dashboard') }} --}}
                            <i class="fas fa-home mr-4 text-gray-300"></i>
                            Dashboard
                        </a>
                        <!-- ... other links ... -->
                    </nav>
                </div>
            </div>
        </div>
    </div>

    @yield('scripts')
</body>
</html>