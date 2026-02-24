<?php

namespace App\Http\Middleware;

use App\Services\SsoService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SsoAuthenticated
{
    public function __construct(
        private readonly SsoService $ssoService
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        $accessToken = session('sso_access_token');

        if (!$accessToken) {
            return redirect('/login');
        }

        if ($this->ssoService->isTokenExpired()) {
            $refreshToken = session('sso_refresh_token');

            if (!$refreshToken) {
                $this->ssoService->clearSession();
                return redirect('/login')->withErrors([
                    'sso' => 'Your session has expired. Please log in again.',
                ]);
            }

            $tokenData = $this->ssoService->refreshAccessToken($refreshToken);

            if (!$tokenData) {
                $this->ssoService->clearSession();
                return redirect('/login')->withErrors([
                    'sso' => 'Failed to refresh session. Please log in again.',
                ]);
            }

            $this->ssoService->storeTokenData($tokenData);

            $user = $this->ssoService->getUser($tokenData['access_token']);
            if ($user) {
                session(['sso_user' => $user]);
            }
        } else {
            if (!$this->ssoService->verifyToken(session('sso_access_token'))) {
                $this->ssoService->clearSession();
                return redirect('/login')->withErrors([
                    'sso' => 'Your session has been ended. Please log in again.',
                ]);
            }
        }

        return $next($request);
    }
}