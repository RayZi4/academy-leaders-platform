<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckApproved
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Если пользователь не одобрен (и не студент/админ) – редирект на страницу ожидания
        if ($user && !$user->isApproved()) {
            return redirect()->route('awaiting-approval');
        }

        return $next($request);
    }
}
