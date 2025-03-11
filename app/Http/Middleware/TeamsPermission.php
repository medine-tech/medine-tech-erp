<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;

final class TeamsPermission
{
    public function handle($request, Closure $next)
    {
        if (!empty(auth()->user())) {
            setPermissionsTeamId(tenant('id'));
        }

        return $next($request);
    }
}
