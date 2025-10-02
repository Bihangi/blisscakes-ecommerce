@extends('layouts.frontend')

@section('title', 'About Us - BlissCakes')

@section('content')

<!-- Hero Section -->
<div class="relative bg-gradient-to-br from-rose-50 via-pink-50 to-rose-100 py-16 md:py-24">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center">
      <h1 class="text-4xl md:text-5xl lg:text-5xl font-bold text-gray-900 mb-6">
        Welcome to <span class="text-rose-600">BlissCakes</span>
      </h1>
      <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
        Where every cake tells a story and every bite creates a memory
      </p>
    </div>
  </div>
</div>

<!-- Our Story Section -->
<section class="py-16 bg-stone-50">
  <div class="container mx-auto px-6 md:px-12 lg:px-24">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
      <div>
        <h2 class="text-3xl md:text-4xl font-bold text-stone-800 mb-6">Our Story</h2>
        <p class="text-stone-600 mb-4 leading-relaxed">
          BlissCakes was born from a simple passion: creating beautiful, delicious cakes that bring joy to every celebration. What started as a small home bakery in Kandy has grown into a beloved destination for cake lovers across Sri Lanka.
        </p>
        <p class="text-stone-600 mb-4 leading-relaxed">
          Our journey began when our founder discovered that the secret ingredient to any great cake isn't just quality ingredients or skilled baking—it's the love and care poured into every creation. This philosophy continues to guide us today.
        </p>
        <p class="text-stone-600 leading-relaxed">
          Today, we're proud to serve hundreds of happy customers, turning their cake dreams into delicious reality for birthdays, weddings, anniversaries, and every special moment in between.
        </p>
      </div>
       <div class="relative lg:pl-8">
        <img src="{{ asset('images/about-story.jpg') }}" alt="Our Story" class="rounded-2xl shadow-xl w-full h-auto">
        <div class="absolute -bottom-6 left-8 bg-stone-800 text-white p-6 rounded-lg shadow-xl">
            <p class="text-4xl font-bold">4+</p>
            <p class="text-sm">Years of Excellence</p>
        </div>
        </div>
    </div>
  </div>
</section>

<!-- Our Values Section -->
<section class="py-16 md:py-20 bg-gray-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-12">
      <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Our Values</h2>
      <p class="text-lg text-gray-600 max-w-2xl mx-auto">
        The principles that guide everything we do
      </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition-shadow">
        <div class="w-16 h-16 bg-gradient-to-br from-rose-400 to-pink-500 rounded-full flex items-center justify-center mb-6 mx-auto">
          <i class="fas fa-heart text-2xl text-white"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">Quality First</h3>
        <p class="text-gray-600 text-center leading-relaxed">
          We use only the finest ingredients and never compromise on quality. Every cake is baked fresh daily with premium materials.
        </p>
      </div>

      <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition-shadow">
        <div class="w-16 h-16 bg-gradient-to-br from-rose-400 to-pink-500 rounded-full flex items-center justify-center mb-6 mx-auto">
          <i class="fas fa-users text-2xl text-white"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">Customer Focus</h3>
        <p class="text-gray-600 text-center leading-relaxed">
          Your satisfaction is our priority. We listen to your needs and work tirelessly to exceed your expectations every time.
        </p>
      </div>

      <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition-shadow">
        <div class="w-16 h-16 bg-gradient-to-br from-rose-400 to-pink-500 rounded-full flex items-center justify-center mb-6 mx-auto">
          <i class="fas fa-lightbulb text-2xl text-white"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">Innovation</h3>
        <p class="text-gray-600 text-center leading-relaxed">
          We constantly explore new flavors, designs, and techniques to bring you unique and memorable cake experiences.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- Our Team Section -->
<section class="py-16 bg-stone-50">
  <div class="container mx-auto px-6 md:px-12 lg:px-24">
    <div class="text-center mb-12">
      <h2 class="text-3xl md:text-4xl font-bold text-stone-800 mb-4">Meet Our Team</h2>
      <p class="text-stone-600 text-lg">The talented people behind your favorite cakes</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <div class="text-center">
        <div class="w-48 h-48 mx-auto mb-6 rounded-full bg-gradient-to-br from-amber-200 to-orange-300 flex items-center justify-center overflow-hidden">
          <img src="{{ asset('images/team-member-1.jpg') }}" alt="Team Member" class="w-full h-full object-cover">
        </div>
        <h3 class="text-xl font-bold text-stone-800 mb-2">Sarah Déabrew</h3>
        <p class="text-amber-700 font-medium mb-2">Head Baker</p>
        <p class="text-stone-600 text-sm">15+ years of baking expertise</p>
      </div>

      <div class="text-center">
        <div class="w-48 h-48 mx-auto mb-6 rounded-full bg-gradient-to-br from-emerald-200 to-teal-300 flex items-center justify-center overflow-hidden">
          <img src="{{ asset('images/team-member-2.jpg') }}" alt="Team Member" class="w-full h-full object-cover">
        </div>
        <h3 class="text-xl font-bold text-stone-800 mb-2">Pradeep Gamage</h3>
        <p class="text-emerald-700 font-medium mb-2">Cake Designer</p>
        <p class="text-stone-600 text-sm">Creative genius behind custom designs</p>
      </div>

      <div class="text-center">
        <div class="w-48 h-48 mx-auto mb-6 rounded-full bg-gradient-to-br from-sky-200 to-blue-300 flex items-center justify-center overflow-hidden">
          <img src="{{ asset('images/team-member-3.jpeg') }}" alt="Team Member" class="w-full h-full object-cover">
        </div>
        <h3 class="text-xl font-bold text-stone-800 mb-2">Hashini Perera</h3>
        <p class="text-sky-700 font-medium mb-2">Customer Relations</p>
        <p class="text-stone-600 text-sm">Your friendly point of contact</p>
      </div>
    </div>
  </div>
</section>

<!-- Stats Section -->
<section class="py-16 bg-stone-800 text-white">
  <div class="container mx-auto px-6 md:px-12 lg:px-24">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
      <div>
        <p class="text-4xl md:text-5xl font-bold mb-2">2000+</p>
        <p class="text-white/80">Happy Customers</p>
      </div>
      <div>
        <p class="text-4xl md:text-5xl font-bold mb-2">5000+</p>
        <p class="text-white/80">Cakes Delivered</p>
      </div>
      <div>
        <p class="text-4xl md:text-5xl font-bold mb-2">50+</p>
        <p class="text-white/80">Cake Varieties</p>
      </div>
      <div>
        <p class="text-4xl md:text-5xl font-bold mb-2">4.9</p>
        <p class="text-white/80">Average Rating</p>
      </div>
    </div>
  </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-white">
  <div class="container mx-auto px-6 md:px-12 lg:px-24 text-center">
    <h2 class="text-3xl md:text-4xl font-bold text-stone-800 mb-4">Ready to Order?</h2>
    <p class="text-stone-600 text-lg mb-8 max-w-2xl mx-auto">
      Browse our collection and let us create something special for your next celebration
    </p>
    <a href="{{ route('cakes.browse') }}" class="inline-block bg-stone-800 text-white px-10 py-4 text-lg font-semibold rounded-full hover:bg-stone-900 transition duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
      View Our Cakes
    </a>
  </div>
</section>

@endsection