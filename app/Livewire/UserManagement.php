<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $userType = '';
    public $showCreateForm = false;
    public $editingUser = null;

    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $phone = '';
    public $address = '';
    public $role = 'customer';

    protected $queryString = ['search', 'userType'];

    protected function rules()
    {
        $userId = $this->editingUser ? $this->editingUser->id : null;
        
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $userId,
            'password' => $this->editingUser ? 'nullable|min:8|confirmed' : 'required|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'role' => 'required|in:admin,customer',
        ];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingUserType()
    {
        $this->resetPage();
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

    public function createUser()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'phone' => $this->phone,
            'address' => $this->address,
            'role' => $this->role,
        ]);

        session()->flash('message', 'User created successfully!');
        $this->hideCreateForm();
    }

    public function editUser($userId)
    {
        $this->editingUser = User::findOrFail($userId);
        $this->name = $this->editingUser->name;
        $this->email = $this->editingUser->email;
        $this->phone = $this->editingUser->phone ?? '';
        $this->address = $this->editingUser->address ?? '';
        $this->role = $this->editingUser->role;
        $this->password = '';
        $this->password_confirmation = '';
    }

    public function updateUser()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'role' => $this->role,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        $this->editingUser->update($data);

        session()->flash('message', 'User updated successfully!');
        $this->cancelEdit();
    }

    public function cancelEdit()
    {
        $this->editingUser = null;
        $this->resetForm();
    }

    public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);
        
        if ($user->id === auth()->id()) {
            session()->flash('error', 'You cannot delete your own account!');
            return;
        }

        $user->delete();
        session()->flash('message', 'User deleted successfully!');
    }

    private function resetForm()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->phone = '';
        $this->address = '';
        $this->role = 'customer';
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->when($this->userType, function ($query) {
                $query->where('role', $this->userType);
            })
            ->latest()
            ->paginate(10);

        return view('livewire.user-management', [
            'users' => $users
        ])->layout('layouts.app');
    }
}