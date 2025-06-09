<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Электролюкс - Магазин электроники</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .navbar {
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .search-form input {
            border-radius: 20px;
        }

        .search-form button {
            border-radius: 20px;
        }

        .category-list {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 20px;
            padding: 10px 0;
            background-color: #ffffff;
        }

        .category-list a {
            padding: 6px 16px;
            text-decoration: none;
            color: #333;
            background-color: #e9ecef;
            border-radius: 20px;
            font-weight: 500;
            transition: background-color 0.2s, color 0.2s;
        }

        .category-list a:hover {
            background-color: #0d6efd;
            color: #fff;
        }

        .category-list a.active {
            background-color: #0d6efd;
            color: #fff;
        }

        .product-card {
            display: block;
            border-radius: 10px;
            overflow: hidden;
            background-color: #fff;
            transition: all 0.2s ease-in-out;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            height: 100%;
            text-align: center;
            padding: 10px;
        }

        .product-card:hover {
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
            transform: translateY(-4px);
        }

        .product-image {
            width: 100%;
            height: 150px;
            object-fit: contain;
            margin-bottom: 10px;
        }

        .product-info {
            padding: 5px 0;
        }

        .product-title {
            font-size: 14px;
            font-weight: 600;
            min-height: 38px;
        }

        .product-price {
            font-size: 15px;
            color: #0d6efd;
            font-weight: bold;
        }

        @media (max-width: 576px) {
            .product-title {
                font-size: 13px;
            }

            .product-price {
                font-size: 14px;
            }

            .product-image {
                height: 120px;
            }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">
            Электролюкс
        </a>

        <form class="d-flex ms-auto search-form" method="GET" action="{{ route('home') }}">
            <input class="form-control me-2" type="search" name="search" placeholder="Поиск товаров..." aria-label="Поиск" value="{{ request('search') }}">
            <button class="btn btn-primary" type="submit">Найти</button>
        </form>

        @php
            $cart = session()->get('cart', []);
            $cartCount = array_sum(array_column($cart, 'quantity'));
        @endphp

        <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary position-relative ms-3">
            🛒
            @if($cartCount > 0)
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    {{ $cartCount }}
                </span>
            @endif
        </a>

        <!-- User dropdown -->
        <div class="dropdown ms-3">
            @auth
                <!-- Пользователь авторизован -->
                <button class="btn btn-outline-secondary rounded-pill px-3 dropdown-toggle" type="button" id="userMenuButton" data-bs-toggle="dropdown" aria-expanded="false" style="min-width: 120px;">
                    {{ Auth::user()->name }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenuButton" style="min-width: 160px;">
                    <li>
                        <a class="dropdown-item" href="{{ route('profile') }}">Профиль</a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">Выйти</button>
                        </form>
                    </li>
                </ul>
            @else
                <!-- Гость -->
                <button class="btn btn-outline-secondary rounded-circle p-2 dropdown-toggle" type="button" id="userMenuButton" data-bs-toggle="dropdown" aria-expanded="false" style="width: 40px; height: 40px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                        <path d="M2 14s-1 0-1-1 1-4 7-4 7 3 7 4-1 1-1 1H2z"/>
                    </svg>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenuButton" style="min-width: 160px;">
                    <li><a class="dropdown-item" href="{{ route('login') }}">Вход</a></li>
                    <li><a class="dropdown-item" href="{{ route('register') }}">Регистрация</a></li>
                </ul>
            @endauth
        </div>
    </div>
</nav>

<div class="container mt-4 mb-5">
    @yield('content')
</div>

<!-- Bootstrap JS + Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- AOS JS -->
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init();
</script>

</body>
</html>
