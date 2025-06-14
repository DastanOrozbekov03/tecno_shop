@extends('layouts.app')

@section('styles')
    <style>
        /* Контейнер */
        .custom-container {
            width: 100%;
            max-width: 100%;
            padding: 0 15px;
            margin: 0 auto;
            box-sizing: border-box;
            text-align: center; /* Центрирование содержимого */
        }

        /* Заголовок */
        h1 {
            font-size: 2.5rem;
            color: var(--text-dark);
            margin-bottom: 1.5rem;
        }

        /* Сообщение успеха */
        .success-message {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: var(--card-bg);
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
            color: #10B981; /* Зелёный цвет для успеха */
            font-size: 1.5rem;
            font-weight: 600;
        }

        .success-message i {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        /* Номер заказа */
        .order-number {
            background: linear-gradient(90deg, #E0F2FE, #F3E8FF); /* Лёгкий градиент */
            border: 2px solid var(--primary-gradient-start);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            font-size: 1.25rem;
            font-weight: 500;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .order-number i {
            font-size: 1.5rem;
            color: var(--primary-gradient-start);
        }

        /* Инструкции */
        .instructions {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
            text-align: left;
            color: var(--text-muted);
            font-size: 1rem;
        }

        .instructions p {
            margin: 0 0 1rem;
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .instructions i {
            font-size: 1.2rem;
            color: var(--primary-gradient-start);
            margin-top: 0.2rem;
        }

        /* Кнопка на главную */
        .btn-home {
            background: var(--primary-gradient);
            color: #FFFFFF;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 500;
            text-decoration: none;
            transition: transform 0.2s, box-shadow 0.2s;
            display: inline-block;
        }

        .btn-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            color: #FFFFFF;
        }

        /* Кнопка назад */
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            padding: 0.4rem;
            border-radius: 8px;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
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
                font-size: 2rem;
            }
            .success-message {
                font-size: 1.25rem;
                padding: 1.5rem;
            }
            .success-message i {
                font-size: 3rem;
            }
            .order-number {
                font-size: 1.1rem;
                padding: 1rem;
            }
            .instructions {
                padding: 1.5rem;
            }
            .btn-home {
                padding: 0.6rem 1.5rem;
                font-size: 1rem;
            }
        }
    </style>
@endsection

@section('content')
    <div class="custom-container" data-aos="fade-up">
        <div class="mb-4 position-relative">
            <a href="{{ url()->previous() }}" class="btn btn-secondary position-absolute start-0">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h1 class="text-center mb-0">Спасибо за ваш заказ!</h1>
        </div>

        <div class="success-message">
            <i class="bi bi-check-circle-fill"></i>
            Ваш заказ успешно оформлен!
        </div>

        <div class="order-number">
            <i class="bi bi-cart-check"></i>
            Номер вашего заказа: #{{ $order_id }}
        </div>

        <div class="instructions">
            <p>
                <i class="bi bi-info-circle"></i>
                Пожалуйста, сохраните номер заказа. Он понадобится для получения товара.
            </p>
            <p>
                @if(session('delivery_method') === 'pickup')
                    <i class="bi bi-geo-alt"></i>
                    Предъявите номер заказа в пункте самовывоза. Адрес пункта: г. Бишкек, ул. Примерная, 123.
                @else
                    <i class="bi bi-truck"></i>
                    Курьер свяжется с вами для подтверждения доставки. Пожалуйста, предъявите номер заказа курьеру при получении.
                @endif
            </p>
            <p>
                <i class="bi bi-currency-dollar"></i>
                Оплата производится наличными при получении товара.
            </p>
        </div>

        <a href="{{ route('home') }}" class="btn btn-home">Вернуться на главную</a>
    </div>
@endsection
