<div class="min-h-screen bg-gradient-to-br from-slate-50 via-gray-50 to-slate-100">
    <div class="container mx-auto px-4 sm:px-6 lg:px-16 xl:px-24 py-10">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-slate-900 mb-2">Admin Dashboard</h1>
                    <p class="text-slate-600 flex items-center gap-2">
                        <i class="fas fa-user-shield text-blue-600"></i>
                        Welcome back, <span class="font-semibold">{{ auth()->user()->name }}</span>
                    </p>
                </div>
                <div class="hidden md:block text-right">
                    <p class="text-sm text-slate-500">Last login</p>
                    <p class="text-sm font-semibold text-slate-700">{{ now()->format('M d, Y - h:i A') }}</p>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if (session()->has('message'))
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 p-4 rounded-xl mb-6 shadow-sm">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-check text-white"></i>
                    </div>
                    <span class="text-green-800 font-medium">{{ session('message') }}</span>
                </div>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <!-- Total Orders -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-blue-100 hover:shadow-xl hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-shopping-bag text-2xl text-white"></i>
                    </div>
                    <span class="text-xs font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-full">All Time</span>
                </div>
                <p class="text-sm font-semibold text-slate-600 mb-1">Total Orders</p>
                <p class="text-4xl font-bold text-slate-900">{{ $stats['total_orders'] }}</p>
            </div>

            <!-- Pending Orders -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-amber-100 hover:shadow-xl hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-amber-500 to-orange-500 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-clock text-2xl text-white"></i>
                    </div>
                    <span class="text-xs font-bold text-amber-600 bg-amber-50 px-3 py-1 rounded-full">Active</span>
                </div>
                <p class="text-sm font-semibold text-slate-600 mb-1">Pending Orders</p>
                <p class="text-4xl font-bold text-slate-900">{{ $stats['pending_orders'] }}</p>
            </div>

            <!-- Total Customers -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-emerald-100 hover:shadow-xl hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-users text-2xl text-white"></i>
                    </div>
                    <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full">Users</span>
                </div>
                <p class="text-sm font-semibold text-slate-600 mb-1">Total Customers</p>
                <p class="text-4xl font-bold text-slate-900">{{ $stats['total_customers'] }}</p>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mb-8">
            <h2 class="text-xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                <i class="fas fa-bolt text-amber-500"></i>
                Quick Actions
            </h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('admin.orders') }}" class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition-all transform hover:-translate-y-1 border-2 border-transparent hover:border-blue-200 group">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl mx-auto mb-3 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-clipboard-list text-2xl text-blue-600"></i>
                    </div>
                    <p class="font-bold text-slate-900 text-sm text-center">Manage Orders</p>
                    <p class="text-xs text-slate-500 text-center mt-1">View & process</p>
                </a>

                <a href="{{ route('admin.cakes') }}" class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition-all transform hover:-translate-y-1 border-2 border-transparent hover:border-rose-200 group">
                    <div class="w-14 h-14 bg-gradient-to-br from-rose-100 to-pink-200 rounded-xl mx-auto mb-3 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-birthday-cake text-2xl text-rose-600"></i>
                    </div>
                    <p class="font-bold text-slate-900 text-sm text-center">Manage Cakes</p>
                    <p class="text-xs text-slate-500 text-center mt-1">Add & edit</p>
                </a>

                <a href="{{ route('admin.categories') }}" class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition-all transform hover:-translate-y-1 border-2 border-transparent hover:border-purple-200 group">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-100 to-violet-200 rounded-xl mx-auto mb-3 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-tags text-2xl text-purple-600"></i>
                    </div>
                    <p class="font-bold text-slate-900 text-sm text-center">Categories</p>
                    <p class="text-xs text-slate-500 text-center mt-1">Organize</p>
                </a>

                <a href="{{ route('admin.users') }}" class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition-all transform hover:-translate-y-1 border-2 border-transparent hover:border-emerald-200 group">
                    <div class="w-14 h-14 bg-gradient-to-br from-emerald-100 to-teal-200 rounded-xl mx-auto mb-3 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-users-cog text-2xl text-emerald-600"></i>
                    </div>
                    <p class="font-bold text-slate-900 text-sm text-center">Manage Users</p>
                    <p class="text-xs text-slate-500 text-center mt-1">View & manage</p>
                </a>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border-2 border-slate-100">
            <div class="bg-gradient-to-r from-slate-50 to-gray-50 px-6 py-5 border-b-2 border-slate-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-slate-900 flex items-center gap-2">
                            <i class="fas fa-list-alt text-blue-600"></i>
                            Recent Orders
                        </h3>
                        <p class="text-sm text-slate-600 mt-1">Latest customer orders requiring attention</p>
                    </div>
                    <a href="{{ route('admin.orders') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-full text-sm font-bold shadow-md hover:shadow-lg transition-all flex items-center gap-2">
                        View All
                        <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y-2 divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Order ID</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        @forelse($recentOrders as $order)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-full">#{{ $order->id }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div>
                                            <span class="text-sm font-semibold text-slate-900 block">{{ $order->user->name }}</span>
                                            <span class="text-xs text-slate-500">{{ $order->user->email }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-base font-bold text-slate-900">Rs. {{ number_format($order->total_amount, 2) }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1.5 inline-flex text-xs leading-5 font-bold rounded-full shadow-sm
                                        @if($order->status === 'pending') bg-gradient-to-r from-amber-100 to-yellow-100 text-amber-800 border border-amber-200
                                        @elseif($order->status === 'confirmed') bg-gradient-to-r from-blue-100 to-cyan-100 text-blue-800 border border-blue-200
                                        @elseif($order->status === 'preparing') bg-gradient-to-r from-orange-100 to-amber-100 text-orange-800 border border-orange-200
                                        @elseif($order->status === 'ready') bg-gradient-to-r from-purple-100 to-violet-100 text-purple-800 border border-purple-200
                                        @elseif($order->status === 'delivered') bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border border-green-200
                                        @else bg-gradient-to-r from-red-100 to-rose-100 text-red-800 border border-red-200
                                        @endif">
                                        <i class="fas fa-circle text-xs mr-1"></i>
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <p class="text-sm font-semibold text-slate-900">{{ $order->created_at->format('M d, Y') }}</p>
                                        <p class="text-xs text-slate-500">{{ $order->created_at->format('h:i A') }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($order->status !== 'delivered' && $order->status !== 'cancelled')
                                        <select wire:change="updateOrderStatus({{ $order->id }}, $event.target.value)" 
                                                class="border-2 border-slate-200 rounded-lg shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-sm font-semibold bg-white hover:bg-slate-50 transition">
                                            <option value="">Update Status</option>
                                            <option value="confirmed" @if($order->status === 'confirmed') disabled @endif>✓ Confirm</option>
                                            <option value="preparing" @if($order->status === 'preparing') disabled @endif>👨‍🍳 Preparing</option>
                                            <option value="ready" @if($order->status === 'ready') disabled @endif>✓ Ready</option>
                                            <option value="delivered">🚚 Delivered</option>
                                            <option value="cancelled">✗ Cancel</option>
                                        </select>
                                    @else
                                        <span class="text-slate-400 text-xs font-medium bg-slate-50 px-3 py-1.5 rounded-full">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Completed
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="text-slate-400">
                                        <i class="fas fa-inbox text-6xl mb-4"></i>
                                        <p class="text-base font-semibold">No orders found</p>
                                        <p class="text-sm mt-1">Orders will appear here once customers place them</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>