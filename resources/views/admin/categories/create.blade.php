@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1>Добавить категорию</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Название</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="slug" class="form-label">Slug</label>
                <input type="text" name="slug" id="slug" value="{{ old('slug') }}" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Сохранить</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Отмена</a>
        </form>
    </div>
@endsection
