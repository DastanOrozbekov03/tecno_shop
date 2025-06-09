@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Вход</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
            @error('email')<div class="text-danger">{{ $message }}</div>@enderror

            <input type="password" name="password" placeholder="Пароль" required>
            @error('password')<div class="text-danger">{{ $message }}</div>@enderror

            <button type="submit" class="btn btn-primary mt-3">Войти</button>
        </form>

        <p class="mt-3">
            Нет аккаунта?
            <a href="{{ route('register') }}">Зарегистрируйтесь здесь</a>
        </p>
    </div>
@endsection
