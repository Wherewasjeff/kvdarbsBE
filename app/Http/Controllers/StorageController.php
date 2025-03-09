<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Storage as StorageModel;
use App\Models\Storage;
use App\Models\Category;

class StorageController extends Controller
{

    public function storage(Request $request)
    {
        $validatedData = $request->validate([
            'store_id' => 'required|exists:stores,id',
            'product_name' => 'required|string|max:255',
            'barcode' => 'required|string|max:255',
            'category_id' => 'nullable|integer|exists:categories,id',
            'price' => 'nullable|numeric',
            'shelf_num' => 'nullable|string|max:255',
            'storage_num' => 'nullable|string|max:255',
            'quantity_in_storage' => 'nullable|integer',
            'quantity_in_salesfloor' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('storage_images', 'public');
            $validatedData['image'] = $imagePath;
        } else {
            $validatedData['image'] = null;
        }

        $validatedData['category_id'] = $validatedData['category_id'] ?? null;

        $storageItem = StorageModel::create($validatedData);

        return response()->json(['message' => 'Storage item added successfully', 'storageItem' => $storageItem]);
    }
    // Method to retrieve all storage items
    public function getStorage(Request $request)
    {
        $store_id = $request->input('store_id');

        if (!$store_id) {
            return response()->json([
                'success' => false,
                'message' => 'Store ID is required',
            ], 400);
        }

        $products = Storage::with('category') // Eager load the category relationship
        ->where('store_id', $store_id)
            ->get();

        if ($products->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No products found for this store',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    public function destroy($id)
    {
        $storageItem = Storage::find($id);

        if (!$storageItem) {
            return response()->json(['message' => 'Storage item not found'], 404);
        }

        $storageItem->delete();
        return response()->json(['message' => 'Storage item deleted successfully'], 200);
    }
    public function getCategories(Request $request)
    {
        // Validate store_id exists in request
        $storeId = $request->input('store_id');

        if (!$storeId) {
            return response()->json(['error' => 'Store ID is missing'], 400);
        }

        // Retrieve only categories for this store
        $categories = Category::where('store_id', $storeId)->get();

        return response()->json($categories);
    }

    public function addCategory(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $storeId = $user->store_id ?? null;
        if (!$storeId) {
            return response()->json(['error' => 'Store ID is missing'], 400);
        }

        $validatedData = $request->validate([
            'category' => 'required|string|max:255',
        ]);

        $validatedData['store_id'] = $storeId;

        $category = Category::create($validatedData);

        return response()->json([
            'message' => 'Category added successfully',
            'category' => $category
        ]);
    }


}
