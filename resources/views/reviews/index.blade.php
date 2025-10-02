@extends('layouts.frontend')

@section('title', 'Reviews')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Customer Reviews</h1>
    <div id="reviewsContainer">
        <p class="text-gray-500">Loading reviews...</p>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    axios.get('/api/admin/reviews')
        .then(response => {
            const container = document.getElementById('reviewsContainer');
            // Render your reviews here
            console.log(response.data);
        })
        .catch(error => {
            console.error('Error loading reviews:', error);
        });
});
</script>
@endpush
@endsection