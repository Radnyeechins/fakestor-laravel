<div class="might-like-section">
    <div class="container">
        <h2>You might also like...</h2>
        <div class="might-like-grid">
            @foreach ($mightAlsoLike as $product)
            @if(isset($notproduct) && $product->id == $notproduct) @continue; @endif
                <a href="{{ route('shop.show', $product->id) }}" class="might-like-product">
                    <img src="{{ $product->image }}" alt="product">
                    <div class="might-like-product-name">{{ $product->title }}</div>
                    <div class="might-like-product-price">{{ $product->price }}</div>
                </a>
            @endforeach

        </div>
    </div>
</div>
