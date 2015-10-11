<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Auth;
class LoggedInUsersOnly
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
        $username = $request->get('username');
        $user = User::where('username', '=', $username)->first();

        if (!$user){
            return response()->json([
                'success' => false,
                'message' => "User not registered. Please register this user, then request access."
            ]);
        }

        return $next($request);
    }
}
