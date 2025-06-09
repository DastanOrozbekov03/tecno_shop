@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2>Ваша корзина</h2>

        @if($cart->count())
            <table class="table table-bordered mt-3">
                <thead>
                <tr>
                    <th>Товар</th>
                    <th>Цена</th>
                    <th>Количество</th>
                    <th>Сумма</th>
                    <th></th>
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
                        <td>
                            <form action="{{ route('cart.remove', $item->product->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3" class="text-end"><strong>Итого:</strong></td>
                    <td colspan="2"><strong>{{ number_format($total, 0, '', ' ') }} сом</strong></td>
                </tr>
                </tbody>
            </table>

            <a href="{{ route('checkout') }}" class="btn btn-success">Оформить заказ</a>
        @else
            <p>Ваша корзина пуста.</p>
        @endif
    </div>
@endsection
