<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CouponRequestCreate;
use App\Http\Requests\Admin\CouponRequestUpdate;
use App\Services\Contracts\CouponServiceInterface;
use App\Traits\Alert;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    use Alert;

    public function __construct(
        protected CouponServiceInterface $couponService,
    ) {}

    public function index()
    {
        $coupons = $this->couponService->getAllCoupons();
        // dd($coupons->toArray());
        return view('admin.coupon.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupon.create');
    }

    public function store(CouponRequestCreate $request)
    {
        try {
            $this->couponService->createCoupon($request->validated());

            $this->created('Coupon created successfully');

            return redirect()->route('admin.coupons.index');
        } catch (\Exception $e) {
            logger()->error('Failed to create coupon: ' . $e->getMessage());
            $this->failed('Failed to create coupon');
            return redirect()->back();
        }
    }

    public function edit(int $id)
    {
        $coupon = $this->couponService->getCouponById($id);
        return view('admin.coupon.edit', compact('coupon'));
    }

    public function update(CouponRequestUpdate $request, int $id)
    {
        try {
            $this->couponService->updateCoupon($id, $request->validated());

            $this->updated('Coupon updated successfully');
            return redirect()->route('admin.coupons.index');
        } catch (\Exception $e) {
            logger()->error('Failed to update coupon: ' . $e->getMessage());
            $this->failed('Failed to update coupon');
            return redirect()->back();
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->couponService->deleteCoupon($id);

            $this->deleted('Coupon Deleted successfully');
            return response()->json([
                'message' => 'Coupon deleted successfully',
                'status' => true,
            ], 200);
        } catch (\Exception $e) {
            logger()->error('Failed to delete coupon: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while deleting coupon',
            ]);
        }
    }
}
