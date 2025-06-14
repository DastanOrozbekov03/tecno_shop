<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Электролюкс — Админ-панель - @yield('title', 'Админ-панель')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #2c3e50;
            color: #fff;
            padding-top: 20px;
        }
        .sidebar a {
            color: #fff;
            display: block;
            padding: 10px 20px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #34495e;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
<div class="sidebar">
    <h4 class="text-center mb-4">Электролюкс - Админ</h4>
    <a href="{{ route('admin.dashboard') }}"><i class="bi bi-house-door"></i> Админ-панель</a>
    <a href="{{ route('admin.categories.index') }}"><i class="bi bi-list-ul"></i> Категории</a>
    <a href="{{ route('admin.products.index') }}"><i class="bi bi-box-seam"></i> Товары</a>
    <a href="{{ route('admin.orders.index') }}"><i class="bi bi-cart-check"></i> Заказы</a>
    <a href="{{ route('home') }}" class="mt-4"><i class="bi bi-arrow-left"></i> На главную сайта</a>
</div>

<div class="content">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>AOS.init();</script>
</body>
</html>
