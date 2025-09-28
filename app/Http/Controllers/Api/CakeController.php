<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CakeResource;
use App\Models\Cake;
use Illuminate\Http\Request;

class CakeController extends Controller
{
    public function index(Request $request)
    {
        $query = Cake::with('category');

        // Apply filters
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('flavor')) {
            $query->where('flavor', $request->flavor);
        }

        if ($request->has('size')) {
            $query->where('size', $request->size);
        }

        if ($request->has('occasion')) {
            $query->where('occasion', $request->occasion);
        }

        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->has('available')) {
            $query->where('is_available', $request->boolean('available'));
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('flavor', 'like', "%{$search}%");
            });
        }

        $cakes = $query->paginate($request->get('per_page', 12));
        return CakeResource::collection($cakes);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'flavor' => 'nullable|string',
            'size' => 'nullable|string',
            'occasion' => 'nullable|string',
            'is_available' => 'boolean',
            'ingredients' => 'nullable|string',
            'dietary_options' => 'nullable|array',
        ]);

        $cake = Cake::create($validated);
        return new CakeResource($cake->load('category'));
    }

    public function show(Cake $cake)
    {
        return new CakeResource($cake->load('category'));
    }

    public function update(Request $request, Cake $cake)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'flavor' => 'nullable|string',
            'size' => 'nullable|string',
            'occasion' => 'nullable|string',
            'is_available' => 'boolean',
            'ingredients' => 'nullable|string',
            'dietary_options' => 'nullable|array',
        ]);

        $cake->update($validated);
        return new CakeResource($cake->load('category'));
    }

    public function destroy(Cake $cake)
    {
        $cake->delete();
        return response()->json(['message' => 'Cake deleted successfully']);
    }
}