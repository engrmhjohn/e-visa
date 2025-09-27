<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class SuperAdminOrAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();
    
    // Check if the authenticated user is either an admin (role '1') or a super admin (role '2')
    if ($user && ($user->role == '1' || $user->role == '2')) {
        return $next($request);
    }
    
        // Redirect unauthorized users to the dashboard with an error message
        return redirect()->to('/dashboard')->with('success', 'You are not Super Admin / Admin to access');
    }
    
}
