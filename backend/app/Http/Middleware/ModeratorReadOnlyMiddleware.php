<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ModeratorReadOnlyMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || (! $user->isAdmin() && ! $user->isModerator())) {
            return redirect()
                ->route('frontend')
                ->with('error', 'У вас нет прав доступа к админке. Обратитесь к администратору сайта для получения доступа https://t.me/prodbytoschiy');
        }

        if ($user->isModerator() && ! $request->isMethod('GET')) {
            return redirect()
                ->back()
                ->with('error', 'У вас нет прав на изменение данных. Обратитесь к администратору сайта для получения доступа https://t.me/prodbytoschiy');
        }

        return $next($request);
    }
}
