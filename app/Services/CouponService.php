<?php

namespace App\Services;

use App\Models\Coupon;
use App\Repositories\Contracts\CouponRepositoryInterface;
use App\Services\Contracts\CouponServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Override;

class CouponService implements CouponServiceInterface
{
    public function __construct(
        protected CouponRepositoryInterface $couponRepo,
    ) {}

    public function createCoupon(array $data): Coupon
    {
        return $this->couponRepo->createOrUpdateCoupon($data);
    }

    public function getAllCoupons(): LengthAwarePaginator
    {
        return $this->couponRepo->getAllCoupons();
    }

    public function getCouponById(int $id): Coupon
    {
        return $this->couponRepo->findCouponOrFail($id);
    }

    public function updateCoupon(int $id, array $data): Coupon
    {
        return $this->couponRepo->createOrUpdateCoupon($data, $id);
    }

    public function deleteCoupon(int $id): bool
    {
        $coupon = $this->couponRepo->findCouponOrFail($id);
        return $coupon->delete();
    }
}
