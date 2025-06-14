@extends('layouts.admin')

@section('title', 'Управление товарами')

@section('styles')
    <style>
        /* Контейнер */
        .custom-container {
            width: 100%;
            max-width: 100%;
            padding: 0 15px;
            margin: 0 auto;
            box-sizing: border-box;
        }

        /* Таблица */
        .table {
            width: 100%;
            background: var(--card-bg);
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .table thead {
            background: var(--primary-gradient);
            color: #FFFFFF;
        }

        .table th, .table td {
            padding: 12px;
            vertical-align: middle;
            text-align: left;
            border: none;
        }

        .table tbody tr:nth-child(even) {
            background: var(--bg-light);
        }

        .table tbody tr:hover {
            background: #F3F4F6;
        }

        /* Кнопки */
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            line-height: 1.5;
            border-radius: 0.375rem;
        }

        .btn-primary, .btn-secondary, .btn-danger, .btn-success {
            font-weight: 500;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-primary:hover, .btn-secondary:hover, .btn-danger:hover, .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            padding: 0.4rem;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }

        /* Пагинация */
        .pagination {
            justify-content: center;
            margin-top: 1.5rem;
            font-size: 0.875rem; /* Компактный размер текста */
        }

        .page-item .page-link {
            padding: 0.25rem 0.5rem; /* Уменьшенные отступы */
            font-size: 0.875rem;
            border-radius: 0.375rem;
            margin: 0 2px;
            color: var(--text-muted);
            border: 1px solid #D1D5DB;
            background: var(--card-bg);
            line-height: 1.5;
            min-width: 1.5rem; /* Минимальная ширина для стрелок */
            text-align: center;
        }

        .page-item.active .page-link {
            background: var(--primary-gradient);
            color: #FFFFFF;
            border-color: transparent;
        }

        .page-item .page-link:hover {
            background: #E5E7EB;
            border-color: #D1D5DB;
        }

        /* Стрелки пагинации */
        .page-item:first-child .page-link,
        .page-item:last-child .page-link {
            font-size: 0.875rem; /* Уменьшенный размер стрелок */
            padding: 0.25rem 0.5rem;
        }

        .page-item:first-child .page-link::before,
        .page-item:last-child .page-link::after {
            font-size: 0.875rem; /* Уменьшенный размер иконок, если используются псевдоэлементы */
        }

        /* Форма поиска */
        .form-control, .form-select {
            border-radius: 8px;
            padding: 0.5rem 0.75rem;
            border: 1px solid #D1D5DB;
            font-size: 0.875rem;
        }

        .form-control::placeholder {
            color: var(--text-muted);
        }

        /* Переопределяем main-content */
        .main-content {
            padding: 0 !important;
            margin: 0 auto;
            width: 100%;
            max-width: 100%;
        }

        /* Адаптивность */
        @media (max-width: 768px) {
            h1 {
                font-size: 1.75rem;
            }
            .table th, .table td {
                padding: 8px;
                font-size: 0.875rem;
            }
            .btn-sm {
                padding: 0.2rem 0.4rem;
                font-size: 0.75rem;
            }
            .form-control, .form-select {
                font-size: 0.75rem;
            }
            .page-item .page-link {
                padding: 0.2rem 0.4rem;
                font-size: 0.75rem;
            }
        }
    </style>
@endsection

@section('content')
    <div class="custom-container mt-4">
        <div class="mb-4 position-relative">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm position-absolute start-0">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h1 class="text-center mb-0">Товары</h1>
        </div>

        <a href="{{ route('admin.products.create') }}" class="btn btn-success btn-sm mb-3">Добавить товар</a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Форма поиска и фильтров -->
        <form method="GET" action="{{ route('admin.products.index') }}" class="mb-4">
            <div class="row g-2">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Поиск по названию..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="category_id" class="form-select">
                        <option value="">Все категории</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary btn-sm">Фильтровать</button>
                </div>
            </div>
        </form>

        <table class="table">
            <thead>
            <tr>
                <th>
                    <a href="{{ route('admin.products.index', array_merge(request()->all(), ['sort' => 'name', 'direction' => request('sort') == 'name' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}">
                        Название
                        @if(request('sort') == 'name')
                            <i class="bi bi-arrow-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                        @endif
                    </a>
                </th>
                <th>Категория</th>
                <th>
                    <a href="{{ route('admin.products.index', array_merge(request()->all(), ['sort' => 'price', 'direction' => request('sort') == 'price' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}">
                        Цена
                        @if(request('sort') == 'price')
                            <i class="bi bi-arrow-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                        @endif
                    </a>
                </th>
                <th>Изображение</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category ? $product->category->name : '-' }}</td>
                    <td>{{ number_format($product->price, 0, '', ' ') }} сом</td>
                    <td>
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="Товар" width="80">
                        @else
                            Нет
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary btn-sm">Редактировать</a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Удалить?')">Удалить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $products->links() }}
    </div>
@endsection
