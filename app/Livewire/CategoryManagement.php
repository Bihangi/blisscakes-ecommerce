<?php
namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;

class CategoryManagement extends Component
{
    use WithFileUploads;

    public $name = '';
    public $description = '';
    public $editingCategory = null;
    public $showForm = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ];

    public function render()
    {
        $categories = Category::withCount('cakes')->get();
        return view('livewire.category-management', compact('categories'));
    }

    public function createCategory()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'description' => $this->description,
        ];

        Category::create($data);
        session()->flash('message', 'Category created successfully!');
        $this->resetForm();
    }

    public function editCategory($id)
    {
        $this->editingCategory = Category::findOrFail($id);
        $this->name = $this->editingCategory->name;
        $this->description = $this->editingCategory->description;
        $this->showForm = true;
    }

    public function updateCategory()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'description' => $this->description,
        ];

        $this->editingCategory->update($data);
        session()->flash('message', 'Category updated successfully!');
        $this->resetForm();
    }

    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);
        if ($category->cakes()->count() > 0) {
            session()->flash('error', 'Cannot delete category with cakes!');
            return;
        }
        $category->delete();
        session()->flash('message', 'Category deleted successfully!');
    }

    public function resetForm()
    {
        $this->name = '';
        $this->description = '';
        $this->editingCategory = null;
        $this->showForm = false;
    }
}