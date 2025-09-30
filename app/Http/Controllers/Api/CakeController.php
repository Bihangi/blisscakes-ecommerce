<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cake;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CakeController extends Controller
{
    public function index(Request $request)
    {
        $query = Cake::with('category')->available();

        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('flavor')) {
            $query->where('flavor', $request->flavor);
        }

        if ($request->has('min_price') && $request->has('max_price')) {
            $query->whereBetween('price', [$request->min_price, $request->max_price]);
        }

        $cakes = $query->paginate($request->get('per_page', 12));

        return response()->json($cakes);
    }

    public function show($id)
    {
        $cake = Cake::with('category')->findOrFail($id);
        
        return response()->json($cake);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'flavor' => 'nullable|string',
            'size' => 'nullable|string',
            'occasion' => 'nullable|string',
            'ingredients' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->except('image');
        
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('cakes', 'public');
        }

        $cake = Cake::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Cake created successfully',
            'data' => $cake
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $cake = Cake::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric|min:0',
            'category_id' => 'sometimes|required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->except('image');
        
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('cakes', 'public');
        }

        $cake->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Cake updated successfully',
            'data' => $cake
        ]);
    }

    public function destroy($id)
    {
        $cake = Cake::findOrFail($id);
        $cake->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cake deleted successfully'
        ]);
    }

    public function toggleAvailability($id)
    {
        $cake = Cake::findOrFail($id);
        $cake->update(['is_available' => !$cake->is_available]);

        return response()->json([
            'success' => true,
            'message' => 'Availability updated',
            'data' => $cake
        ]);
    }
}
