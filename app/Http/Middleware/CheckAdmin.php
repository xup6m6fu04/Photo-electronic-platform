<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    protected $admin = [
        'sarah82529@gmail.com',
        'admin@gmail.com'
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && in_array(Auth::user()->email, $this->admin)) {
            return $next($request);
        }
        return redirect()->route('index');

    }
}
