<?php

namespace Modules\Shared\Http\Middleware;

use Closure;
use Spatie\Permission\Exceptions\UnauthorizedException;

class CheckIfHasPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission, $guard)
    {
        $authGuard = app('auth')->guard($guard);
        
        if ($authGuard->guest()) {
            throw UnauthorizedException::notLoggedIn();
        }
        $user = $authGuard->user();
        if($user->hasRole('super admin')) return $next($request);

        if($user->can($permission)) return $next($request);

        throw UnauthorizedException::forPermissions($permission);
    }
}
