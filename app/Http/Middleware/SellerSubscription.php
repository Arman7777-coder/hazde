<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SellerSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        
        // 检查用户是否有有效的订阅
        if (!$user->hasValidSubscription()) {
            return redirect()->route('seller.plans.select')
                ->with('error', 'Пожалуйста, выберите тарифный план и оплатите его.');
        }

        return $next($request);
    }
}