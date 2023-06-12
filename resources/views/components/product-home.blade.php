@foreach ($product_list as $product)
    @php
        $product_image = $product->productimg;
        $hinh = null;
        if (count($product_image) > 0) {
            $hinh = $product_image[0]['image'];
        }
    @endphp
    <div style="margin-bottom: 15px" class="col-md-3 ">
        <div class="product-image-wrapper h-80">
            <div class="single-products">
                <div class="productinfo text-center">
                    <img height="150px" class="img-fluid" src="{{ asset('images/product/' . $hinh) }}"
                        alt="{{ $hinh }}" />
                    <h2>{{ number_format($product->price_buy, 0) }} VNĐ</h2>
                    <p
                        style="  text-overflow: ellipsis;
                            overflow: hidden;
                            white-space: nowrap;">
                        {{ $product->name }}</p>
                    <a onclick="AddCart({{ $product->id }})" href="javasCrip:" class="btn btn-default add-to-cart"><i
                            class="fa fa-shopping-cart"></i>Thêm giỏ hàng</a>
                </div>
                <div class="product-overlay">
                    <div class="overlay-content">
                        <a href="{{ route('slug.home', ['slug' => $product->slug]) }}">
                            <img src="{{ asset('images/product/' . $hinh) }}" alt="{{ $hinh }}" /></a>
                        <h2>{{ number_format($product->price_buy, 0) }} VNĐ</h2>
                        <p>{{ $product->name }}</p>
                        <a onclick="AddCart({{ $product->id }})" href="javasCrip:"
                            class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach

