<footer style="background-color: rgb(235, 168, 168);" class="text-black pt-8 pb-6">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 text-sm text-center md:text-left">
      
      <!-- Quick Links -->
      <div>
        <h4 class="text-xl font-semibold mb-4">Quick Links</h4>
        <ul class="space-y-2">
          <li><a href="{{ route('home') }}" class="hover:underline hover:text-white transition">Home</a></li>
          <li><a href="{{ route('cakes.browse') }}" class="hover:underline hover:text-white transition">Cakes</a></li>
          @auth
            <li><a href="{{ route('cart') }}" class="hover:underline hover:text-white transition">Cart</a></li>
            <li><a href="{{ route('orders') }}" class="hover:underline hover:text-white transition">My Account</a></li>
          @endauth
        </ul>
      </div>

      <!-- Contact Info -->
      <div>
        <h4 class="text-xl font-bold mb-4">Contact Us</h4>
        <ul class="space-y-3">
          <li class="flex items-center justify-center md:justify-start gap-2">
            <i class="fas fa-envelope"></i>
            <span>blisscakes@gmail.com</span>
          </li>
          <li class="flex items-center justify-center md:justify-start gap-2">
            <i class="fas fa-phone-alt"></i>
            <span>+94 72 123 1234</span>
          </li>
          <li class="flex items-center justify-center md:justify-start gap-2">
            <i class="fas fa-map-marker-alt"></i>
            <span>BlissCakes, KCC, Kandy</span>
          </li>
        </ul>
      </div>

      <!-- Social Media -->
      <div>
        <h4 class="text-xl font-semibold mb-4">Find Us On</h4>
        <div class="flex justify-center md:justify-start gap-4 text-lg">
          <a href="#" class="hover:text-white transition"><i class="fab fa-pinterest"></i></a>
          <a href="#" class="hover:text-white transition"><i class="fab fa-youtube"></i></a>
          <a href="#" class="hover:text-white transition"><i class="fab fa-instagram"></i></a>
          <a href="#" class="hover:text-white transition"><i class="fab fa-facebook"></i></a>
        </div>
      </div>
    </div>

    <div class="border-t border-black mt-8 pt-4 text-center text-xs sm:text-sm">
      <p>&copy; {{ date('Y') }} BlissCakes. All rights reserved.</p>
    </div>
  </div>
</footer>