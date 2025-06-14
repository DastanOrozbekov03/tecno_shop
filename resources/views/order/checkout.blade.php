@extends('layouts.app')

@section('styles')
    <style>
        /* Контейнер без ограничений */
        .custom-container {
            width: 100%;
            max-width: 100%;
            padding: 0;
            margin: 0 auto;
            box-sizing: border-box;
        }

        /* Таблица занимает весь контейнер */
        .custom-table {
            width: 100%;
            background: var(--card-bg); /* Белый фон из layouts.app */
            border-radius: 12px;
            margin: 0;
            padding: 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            box-sizing: border-box;
        }

        .custom-table table {
            width: 100%;
            table-layout: fixed; /* Фиксированное распределение столбцов */
            border-collapse: collapse;
            margin: 0;
        }

        /* Стили ячеек */
        .custom-table th, .custom-table td {
            padding: 12px;
            text-align: left;
            vertical-align: middle;
            word-wrap: break-word;
        }

        /* Распределение ширины столбцов (адаптировано для 4 столбцов) */
        .custom-table th:nth-child(1), .custom-table td:nth-child(1) {
            width: 45%; /* Товар - шире */
        }
        .custom-table th:nth-child(2), .custom-table td:nth-child(2) {
            width: 20%; /* Цена */
            text-align: center;
        }
        .custom-table th:nth-child(3), .custom-table td:nth-child(3) {
            width: 15%; /* Кол-во */
            text-align: center;
        }
        .custom-table th:nth-child(4), .custom-table td:nth-child(4) {
            width: 20%; /* Итого */
            text-align: right;
        }

        /* Заголовок таблицы */
        .custom-table thead {
            background: var(--primary-gradient); /* Синий градиент */
            color: #FFFFFF;
            width: 100%;
        }

        .custom-table thead tr {
            width: 100%;
        }

        .custom-table thead th {
            border: none;
        }

        /* Тело таблицы */
        .custom-table tbody tr {
            background: var(--card-bg);
        }

        .custom-table tbody tr:nth-child(even) {
            background: var(--bg-light);
        }

        .custom-table tbody td {
            border: none;
        }

        /* Убираем пробелы */
        .custom-table table, .custom-table thead, .custom-table tbody, .custom-table tr, .custom-table th, .custom-table td {
            box-sizing: border-box;
            margin: 0;
            padding: 12px;
        }

        /* Форма */
        .checkout-form {
            margin-top: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 500;
            color: var(--text-muted);
        }

        .form-control, .form-select {
            border-radius: 8px;
            padding: 10px;
            border: 1px solid #D1D5DB;
        }

        .error-message {
            color: #DC2626;
            font-size: 0.875rem;
            margin-top: 4px;
        }

        .hidden {
            display: none;
        }

        /* Переопределяем main-content */
        .main-content {
            padding: 0 !important;
            margin: 0 auto;
            width: 100%;
            max-width: 100%;
        }
    </style>
@endsection

@section('content')
    <div class="custom-container" data-aos="fade-up">
        <div class="mb-4 position-relative">
            <a href="{{ url()->previous() }}" class="btn btn-secondary position-absolute start-0">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h1 class="text-center mb-0">Оформление заказа</h1>
        </div>

        @if($cart->isEmpty())
            <div class="alert alert-info">Ваша корзина пуста.</div>
        @else
            <form method="POST" action="{{ route('checkout.process') }}" id="orderForm" class="checkout-form">
                @csrf

                <div class="custom-table">
                    <table>
                        <thead>
                        <tr>
                            <th>Товар</th>
                            <th>Цена</th>
                            <th>Кол-во</th>
                            <th>Итого</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $total = 0; @endphp
                        @foreach($cart as $item)
                            @php
                                $subtotal = $item->product->price * $item->quantity;
                                $total += $subtotal;
                            @endphp
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ number_format($item->product->price, 0, '', ' ') }} сом</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($subtotal, 0, '', ' ') }} сом</td>
                            </tr>
                        @endforeach
                        <tr>
                            <th colspan="3" class="text-end">К оплате:</th>
                            <th class="cart-total">{{ number_format($total, 0, '', ' ') }} сом</th>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="form-group">
                    <label for="name" class="form-label">Ваше имя</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" required>
                    <div class="error-message" id="error-name">
                        @error('name')
                        {{ $message }}
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone" class="form-label">Телефон</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="form-control" required>
                    <div class="error-message" id="error-phone">
                        @error('phone')
                        {{ $message }}
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="deliveryMethod" class="form-label">Способ получения</label>
                    <select name="delivery_method" id="deliveryMethod" class="form-select" required>
                        <option value="">-- Выберите --</option>
                        <option value="pickup" {{ old('delivery_method') == 'pickup' ? 'selected' : '' }}>Самовывоз</option>
                        <option value="delivery" {{ old('delivery_method') == 'delivery' ? 'selected' : '' }}>Доставка</option>
                    </select>
                    <div class="error-message" id="error-delivery_method">
                        @error('delivery_method')
                        {{ $message }}
                        @enderror
                    </div>
                </div>

                <div id="addressSection" class="form-group {{ old('delivery_method') == 'delivery' ? '' : 'hidden' }}">
                    <label for="address" class="form-label">Адрес доставки</label>
                    <input type="text" name="address" id="address" value="{{ old('address') }}" class="form-control" placeholder="Улица, дом, квартира">
                    <div class="error-message" id="error-address">
                        @error('address')
                        {{ $message }}
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Оформить заказ</button>
            </form>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const delivery = document.getElementById('deliveryMethod');
            const address = document.getElementById('addressSection');

            delivery.addEventListener('change', () => {
                const showAddress = delivery.value === 'delivery';
                address.classList.toggle('hidden', !showAddress);
                document.getElementById('address').required = showAddress;
            });
        });
    </script>
@endsection
