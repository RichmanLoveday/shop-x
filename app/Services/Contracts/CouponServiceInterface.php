<?php

namespace App\Services\Contracts;

use App\Models\Coupon;
use Illuminate\Pagination\LengthAwarePaginator;

interface CouponServiceInterface
{
    public function createCoupon(array $data): Coupon;

    // public function updateCoupon(int $id, array $data);

    // public function deleteCoupon(int $id);

    public function getCouponById(int $id);

    public function getAllCoupons(): LengthAwarePaginator;

    public function deleteCoupon(int $id): bool;

    public function updateCoupon(int $id, array $data): Coupon;
}
