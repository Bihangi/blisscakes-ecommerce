<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">User Management</h1>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow p-6">
        <p>User management functionality</p>
    </div>
</div>