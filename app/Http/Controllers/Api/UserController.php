<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Only admins can view all users
        if (!$request->user()->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $query = User::query();

        if ($request->has('user_type')) {
            $query->where('user_type', $request->user_type);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate($request->get('per_page', 15));
        return UserResource::collection($users);
    }

    public function show(User $user)
    {
        // Users can only see their own profile, admins can see any
        if (!auth()->user()->isAdmin() && $user->id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return new UserResource($user->load(['orders', 'cart']));
    }

    public function update(Request $request, User $user)
    {
        // Users can only update their own profile, admins can update any
        if (!$request->user()->isAdmin() && $user->id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
            'user_type' => $request->user()->isAdmin() ? 'in:admin,customer' : '',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        // Only admins can change user_type
        if (!$request->user()->isAdmin()) {
            unset($validated['user_type']);
        }

        $user->update($validated);
        return new UserResource($user);
    }

    public function destroy(User $user)
    {
        // Only admins can delete users, and they can't delete themselves
        if (!auth()->user()->isAdmin() || $user->id === auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }

    public function profile(Request $request)
    {
        return new UserResource($request->user()->load(['orders', 'cart']));
    }
}