<?php

namespace App\Http\Middleware;

use Closure;

class ApiCache {

  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  \Closure                 $next
   *
   * @return mixed
   */
  public function handle($request, Closure $next)
  {
    $response = $next($request);
    $response->setTtl(config('httpcache.options.default_ttl'));

    return $response;
  }
}
