@extends('layouts.app')

@section('content')
    <div class="custom-container" data-aos="fade-up">
        <h2>Вход</h2>
        <form method="POST" action="{{ route('login') }}" class="auth-form">
            @csrf
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

            <button type="submit" class="btn btn-primary">Войти</button>
        </form>

        <div class="auth-links">
            Нет аккаунта? <a href="{{ route('register') }}">Зарегистрируйтесь здесь</a>
        </div>
    </div>
@endsection
