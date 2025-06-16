@extends('layouts.admin')

@section('title', 'Управление заказами')

@section('styles')
    <style>
        /* Пагинация */
        .pagination {
            justify-content: center;
            margin-top: 1.5rem;
            gap: 0.1rem;
        }
        .page-item .page-link {
            font-size: 0.85rem !important;
            padding: 0.25rem 0.5rem !important;
            color: #2c3e50;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            min-width: 30px;
            text-align: center;
            transition: background-color 0.2s, color 0.2s;
        }
        .page-item .page-link:hover {
            background-color: #34495e;
            color: #fff;
            border-color: #34495e;
        }
        .page-item.active .page-link {
            background-color: #2c3e50;
            border-color: #2c3e50;
            color: #fff;
        }
        .page-item.disabled .page-link {
            color: #6c757d;
            cursor: not-allowed;
            background-color: #fff;
            border-color: #dee2e6;
        }
    </style>
@endsection

@section('content')
    <div class="mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Управление заказами</h1>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Вернуться в админ-панель</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="mb-3">
            <strong>Общая прибыль:</strong> {{ number_format($profit, 0, '', ' ') }} сом
        </div>

        <form method="GET" class="mb-3">
            <div class="row g-2">
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">Все статусы</option>
                        <option value="new" {{ request('status') === 'new' ? 'selected' : '' }}>Новый</option>
                        <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>В обработке</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Завершен</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="payment_status" class="form-select">
                        <option value="">Все оплаты</option>
                        <option value="pending" {{ request('payment_status') === 'pending' ? 'selected' : '' }}>Ожидает</option>
                        <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>Оплачен</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="received_status" class="form-select">
                        <option value="">Все получения</option>
                        <option value="pending" {{ request('received_status') === 'pending' ? 'selected' : '' }}>Ожидает</option>
                        <option value="received" {{ request('received_status') === 'received' ? 'selected' : '' }}>Получен</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control" placeholder="Дата создания от">
                </div>
                <div class="col-md-2">
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control" placeholder="Дата создания до">
                </div>
                <div class="col-md-2">
                    <input type="date" name="received_from" value="{{ request('received_from') }}" class="form-control" placeholder="Дата получения от">
                </div>
                <div class="col-md-2">
                    <input type="date" name="received_to" value="{{ request('received_to') }}" class="form-control" placeholder="Дата получения до">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Фильтровать</button>
                </div>
            </div>
        </form>

        <form method="POST" action="{{ route('admin.orders.delete-uncollected') }}" class="mb-3">
            @csrf
            <div class="input-group" style="width: 300px;">
                <span class="input-group-text">Удалить заказы старше</span>
                <input type="number" name="days" id="days" value="30" min="1" class="form-control">
                <button type="submit" class="btn btn-danger">Удалить</button>
            </div>
        </form>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>№</th>
                <th>Клиент</th>
                <th>Телефон</th>
                <th>Адрес</th>
                <th>Сумма</th>
                <th>Доставка</th>
                <th>Статус</th>
                <th>Оплата</th>
                <th>Дата оплаты</th>
                <th>Получение</th>
                <th>Дата получения</th>
                <th>Дата создания</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>{{ $order->phone }}</td>
                    <td>{{ $order->address ?: '—' }}</td>
                    <td>{{ number_format($order->total, 0, '', ' ') }} сом</td>
                    <td>{{ $order->delivery_method == 'pickup' ? 'Самовывоз' : 'Доставка' }}</td>
                    <td>
                        @if($order->status == 'new') Новый
                        @elseif($order->status == 'processing') В обработке
                        @elseif($order->status == 'completed') Завершен
                        @endif
                    </td>
                    <td>{{ $order->payment_status == 'paid' ? 'Оплачен' : 'Ожидает' }}</td>
                    <td>{{ $order->paid_at ? \Carbon\Carbon::parse($order->paid_at)->translatedFormat('d F Y H:i') : '—' }}</td>
                    <td>{{ $order->received_status == 'received' ? 'Получен' : 'Ожидает' }}</td>
                    <td>{{ $order->received_at ? \Carbon\Carbon::parse($order->received_at)->translatedFormat('d F Y H:i') : '—' }}</td>
                    <td>{{ \Carbon\Carbon::parse($order->created_at)->translatedFormat('d F Y H:i') }}</td>
                    <td>
                        @if($order->received_status == 'pending')
                            <form action="{{ route('admin.orders.received', $order->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Получен</button>
                            </form>
                        @endif
                        @if($order->payment_status == 'pending')
                            <form action="{{ route('admin.orders.paid', $order->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">Оплачен</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $orders->links('vendor.pagination.custom') }}
    </div>
@endsection
