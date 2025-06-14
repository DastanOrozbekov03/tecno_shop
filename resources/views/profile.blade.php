@extends('layouts.app')

@section('content')
    <div class="custom-container" data-aos="fade-up">
        <h1>Ваш профиль</h1>
        <h2>Ваши заказы</h2>
        @if($orders->isEmpty())
            <p>У вас пока нет заказов.</p>
        @else
            <div class="custom-table profile-table">
                <table>
                    <thead>
                    <tr>
                        <th>Номер заказа</th>
                        <th>Дата</th>
                        <th>Сумма</th>
                        <th>Статус</th>
                        <th>Способ доставки</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                            <td>{{ number_format($order->total, 0, '', ' ') }} сом</td>
                            <td>{{ $order->status }}</td>
                            <td>{{ $order->delivery_method === 'pickup' ? 'Самовывоз' : 'Доставка' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
