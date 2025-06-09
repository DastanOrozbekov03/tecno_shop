@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Регистрация</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <input type="text" name="name" placeholder="Имя" value="{{ old('name') }}" required>
            @error('name')<div>{{ $message }}</div>@enderror

            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
            @error('email')<div>{{ $message }}</div>@enderror

            <input type="password" name="password" placeholder="Пароль" required>
            @error('password')<div>{{ $message }}</div>@enderror

            <input type="password" name="password_confirmation" placeholder="Подтвердите пароль" required>

            <button type="submit">Зарегистрироваться</button>
        </form>
    </div>
@endsection
