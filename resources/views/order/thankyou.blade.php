@extends('layouts.app')

@section('content')
<div class="container mt-5 text-center">
    <h1 class="mb-4">Спасибо за ваш заказ!</h1>
    <p class="lead">Ваш заказ успешно оформлен и скоро будет обработан.</p>
    <p>Мы свяжемся с вами по указанному телефону для подтверждения деталей.</p>

    <a href="{{ route('/home') }}" class="btn btn-primary mt-4">Вернуться на главную</a>
</div>
@endsection
