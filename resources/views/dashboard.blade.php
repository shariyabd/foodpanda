@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <nav class="navbar">
        <a href="/dashboard" class="brand">🍔 Foodpanda</a>
        <div class="nav-right">
            <span class="user-name">{{ $user['name'] ?? 'User' }}</span>
            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button type="submit" class="btn btn-logout">Logout</button>
            </form>
        </div>
    </nav>

    <div class="main-content">
        <div class="card" style="max-width:700px;">
            <div class="welcome-section">
                <div class="avatar">{{ strtoupper(substr($user['name'] ?? 'U', 0, 1)) }}</div>
                <h1>Welcome, {{ $user['name'] ?? 'User' }}!</h1>
                <p class="subtitle">{{ $user['email'] ?? '' }} — Logged in via SSO</p>
            </div>

            <div class="categories">
                <span class="category-tag">🍕 Pizza</span>
                <span class="category-tag">🍜 Noodles</span>
                <span class="category-tag">🍣 Sushi</span>
                <span class="category-tag">🥗 Salad</span>
                <span class="category-tag">🧁 Dessert</span>
            </div>

            <h2 style="font-size:1rem;font-weight:600;margin-bottom:0.25rem;">🔥 Popular Near You</h2>
            <p style="font-size:0.8125rem;color:#6b7280;margin-bottom:0.5rem;">Order from your favourite restaurants</p>

            <div class="menu-grid">
                <div class="menu-card">
                    <div class="menu-icon">🍕</div>
                    <div class="name">Margherita Pizza</div>
                    <div class="time">25-30 min</div>
                    <div class="price">$12.99</div>
                </div>
                <div class="menu-card">
                    <div class="menu-icon">🍜</div>
                    <div class="name">Pad Thai</div>
                    <div class="time">20-25 min</div>
                    <div class="price">$9.99</div>
                </div>
                <div class="menu-card">
                    <div class="menu-icon">🍔</div>
                    <div class="name">Classic Burger</div>
                    <div class="time">15-20 min</div>
                    <div class="price">$8.49</div>
                </div>
                <div class="menu-card">
                    <div class="menu-icon">🍣</div>
                    <div class="name">Salmon Sushi</div>
                    <div class="time">30-35 min</div>
                    <div class="price">$14.99</div>
                </div>
                <div class="menu-card">
                    <div class="menu-icon">🥗</div>
                    <div class="name">Caesar Salad</div>
                    <div class="time">10-15 min</div>
                    <div class="price">$7.99</div>
                </div>
                <div class="menu-card">
                    <div class="menu-icon">🧁</div>
                    <div class="name">Chocolate Cake</div>
                    <div class="time">15-20 min</div>
                    <div class="price">$5.99</div>
                </div>
            </div>
        </div>
    </div>
@endsection