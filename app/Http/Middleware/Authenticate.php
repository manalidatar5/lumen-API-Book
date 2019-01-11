<?php

namespace App\Http\Middleware;

use Closure;
use http\Env\Request;
use Illuminate\Contracts\Auth\Factory as Auth;
use App\User;
use Illuminate\Support\Facades\Hash;

use Illuminate\Contracts\Hashing\Hasher;


class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $email = $request->get('email');
        $password = $request->get('password');
        $user = User::where('email', $email)->first();
        if ($user && password_verify($password, $user->password)) {
            return $next($request);
        }
        return response()->json(['message' => "Please Login"], 404);
    }
}
