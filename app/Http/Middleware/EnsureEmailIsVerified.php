<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (
            $request->user() && // 用户已登录
            ! $request->user()->hasVerifiedEmail() && // 用户未验证邮箱
            ! $request->is('email/*', 'lgout')) // 非邮箱相关路由
        {
            return $request->expectsJson() ? abort(403, 'Your email address not verified.') : redirect()->route('verification.notice');
        }

        return $next($request);
    }
}
