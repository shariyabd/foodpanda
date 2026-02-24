<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\SsoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SsoAuthController extends Controller
{
    public function __construct(
        private readonly SsoService $ssoService
    ) {}

    

    public function redirect()
    {
        $url = $this->ssoService->getAuthorizationUrl();

        Log::info('SSO Redirect', [
            'url' => $url,
            'state_stored' => session('sso_state'),
        ]);

        return redirect($url);
    }

    

    public function callback(Request $request)
    {
        $storedState = session('sso_state');
        $returnedState = $request->input('state');

        Log::info('SSO Callback', [
            'stored_state' => $storedState,
            'returned_state' => $returnedState,
            'match' => $storedState === $returnedState,
            'code' => $request->has('code') ? 'present' : 'missing',
            'error' => $request->input('error'),
        ]);

        
        if (!$storedState || !$returnedState || $storedState !== $returnedState) {
            Log::warning('SSO State Mismatch', [
                'stored' => $storedState,
                'returned' => $returnedState,
            ]);

            return redirect('/login')->withErrors([
                'sso' => 'Invalid state parameter. Please try again.',
            ]);
        }

        
        session()->forget('sso_state');

        
        if ($request->has('error')) {
            return redirect('/login')->withErrors([
                'sso' => 'Authorization denied: ' . $request->input('error_description', 'Unknown error'),
            ]);
        }

        
        if (!$request->has('code')) {
            return redirect('/login')->withErrors([
                'sso' => 'No authorization code received. Please try again.',
            ]);
        }

        
        $tokenData = $this->ssoService->getAccessToken($request->input('code'));

        if (!$tokenData) {
            Log::error('SSO Token Exchange Failed');
            return redirect('/login')->withErrors([
                'sso' => 'Failed to obtain access token. Please try again.',
            ]);
        }

        Log::info('SSO Token Obtained', [
            'expires_in' => $tokenData['expires_in'] ?? 'unknown',
        ]);

        
        $this->ssoService->storeTokenData($tokenData);

        
        $user = $this->ssoService->getUser($tokenData['access_token']);

        if (!$user) {
            Log::error('SSO User Fetch Failed');
            $this->ssoService->clearSession();
            return redirect('/login')->withErrors([
                'sso' => 'Failed to fetch user profile. Please try again.',
            ]);
        }

        Log::info('SSO Login Successful', ['user_id' => $user['id']]);

        
        session(['sso_user' => $user]);

        return redirect('/dashboard');
    }

    

    public function showLogin()
    {
        if (session()->has('sso_access_token')) {
            return redirect('/dashboard');
        }

        return view('auth.login');
    }

    

    public function logout(Request $request)
    {
        $accessToken = session('sso_access_token');

        if ($accessToken) {
            $this->ssoService->revokeToken($accessToken);
        }

        $logoutUrl = $this->ssoService->getLogoutUrl();

        $this->ssoService->clearSession();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect($logoutUrl);
    }

    

    public function loggedOut()
    {
        return redirect('/login')->with('status', 'You have been logged out from all applications.');
    }
}