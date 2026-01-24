<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    /**
     * Display a listing of the assets.
     */
    public function index(Request $request)
    {
        $query = Asset::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('asset_name', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%");
            });
        }

        $assets = $query->orderBy('created_at', 'desc')->paginate(5);
        return view('assets.index', compact('assets'));
    }

    /**
     * Store a newly created asset in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'quantity' => 'required|integer|min:1',
            'acquisition_date' => 'nullable|date',
            'status' => 'required|in:working,maintenance,disposal,inactive',
            'last_maintenance_date' => 'nullable|date',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
        ]);

        try {
            $asset = Asset::create($validated);

            // Log the action
            ActivityLogger::logAsset('created', $asset->asset_name, $asset->id);

            return response()->json([
                'success' => true,
                'message' => 'Asset created successfully',
                'data' => $asset,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating asset',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified asset.
     */
    public function show(Asset $asset)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $asset->id,
                'asset_name' => $asset->asset_name,
                'category' => $asset->category,
                'quantity' => $asset->quantity,
                'acquisition_date' => $asset->acquisition_date,
                'status' => $asset->status,
                'last_maintenance_date' => $asset->last_maintenance_date,
                'description' => $asset->description,
                'location' => $asset->location,
                'created_at' => $asset->created_at,
                'updated_at' => $asset->updated_at,
            ]
        ]);
    }

    /**
     * Update the specified asset in storage.
     */
    public function update(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'asset_name' => 'sometimes|required|string|max:255',
            'category' => 'sometimes|required|string|max:100',
            'quantity' => 'sometimes|required|integer|min:1',
            'status' => 'sometimes|required|in:working,maintenance,disposal,inactive',
            'last_maintenance_date' => 'nullable|date',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
        ]);

        try {
            $asset->update($validated);

            // Log the action
            ActivityLogger::logAsset('updated', $asset->asset_name, $asset->id);

            return response()->json([
                'success' => true,
                'message' => 'Asset updated successfully',
                'data' => $asset,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating asset',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified asset from storage.
     */
    public function destroy(Asset $asset)
    {
        try {
            $assetName = $asset->asset_name;
            $assetId = $asset->id;
            
            $asset->delete();

            // Log the action
            ActivityLogger::logAsset('deleted', $assetName, $assetId);

            return response()->json([
                'success' => true,
                'message' => 'Asset deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting asset',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
