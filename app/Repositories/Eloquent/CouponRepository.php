<?php

namespace App\Repositories\Eloquent;

use App\Models\Coupon;
use App\Repositories\Contracts\CouponRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Override;

class CouponRepository implements CouponRepositoryInterface
{
    public function createOrUpdateCoupon(array $data, ?int $id = null): Coupon
    {
        return Coupon::query()
            ->updateOrCreate(['id' => $id], $data);
    }

    public function getAllCoupons(): LengthAwarePaginator
    {
        return Coupon::query()
            ->latest()
            ->paginate(20);
    }

    public function findCouponOrFail(int $id): Coupon
    {
        return Coupon::query()
            ->findOrFail($id);
    }

    public function findCouponByCode(string $code): ?Coupon
    {
        return Coupon::query()
            ->where('code', $code)
            ->first();
    }
}