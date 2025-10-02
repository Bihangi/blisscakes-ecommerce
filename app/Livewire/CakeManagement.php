<?php

namespace App\Livewire;

use App\Models\Cake;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class CakeManagement extends Component
{
    use WithFileUploads, WithPagination;

    public $showCreateForm = false;
    public $showEditForm = false;
    public $editingCake = null;
    
    // Form properties
    public $name = '';
    public $description = '';
    public $price = '';
    public $category_id = '';
    public $image = null;
    public $flavor = '';
    public $size = '';
    public $occasion = '';
    public $is_available = true;
    public $ingredients = '';
    public $dietary_options = [];
    
    // Search and filter
    public $search = '';
    public $categoryFilter = '';
    public $flavorFilter = '';
    public $occasionFilter = '';

    // Available options
    public $flavorOptions = ['Chocolate', 'Vanilla', 'Strawberry', 'Red Velvet', 'Carrot', 'Lemon', 'Fruit'];
    public $sizeOptions = ['Small (6")', 'Medium (8")', 'Large (10")', 'Extra Large (12")'];
    public $occasionOptions = ['Birthday', 'Wedding', 'Anniversary', 'Graduation', 'Baby Shower', 'Corporate', 'Custom'];
    public $dietaryOptionsAvailable = ['Gluten-Free', 'Vegan', 'Sugar-Free', 'Dairy-Free', 'Nut-Free'];

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'category_id' => 'required|exists:categories,id',
        'image' => 'nullable|image|max:2048',
        'flavor' => 'nullable|string|max:100',
        'size' => 'nullable|string|max:50',
        'occasion' => 'nullable|string|max:100',
        'ingredients' => 'nullable|string',
        'dietary_options' => 'nullable|array',
        'is_available' => 'boolean'
    ];

    public function render()
    {
        $cakes = Cake::with('category')
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
            ->latest()
            ->paginate(12);

        $categories = Category::all();

        return view('livewire.cake-management', compact('cakes', 'categories'));
    }

    public function showCreateForm()
    {
        $this->showCreateForm = true;
        $this->resetForm();
    }

    public function hideCreateForm()
    {
        $this->showCreateForm = false;
        $this->resetForm();
    }

    public function editCake($cakeId)
    {
        $this->editingCake = Cake::findOrFail($cakeId);
        $this->name = $this->editingCake->name;
        $this->description = $this->editingCake->description;
        $this->price = $this->editingCake->price;
        $this->category_id = $this->editingCake->category_id;
        $this->flavor = $this->editingCake->flavor;
        $this->size = $this->editingCake->size;
        $this->occasion = $this->editingCake->occasion;
        $this->ingredients = $this->editingCake->ingredients;
        $this->dietary_options = $this->editingCake->dietary_options ?? [];
        $this->is_available = $this->editingCake->is_available;
        $this->showEditForm = true;
    }

    public function updateCake()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'category_id' => $this->category_id,
            'flavor' => $this->flavor,
            'size' => $this->size,
            'occasion' => $this->occasion,
            'ingredients' => $this->ingredients,
            'dietary_options' => $this->dietary_options,
            'is_available' => $this->is_available,
        ];

        if ($this->image) {
            $data['image'] = $this->image->store('cakes', 'public');
        }

        $this->editingCake->update($data);
        session()->flash('message', 'Cake updated successfully!');
        $this->hideEditForm();
    }

    public function createCake()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'category_id' => $this->category_id,
            'flavor' => $this->flavor,
            'size' => $this->size,
            'occasion' => $this->occasion,
            'ingredients' => $this->ingredients,
            'dietary_options' => $this->dietary_options,
            'is_available' => $this->is_available,
        ];

        if ($this->image) {
            $data['image'] = $this->image->store('cakes', 'public');
        }

        Cake::create($data);
        session()->flash('message', 'Cake created successfully!');
        $this->hideCreateForm();
    }

    public function deleteCake($cakeId)
    {
        $cake = Cake::findOrFail($cakeId);
        $cake->delete();
        session()->flash('message', 'Cake deleted successfully!');
    }

    public function toggleAvailability($cakeId)
    {
        $cake = Cake::findOrFail($cakeId);
        $cake->update(['is_available' => !$cake->is_available]);
        session()->flash('message', 'Cake availability updated!');
    }

    private function resetForm()
    {
        $this->name = '';
        $this->description = '';
        $this->price = '';
        $this->category_id = '';
        $this->image = null;
        $this->flavor = '';
        $this->size = '';
        $this->occasion = '';
        $this->ingredients = '';
        $this->dietary_options = [];
        $this->is_available = true;
        $this->editingCake = null;
        $this->showEditForm = false;
    }

    public function hideEditForm()
    {
        $this->showEditForm = false;
        $this->resetForm();
    }
}
