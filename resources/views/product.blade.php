@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <img src="{{ $product->image }}" class="img-fluid" alt="">
        </div>
        <div class="col-md-6">
            <h2>{{ $product->name }}</h2>
            <p>{{ $product->description }}</p>
            <h4 class="text-success">{{ $product->price }} сом</h4>
        </div>
    </div>
@endsection
