<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SystemUser;

class SystemUserBasicAuth
{
    public function handle(Request $request, Closure $next)
    {
        // Basic Auth header
        if ($request->getUser() && $request->getPassword()) {
            $user = SystemUser::where('login', $request->getUser())
                ->where('active', true)
                ->first();

            if ($user && password_verify($request->getPassword(), $user->password)) {
                Auth::guard('systemuser')->login($user);
                return $next($request);
            }
        }

        return response('Unauthorized', 401, ['WWW-Authenticate' => 'Basic']);
    }
}
