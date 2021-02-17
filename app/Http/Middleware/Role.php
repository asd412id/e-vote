<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Role
{
  /**
  * Handle an incoming request.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \Closure  $next
  * @return mixed
  */
  public function handle(Request $request, Closure $next, $guard = null)
  {
    if (auth()->user()->role != $guard) {
      auth()->logout();
      return redirect()->route('login')->withErrors('Anda tidak memiliki hak akses!');
    }
    return $next($request);
  }
}
