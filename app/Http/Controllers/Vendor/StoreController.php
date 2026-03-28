<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\StoreProfileUpdateRequest;
use App\Services\Contracts\Vendor\StoreServiceInterface;
use App\Traits\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    use Alert;

    public function __construct(
        protected StoreServiceInterface $storeService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $storeDetail = $this->storeService->getStoreData(auth('web')->user()->id);
        // dd($storeDetail->toArray());
        return view('vendor-dashboard.store-profile.index', compact('storeDetail'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreProfileUpdateRequest $request, string $id)
    {
        // dd($request->all());
        try {
            $storeDetails = $this->storeService->addStoreDetails(Auth::guard('web')->user(), $request->all());

            $this->created('Store Details Added Successfully!');

            return to_route('vendor.shop-profile.index');
        } catch (\Exception $e) {
            $this->failed('An error occured while updating store');
            logger()->error('Failed to update vendor store: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
