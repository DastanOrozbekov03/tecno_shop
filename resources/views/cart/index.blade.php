@extends('layouts.app')

@section('content')
    <div class="custom-container" data-aos="fade-up">
        <div class="mb-4 position-relative">
            <a href="{{ url()->previous() }}" class="btn btn-secondary position-absolute start-0">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h1 class="text-center mb-0">Корзина</h1>
        </div>

        @if($cart->isEmpty())
            <div class="alert alert-info">Ваша корзина пуста.</div>
        @else
            <div class="custom-table">
                <table>
                    <thead>
                    <tr>
                        <th>Товар</th>
                        <th>Цена</th>
                        <th>Кол-во</th>
                        <th>Итого</th>
                        <th>Действия</th>
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
                            <td>
                                <input type="number" value="{{ $item->quantity }}" min="1"
                                       data-product-id="{{ $item->product->id }}"
                                       class="quantity-input form-control">
                            </td>
                            <td>{{ number_format($subtotal, 0, '', ' ') }} сом</td>
                            <td>
                                <form action="{{ route('cart.remove', $item->product->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <th colspan="3" class="text-end">К оплате:</th>
                        <th class="cart-total">{{ number_format($total, 0, '', ' ') }} сом</th>
                        <th></th>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                <a href="{{ route('checkout') }}" class="btn btn-success">Оформить заказ</a>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const quantityInputs = document.querySelectorAll('.quantity-input');
            quantityInputs.forEach(input => {
                input.addEventListener('change', function () {
                    const productId = this.dataset.productId;
                    const quantity = this.value;

                    fetch(`/cart/update/${productId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({ quantity }),
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Обновление итогов на странице
                                location.reload();
                                // Динамическое обновление значка корзины
                                const badge = document.querySelector('.cart-badge');
                                if (data.total > 0) {
                                    badge.textContent = data.total;
                                    badge.style.display = 'block';
                                } else {
                                    badge.style.display = 'none';
                                }
                            } else {
                                alert(data.message);
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            });
        });
    </script>
@endsection
