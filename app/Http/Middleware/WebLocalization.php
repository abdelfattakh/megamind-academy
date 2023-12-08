<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WebLocalization extends Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $locale = $request->get('lang') ?: $request->session()->get('locale');

        $locale = $this->getLocale($request, $locale);

        $request->session()->put('locale', $locale);

        return $next($request);
    }
}
