<?php

namespace App\Http\Middleware;

use Closure;

class TicketAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        if (\Auth::user()->is_ticket_admin != 1) {
            return redirect('home');
        } 
        return $next($request);
    }
}
