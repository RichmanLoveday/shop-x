<?php

namespace App\Repositories\Contracts;

use App\Models\Coupon;
use Illuminate\Pagination\LengthAwarePaginator;

interface CouponRepositoryInterface
{
    public function createOrUpdateCoupon(array $data, ?int $id = null): Coupon;

    public function getAllCoupons(): LengthAwarePaginator;

    public function findCouponOrFail(int $id): Coupon;

    public function findCouponByCode(string $code): ?Coupon;
}
