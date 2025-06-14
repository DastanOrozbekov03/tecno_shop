@extends('layouts.app')

@section('content')
    <div class="custom-container" data-aos="fade-up">
        <h2>Регистрация</h2>
        <form method="POST" action="{{ route('register') }}" class="auth-form">
            @csrf
            <div class="form-group">
                <label for="name" class="form-label">Имя</label>
                <input type="text" name="name" id="name" placeholder="Введите имя" value="{{ old('name') }}" class="form-control" required>
                <div class="error-message">
                    @error('name')
                    {{ $message }}
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" placeholder="Введите email" value="{{ old('email') }}" class="form-control" required>
                <div class="error-message">
                    @error('email')
                    {{ $message }}
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Пароль</label>
                <input type="password" name="password" id="password" placeholder="Введите пароль" class="form-control" required>
                <div class="error-message">
                    @error('password')
                    {{ $message }}
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">Подтвердите пароль</label>
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Подтвердите пароль" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
        </form>

        <div class="auth-links">
            Уже есть аккаунт? <a href="{{ route('login') }}">Войдите здесь</a>
        </div>
    </div>
@endsection
