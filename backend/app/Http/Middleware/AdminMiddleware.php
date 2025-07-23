<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
        public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->isAdmin()) {
            return $next($request);
        }

        if ($user && $user->isModerator()) {
            return redirect()
                ->back()
                ->with('error', 'У вас нет прав на изменение данных.');
        }

        return redirect()
            ->route('frontend')
            ->with('error', 'У вас нет прав доступа к админке.');
    }
}
