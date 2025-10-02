<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Cake;
use App\Models\Category;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CakeBrowser extends Component
{
    use WithPagination;

    public $categoryFilter = [];
    public $showCakeDetails = false;
    public $selectedCake = null;
    public $quantity = 1;

    public function mount()
    {
        if (request()->has('categoryFilter')) {
            $this->categoryFilter = is_array(request('categoryFilter')) 
                ? request('categoryFilter') 
                : [request('categoryFilter')];
        }
    }

    public function clearFilters()
    {
        $this->categoryFilter = [];
        $this->resetPage();
    }

    public function viewCakeDetails($cakeId)
    {
        $this->selectedCake = Cake::with('category')->find($cakeId);
        $this->showCakeDetails = true;
        $this->quantity = 1;
    }

    public function hideCakeDetails()
    {
        $this->showCakeDetails = false;
        $this->selectedCake = null;
        $this->quantity = 1;
    }

    public function incrementQuantity()
    {
        $this->quantity++;
    }

    public function decrementQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function addToCart($cakeId)
    {
        if (!Auth::check()) {
            session()->flash('error', 'Please login to add items to cart');
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        $cart = Cart::firstOrCreate(
            ['user_id' => $user->id],
            ['total_price' => 0]
        );

        $cake = Cake::find($cakeId);

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('cake_id', $cakeId)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $this->quantity;
            $cartItem->total_price = $cartItem->quantity * $cake->price;
            $cartItem->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'cake_id' => $cakeId,
                'quantity' => $this->quantity,
                'price' => $cake->price,
                'total_price' => $this->quantity * $cake->price,
            ]);
        }

        $cart->total_price = $cart->cartItems()->sum('total_price');
        $cart->save();

        session()->flash('success', 'Cake added to cart successfully!');
        $this->hideCakeDetails();
    }

    public function render()
    {
        $query = Cake::with('category')->where('is_available', true);

        if (!empty($this->categoryFilter)) {
            $query->whereIn('category_id', $this->categoryFilter);
        }

        $cakes = $query->paginate(9);
        $categories = Category::all();

        return view('livewire.cake-browser', [
            'cakes' => $cakes,
            'categories' => $categories,
        ])->layout('layouts.frontend'); 

    }
}