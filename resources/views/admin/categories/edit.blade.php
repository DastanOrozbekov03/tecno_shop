@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1>Редактировать категорию</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Название</label>
                <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="slug" class="form-label">Slug</label>
                <input type="text" name="slug" id="slug" value="{{ old('slug', $category->slug) }}" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Обновить</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Отмена</a>
        </form>
    </div>
@endsection
