<?php

namespace App\Http\Middleware;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Closure;

class CheckKycStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        $vendor = Auth::guard('web')->user();

        // if vendor kyc is pending or under review | if kyc is approved move to the next request
        if ($vendor->kyc?->canNotBeEditable() || $vendor->kyc?->isApproved() || $vendor->kyc?->status == null) {
            return redirect()->route('vendor.dashboard');
        } elseif ($vendor->kyc?->canBeEditable()) {
            return $next($request);
        }

        return abort(403);
    }
}
