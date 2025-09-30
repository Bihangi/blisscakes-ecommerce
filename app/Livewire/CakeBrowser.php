<?php

namespace App\Livewire;

use App\Models\Cake;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class CakeBrowser extends Component
{
    use WithPagination;

    public $search = '';
    public $categoryFilter = '';
    public $flavorFilter = '';
    public $occasionFilter = '';
    public $priceRange = '';
    public $dietaryFilter = '';
    public $sortBy = 'latest';
    
    public $selectedCake = null;
    public $showCakeDetails = false;
    public $quantity = 1;
    public $customizations = [];

    public function render()
    {
        $cakes = Cake::with('category')
            ->available()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->categoryFilter, function ($query) {
                $query->where('category_id', $this->categoryFilter);
            })
            ->when($this->flavorFilter, function ($query) {
                $query->where('flavor', $this->flavorFilter);
            })
            ->when($this->occasionFilter, function ($query) {
                $query->where('occasion', $this->occasionFilter);
            })
            ->when($this->dietaryFilter, function ($query) {
                $query->whereJsonContains('dietary_options', $this->dietaryFilter);
            })
            ->when($this->priceRange, function ($query) {
                switch ($this->priceRange) {
                    case 'under-1000':
                        $query->where('price', '<', 1000);
                        break;
                    case '1000-2500':
                        $query->whereBetween('price', [1000, 2500]);
                        break;
                    case '2500-5000':
                        $query->whereBetween('price', [2500, 5000]);
                        break;
                    case 'above-5000':
                        $query->where('price', '>', 5000);
                        break;
                }
            })
            ->when($this->sortBy === 'price-low', function ($query) {
                $query->orderBy('price', 'asc');
            })
            ->when($this->sortBy === 'price-high', function ($query) {
                $query->orderBy('price', 'desc');
            })
            ->when($this->sortBy === 'latest', function ($query) {
                $query->latest();
            })
            ->when($this->sortBy === 'name', function ($query) {
                $query->orderBy('name');
            })
            ->paginate(12);

        $categories = Category::withCount(['cakes' => function ($query) {
            $query->available();
        }])->get();

        $flavors = Cake::available()->distinct('flavor')->pluck('flavor')->filter();
        $occasions = Cake::available()->distinct('occasion')->pluck('occasion')->filter();

        return view('livewire.cakes.browser', compact('cakes', 'categories', 'flavors', 'occasions'))
        ->layout('layouts.app');
    }

    public function viewCakeDetails($cakeId)
    {
        $this->selectedCake = Cake::with('category')->findOrFail($cakeId);
        $this->quantity = 1;
        $this->customizations = [];
        $this->showCakeDetails = true;
    }

    public function hideCakeDetails()
    {
        $this->showCakeDetails = false;
        $this->selectedCake = null;
        $this->quantity = 1;
        $this->customizations = [];
    }

    public function addToCart($cakeId = null, $quantity = null)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $cakeId = $cakeId ?? $this->selectedCake->id;
        $quantity = $quantity ?? $this->quantity;

        $cake = Cake::findOrFail($cakeId);
        $cart = auth()->user()->cart ?? auth()->user()->cart()->create();
        
        $existingItem = $cart->cartItems()->where('cake_id', $cakeId)->first();

        $cartData = [
            'cake_id' => $cakeId,
            'quantity' => $quantity,
            'price' => $cake->price,
            'customization' => $this->customizations
        ];

        if ($existingItem) {
            $existingItem->update([
                'quantity' => $existingItem->quantity + $quantity,
                'customization' => array_merge($existingItem->customization ?? [], $this->customizations)
            ]);
        } else {
            $cart->cartItems()->create($cartData);
        }

        session()->flash('message', 'Cake added to cart successfully!');
        $this->dispatch('cart-updated');
        $this->hideCakeDetails();
    }

    public function updatedCategoryFilter()
    {
        $this->resetPage();
    }

    public function updatedFlavorFilter()
    {
        $this->resetPage();
    }

    public function updatedOccasionFilter()
    {
        $this->resetPage();
    }

    public function updatedPriceRange()
    {
        $this->resetPage();
    }

    public function updatedDietaryFilter()
    {
        $this->resetPage();
    }

    public function updatedSortBy()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->categoryFilter = '';
        $this->flavorFilter = '';
        $this->occasionFilter = '';
        $this->priceRange = '';
        $this->dietaryFilter = '';
        $this->sortBy = 'latest';
        $this->resetPage();
    }
}