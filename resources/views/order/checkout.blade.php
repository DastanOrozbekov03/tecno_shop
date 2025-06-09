@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1>Оформление заказа</h1>

        @if($cart->isEmpty())
            <div class="alert alert-info">Ваша корзина пуста.</div>
        @else
            <form method="POST" action="{{ route('checkout.process') }}">
                @csrf

                <table class="table table-bordered">
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
                        <th>{{ number_format($total, 0, '', ' ') }} сом</th>
                    </tr>
                    </tbody>
                </table>

                {{-- Имя --}}
                <div class="mb-3">
                    <label class="form-label">Ваше имя</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                {{-- Телефон --}}
                <div class="mb-3">
                    <label class="form-label">Телефон</label>
                    <input type="text" name="phone" class="form-control" required>
                </div>

                {{-- Доставка --}}
                <div class="mb-3">
                    <label class="form-label">Способ получения</label>
                    <select name="delivery_method" class="form-select" id="deliveryMethod" required>
                        <option value="">-- Выберите --</option>
                        <option value="pickup">Самовывоз</option>
                        <option value="delivery">Доставка</option>
                    </select>
                </div>

                {{-- Адрес --}}
                <div class="mb-3" id="addressSection" style="display: none;">
                    <label class="form-label">Адрес доставки</label>
                    <input type="text" name="address" class="form-control" placeholder="Улица, дом, квартира">
                </div>

                {{-- Оплата --}}
                <div class="mb-3">
                    <label class="form-label">Способ оплаты</label>
                    <select name="payment_method" class="form-select" required>
                        <option value="">-- Выберите --</option>
                        <option value="mbank">MBank</option>
                        <option value="elsom">ElSom</option>
                        <option value="optima">Optima</option>
                        <option value="cash">Наличные при получении</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">Перейти к оплате</button>
            </form>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('deliveryMethod').addEventListener('change', function () {
            let addressSection = document.getElementById('addressSection');
            if (this.value === 'delivery') {
                addressSection.style.display = 'block';
            } else {
                addressSection.style.display = 'none';
            }
        });
    </script>
@endsection
