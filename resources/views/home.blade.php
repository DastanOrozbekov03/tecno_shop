@extends('layouts.app')

@section('content')
    <div class="category-list" data-aos="fade-right" data-aos-duration="800">
        <a href="{{ route('home') }}" class="{{ request('category') ? '' : 'active' }}">
            Все
        </a>
        @foreach($categories as $category)
            <a href="{{ route('home', ['category' => $category->slug, 'search' => request('search')]) }}"
               class="{{ request('category') === $category->slug ? 'active' : '' }}">
                {{ $category->name }}
            </a>
        @endforeach
    </div>

    @if($products->count() == 0)
        <div class="alert alert-warning" role="alert" data-aos="fade-in" data-aos-duration="700">
            Товары не найдены.
        </div>
    @else
        <div class="row g-3" data-aos="fade-up" data-aos-duration="700">
            @foreach($products as $product)
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 d-flex">
                    <a href="{{ route('product.show', $product->id) }}"
                       class="product-card text-decoration-none text-dark w-100">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="product-image open-modal" data-img="{{ $product->image_url }}" />
                        <div class="product-info">
                            <div class="product-title">{{ \Illuminate\Support\Str::limit($product->name, 60) }}</div>
                            <div class="product-price">{{ number_format($product->price, 0, '', ' ') }} сом</div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $products->withQueryString()->links('vendor.pagination.bootstrap-5') }}
        </div>
    @endif

    {{-- Модальное окно --}}
    <div id="imageModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-content">
            <img id="modalImage" src="" alt="Увеличенное изображение">
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const btn = document.getElementById('addToCartBtn');
            const quantityInput = document.getElementById('quantity');
            const message = document.getElementById('cart-message');

            btn.addEventListener('click', async () => {
                const productId = btn.getAttribute('data-product-id');
                const quantity = quantityInput.value;

                try {
                    const response = await fetch(`/cart/add/${productId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': window.csrfToken,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ quantity })
                    });

                    const result = await response.json();

                    if (result.unauthorized) {
                        const modal = new bootstrap.Modal(document.getElementById('loginModal'));
                        modal.show();
                    } else if (result.success) {
                        message.innerText = result.message;
                        message.style.display = 'block';
                        setTimeout(() => message.style.display = 'none', 3000);
                    }
                } catch (err) {
                    console.error('Ошибка:', err);
                }
            });
        });
    </script>

@endsection
