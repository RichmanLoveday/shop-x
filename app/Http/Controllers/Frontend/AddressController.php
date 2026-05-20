<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\AddressRequestCreate;
use App\Services\Contracts\AddressServiceInterface;
use App\Traits\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AddressController extends Controller
{
    use Alert;

    public function __construct(
        public AddressServiceInterface $addressService,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::guard('web')->user();
        $addresses = $this->addressService->allAddress($user);
        dd($addresses->toArray());
        return view('frontend.dashboard.address.index', compact('addresses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('frontend.dashboard.address.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddressRequestCreate $request)
    {
        try {
            $user = Auth::guard('web')->user();
            $address = $this->addressService->createAddress($user, $request->validated());
            $this->created('Address added successfully!');
            return to_route('address.index');
        } catch (\Exception $e) {
            logger()->error('Failed to add address: ' . $e->getMessage());
            $this->failed('Unable to add address');
            return redirect()->back();
        }
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
