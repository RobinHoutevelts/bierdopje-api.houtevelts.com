<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

class Throttle {

  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  \Closure                 $next
   * @param int                       $limit
   * @param int                       $time
   *
   * @return mixed
   * @throws TooManyRequestsHttpException
   */
  public function handle($request, Closure $next, $limit = 10, $time = 60)
  {
    /** @var Throttle $throttler */
    $throttler = \Throttle::get([
      'ip'    => $request->ip(),
      'route' => 'any',             // We don't want to rate-limit per route
    ], $limit, $time);

    if ( ! $throttler->attempt() ) {
      throw new TooManyRequestsHttpException($time * 60, 'Rate limit exceeded.');
    }

    return $next($request);
  }
}
