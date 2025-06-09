@extends('layouts.app')

@section('content')
    <style>
        .product-container {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
            padding: 30px;
            margin-top: 30px;
        }

        .product-image-container {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
        }

        .product-image-container img {
            width: 100%;
            transition: transform 0.4s ease;
            cursor: zoom-in;
            border-radius: 10px;
        }

        .product-image-container:hover img {
            transform: scale(1.15);
        }

        .product-details h2 {
            font-size: 28px;
            font-weight: bold;
        }

        .product-details p {
            font-size: 16px;
            color: #555;
        }

        .product-price {
            font-size: 24px;
            font-weight: 600;
            color: #28a745;
        }

        .order-btn {
            background-color: #007bff;
            color: #fff;
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            margin-top: 20px;
            transition: background-color 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .order-btn:hover {
            background-color: #0056b3;
            text-decoration: none;
            color: #fff;
        }

        @media (max-width: 768px) {
            .product-container {
                padding: 15px;
            }
        }
    </style>

    <div class="container product-container">
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="product-image-container">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                </div>
            </div>
            <div class="col-md-6 product-details">
                <h2>{{ $product->name }}</h2>
                <p class="mt-3">{{ $product->description }}</p>
                <div class="product-price mt-3">
                    {{ number_format($product->price, 0, '', ' ') }} сом
                </div>

                <a
                    href="https://wa.me/996XXXXXXXXX?text=Здравствуйте! Я хочу заказать товар: {{ urlencode($product->name) }} (ID: {{ $product->id }})"
                    class="order-btn"
                    target="_blank"
                >
                    Заказать в WhatsApp
                </a>

                <div class="mt-3" style="max-width: 250px;">
                    <div class="input-group mb-3">
                        <input type="number" id="quantity" class="form-control" value="1" min="1">
                        <button class="btn btn-success" id="addToCartBtn" data-product-id="{{ $product->id }}">
                            Добавить в корзину
                        </button>
                    </div>
                    <div id="cart-message" class="text-success mt-2" style="display:none;"></div>
                </div>
            </div>
        </div>
    </div>



    <!-- Скрипт -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const btn = document.getElementById('addToCartBtn');
            const quantityInput = document.getElementById('quantity');
            const message = document.getElementById('cart-message');

            btn.addEventListener('click', async () => {
                const productId = btn.getAttribute('data-product-id');
                const quantity = quantityInput.value;

                try {
                    const response = await fetch(`/cart/add/${productId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ quantity })
                    });

                    const result = await response.json();

                    if (result.unauthorized) {
                        window.location.href = '/login';
                    } else if (result.success) {
                        message.innerText = result.message;
                        message.style.display = 'block';
                        setTimeout(() => message.style.display = 'none', 3000);
                    }
                } catch (err) {
                    console.error('Ошибка при добавлении в корзину', err);
                }
            });
        });
    </script>

@endsection
