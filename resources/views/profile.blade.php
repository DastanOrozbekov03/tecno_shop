@extends('layout') {{-- или имя твоего основного шаблона --}}

@section('content')
    <h1>Профиль пользователя</h1>
    <p>Имя: {{ Auth::user()->name }}</p>
    <p>Email: {{ Auth::user()->email }}</p>
@endsection
