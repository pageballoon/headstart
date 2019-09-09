<?php


namespace Headstart\Middleware;

use Closure;
use Nuwave\Lighthouse\Exceptions\AuthenticationException;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @throws \Nuwave\Lighthouse\Exceptions\AuthenticationException
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! $request->bearerToken()) {
            if ($token = $request->cookie('auth_token')) {
                $request->headers->add(['Authorization' => 'Bearer '.$token]);
            }
        }

        try {
          return app(\Tymon\JWTAuth\Http\Middleware\Authenticate::class)->handle($request, $next);
        } catch (\Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException $e) {
          throw new AuthenticationException('not_authenticated');
        }
    }
}

