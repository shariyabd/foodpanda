<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SsoService
{
    

    public function getAuthorizationUrl(): string
    {
        $state = Str::random(40);

        session()->put('sso_state', $state);
        session()->save();

        $query = http_build_query([
            'client_id' => config('sso.client_id'),
            'redirect_uri' => config('sso.callback_url'),
            'response_type' => 'code',
            'scope' => config('sso.scopes'),
            'state' => $state,
        ]);

        return config('sso.authorize_url') . '?' . $query;
    }

    

    public function getAccessToken(string $code): ?array
    {
        $response = Http::asForm()->post(config('sso.token_url'), [
            'grant_type' => 'authorization_code',
            'client_id' => config('sso.client_id'),
            'client_secret' => config('sso.client_secret'),
            'redirect_uri' => config('sso.callback_url'),
            'code' => $code,
        ]);

        if ($response->failed()) {
            Log::error('SSO Token Exchange Failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return null;
        }

        return $response->json();
    }

    

    public function refreshAccessToken(string $refreshToken): ?array
    {
        $response = Http::asForm()->post(config('sso.token_url'), [
            'grant_type' => 'refresh_token',
            'client_id' => config('sso.client_id'),
            'client_secret' => config('sso.client_secret'),
            'refresh_token' => $refreshToken,
            'scope' => config('sso.scopes'),
        ]);

        if ($response->failed()) {
            Log::error('SSO Token Refresh Failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return null;
        }

        return $response->json();
    }

    

    public function getUser(string $accessToken): ?array
    {
        $response = Http::withToken($accessToken)
            ->get(config('sso.user_url'));

        if ($response->failed()) {
            Log::error('SSO User Fetch Failed', [
                'status' => $response->status(),
            ]);
            return null;
        }

        return $response->json();
    }

    

    public function revokeToken(string $accessToken): bool
    {
        $response = Http::withToken($accessToken)
            ->post(config('sso.host') . '/api/logout');

        return $response->successful();
    }

    

    public function isTokenExpired(): bool
    {
        $expiresAt = session('sso_expires_at');

        if (!$expiresAt) {
            return true;
        }

        return now()->timestamp >= ($expiresAt - 60);
    }

    public function verifyToken(string $accessToken): bool
    {
        return $this->getUser($accessToken) !== null;
    }

    

    public function storeTokenData(array $tokenData): void
    {
        session([
            'sso_access_token' => $tokenData['access_token'],
            'sso_refresh_token' => $tokenData['refresh_token'] ?? null,
            'sso_expires_at' => now()->timestamp + ($tokenData['expires_in'] ?? 3600),
        ]);
    }

    

    public function clearSession(): void
    {
        session()->forget([
            'sso_access_token',
            'sso_refresh_token',
            'sso_expires_at',
            'sso_user',
            'sso_state',
        ]);
    }

    

    public function getLogoutUrl(): string
    {
        return config('sso.logout_url') . '?' . http_build_query([
            'redirect_uri' => config('app.url') . '/auth/logged-out',
        ]);
    }
}