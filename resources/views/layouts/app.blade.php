<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Foodpanda') }} — @yield('title', 'Home')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Figtree', sans-serif;
            background: #fff5f5;
            color: #1f2937;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background: #d70f64;
            color: #fff;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar .brand {
            font-size: 1.25rem;
            font-weight: 700;
            text-decoration: none;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .navbar .nav-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .navbar .user-name {
            font-size: 0.875rem;
        }

        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
            padding: 2.5rem;
            width: 100%;
            max-width: 500px;
        }

        .card h1 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .card .subtitle {
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 1.5rem;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 0.75rem;
            background: #d70f64;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 0.9375rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.15s;
            text-align: center;
            text-decoration: none;
        }

        .btn:hover {
            background: #b50d54;
        }

        .btn-logout {
            background: transparent;
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 0.5rem 1rem;
            width: auto;
            font-size: 0.875rem;
            border-radius: 6px;
        }

        .btn-logout:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .alert {
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            font-size: 0.875rem;
        }

        .alert-success {
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert-error {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .menu-card {
            background: #fff5f5;
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: 1rem;
            text-align: center;
            transition: transform 0.15s, box-shadow 0.15s;
        }

        .menu-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(215, 15, 100, 0.15);
        }

        .menu-card .price {
            color: #d70f64;
            font-weight: 700;
            font-size: 1.125rem;
            margin-top: 0.5rem;
        }

        .menu-card .name {
            font-weight: 600;
            margin-top: 0.5rem;
        }

        .menu-card .time {
            font-size: 0.75rem;
            color: #6b7280;
            margin-top: 0.25rem;
        }

        .menu-icon {
            font-size: 2.5rem;
        }

        .welcome-section {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .avatar {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: #d70f64;
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.25rem;
            margin-bottom: 0.75rem;
        }

        .categories {
            display: flex;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .category-tag {
            background: #fce7f3;
            color: #d70f64;
            padding: 0.375rem 0.875rem;
            border-radius: 20px;
            font-size: 0.8125rem;
            font-weight: 500;
        }
    </style>
</head>

<body>
    @yield('content')
</body>

</html>