<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Contracts\Admin\StoreServiceInterface;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function __construct(
        protected StoreServiceInterface $storeService,
    ) {}

    public function search(Request $request)
    {
        // dd($request->all());
        try {
            $stores = $this->storeService->findStore($request->input('name'));
            return response()->json([
                'stores' => $stores,
                'status' => true,
                'message' => 'Stores retrieved successfully',
            ]);
        } catch (\Exception $e) {
            logger()->error('Failed to fetch store: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while fetching store',
            ]);
        }
    }
}