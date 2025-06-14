<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Пример проверки: если пользователь не админ — редирект
        if (!auth()->check() || !auth()->user()->is_admin) {
            return redirect('/')->with('error', 'Доступ запрещён.');
        }

        return $next($request);
    }
}

