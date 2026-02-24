@extends('layouts.app')

@section('title', 'Sign In')

@section('content')
    <div class="main-content">
        <div class="card" style="text-align:center;">
            <div style="font-size:2.5rem;margin-bottom:0.5rem;">🍔</div>
            <h1>Foodpanda</h1>
            <p class="subtitle">Sign in with your SSO account to order delicious food</p>

            @if(session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-error">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <a href="{{ route('sso.redirect') }}" class="btn">
                🔐 Sign in with SSO
            </a>

            <p style="margin-top:1.25rem;font-size:0.8125rem;color:#6b7280;">
                You will be redirected to the central authentication server.
            </p>
        </div>
    </div>
@endsection