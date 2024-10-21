<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\UserAndStore;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    // Method to store the new store information
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'storename' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'backroom' => 'required|boolean',
            'user_id' => 'required',
        ]);

        // Create a new store record
        $store = Store::create(['storename' => $validatedData['storename'],
            'address' => $validatedData['address'],
            'category' => $validatedData['category'],
            'backroom' => $validatedData['backroom']]);

        $userandstore = UserAndStore::create(['user_id' => $validatedData['user_id'],
                'store_id' => $store->id]);
        // Return a response, e.g., success message
        return response()->json([
            'message' => 'Store created successfully',
            'store' => $store,
            'user' => $userandstore
        ], 201);
    }
}
