<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Электролюкс — Магазин электроники</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Custom CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        :root {
            --primary: #1E3A8A;
            --primary-gradient: linear-gradient(135deg, #3B82F6, #1E40AF);
            --accent: #06B6D4;
            --bg-light: #F3F4F6;
            --card-bg: #FFFFFF;
            --text-muted: #6B7280;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
            color: #111827;
            line-height: 1.6;
        }

        /* Navbar */
        .navbar {
            background: var(--primary-gradient);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 1rem 0;
        }

        .navbar-brand {
            color: #FFFFFF !important;
            font-weight: 700;
            font-size: 1.5rem;
            transition: transform 0.2s;
        }

        .navbar-brand:hover {
            transform: scale(1.05);
        }

        .navbar-toggler {
            border: none;
            color: #FFFFFF;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255, 255, 255, 0.8)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* Search Form */
        .search-form {
            display: flex;
            gap: 8px;
            max-width: 400px;
        }

        .search-form input {
            border: none;
            border-radius: 50px;
            padding: 10px 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            transition: box-shadow 0.2s;
        }

        .search-form input:focus {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            outline: none;
        }

        .search-form button {
            background: var(--accent);
            border: none;
            border-radius: 50px;
            padding: 10px 20px;
            color: #FFFFFF;
            font-weight: 500;
            transition: transform 0.2s, background 0.2s;
        }

        .search-form button:hover {
            background: #0E7490;
            transform: translateY(-2px);
        }

        /* Cart Button */
        .cart-btn {
            position: relative;
            background: #FFFFFF;
            color: var(--primary);
            border-radius: 50px;
            padding: 8px 16px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .cart-btn:hover {
            background: var(--accent);
            color: #FFFFFF;
            transform: translateY(-2px);
        }

        .cart-badge {
            top: -8px;
            right: -8px;
            font-size: 0.75rem;
            padding: 4px 8px;
        }

        /* Dropdown Menu */
        .dropdown-toggle {
            background: #FFFFFF;
            color: var(--primary);
            border-radius: 50px;
            padding: 8px 16px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .dropdown-toggle:hover {
            background: var(--accent);
            color: #FFFFFF;
        }

        .dropdown-menu {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-top: 8px;
            padding: 8px 0;
        }

        .dropdown-item {
            padding: 8px 16px;
            font-weight: 500;
            transition: background 0.2s;
        }

        .dropdown-item:hover {
            background: var(--bg-light);
            color: var(--primary);
        }

        /* Content Container */
        .main-content {
            background: var(--card-bg);
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            padding: 2rem;
            margin-bottom: 3rem;
            min-height: 60vh;
        }

        /* Category List */
        .category-list {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            background: var(--bg-light);
            padding: 12px;
            border-radius: 12px;
            margin-bottom: 1.5rem;
        }

        .category-list a {
            padding: 8px 20px;
            background: #FFFFFF;
            color: var(--text-muted);
            border-radius: 50px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
        }

        .category-list a:hover, .category-list a.active {
            background: var(--accent);
            color: #FFFFFF;
            transform: translateY(-2px);
        }

        /* Product Card */
        .product-card {
            border-radius: 16px;
            background: var(--card-bg);
            padding: 16px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }

        .product-image {
            height: 180px;
            object-fit: contain;
            margin-bottom: 12px;
            width: 100%;
            transition: transform 0.3s;
        }

        .product-card:hover .product-image {
            transform: scale(1.05);
        }

        .product-title {
            font-size: 16px;
            font-weight: 600;
            min-height: 48px;
            color: #111827;
            margin-bottom: 8px;
        }

        .product-price {
            font-size: 18px;
            color: var(--accent);
            font-weight: bold;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .search-form {
                max-width: 100%;
                margin-bottom: 10px;
            }

            .navbar .container {
                flex-direction: column;
                align-items: flex-start;
            }

            .navbar-collapse {
                background: var(--card-bg);
                border-radius: 12px;
                padding: 10px;
                margin-top: 10px;
            }
        }

        @media (max-width: 576px) {
            .navbar-brand {
                font-size: 1.25rem;
            }

            .search-form {
                flex-direction: column;
                gap: 8px;
            }

            .search-form input, .search-form button {
                width: 100%;
            }

            .cart-btn, .dropdown-toggle {
                padding: 6px 12px;
                font-size: 0.875rem;
            }

            .product-image {
                height: 140px;
            }

            .product-title {
                font-size: 14px;
                min-height: 42px;
            }

            .product-price {
                font-size: 16px;
            }

            .main-content {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">Электролюкс</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <form class="d-flex ms-auto search-form" method="GET" action="{{ route('home') }}" data-aos="fade-left">
                <input class="form-control" type="search" name="search" placeholder="Поиск товаров..." aria-label="Поиск" value="{{ request('search') }}">
                <button class="btn" type="submit">Найти</button>
            </form>

            @php
                // Подсчет товаров в корзине на основе модели CartItem
                $cartCount = 0;
                if (Auth::check()) {
                    $cartCount = \App\Models\CartItem::where('user_id', Auth::id())->sum('quantity');
                }
                // Очистка устаревших данных сессии
                session()->forget('cart');
            @endphp

            <a href="{{ route('cart.index') }}" class="btn cart-btn position-relative ms-3" data-aos="fade-left" data-aos-delay="100">
                <i class="bi bi-cart3"></i>
                @if($cartCount > 0)
                    <span class="position-absolute cart-badge bg-danger text-white">
                        {{ $cartCount }}
                    </span>
                @endif
            </a>

            <div class="dropdown ms-3" data-aos="fade-left" data-aos-delay="200">
                @auth
                    <button class="btn dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="{{ route('profile') }}">Профиль</a></li>
                        <li><hr class="dropdown-divider"></li>
                        @if(Auth::user()->is_admin)
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Админ-панель</a></li>
                            <li><hr class="dropdown-divider"></li>
                        @endif
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">Выйти</button>
                            </form>
                        </li>
                    </ul>
                @else
                    <button class="btn dropdown-toggle" type="button" id="guestDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle me-1"></i> Аккаунт
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="guestDropdown">
                        <li><a class="dropdown-item" href="{{ route('login') }}">Вход</a></li>
                        <li><a class="dropdown-item" href="{{ route('register') }}">Регистрация</a></li>
                    </ul>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container main-content mt-5" data-aos="fade-up">
    @yield('content')
</div>

<!-- Bootstrap JS + Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<!-- AOS JS -->
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        once: true
    });
</script>

</body>
</html>
