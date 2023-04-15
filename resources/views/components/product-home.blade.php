@foreach ($product_list as $product)
    @php
        $product_image = $product->productimg;
        $hinh = null;
        if (count($product_image) > 0) {
            $hinh = $product_image[0]['image'];
        }
    @endphp
    <div class="col-sm-4">
        <div class="product-image-wrapper">
            <div class="single-products">
                <div class="productinfo text-center">
                    <img src="{{ asset('images/product/' . $hinh) }}" alt="{{ $hinh }}" />
                    <h2>{{ $product->price_buy }}</h2>
                    <p>{{ $product->name }}</p>
                    <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to
                        cart</a>
                </div>
                <div class="product-overlay">
                    <div class="overlay-content">
                        <a href="{{ route('slug.home', ['slug' => $product->slug]) }}"><img
                                src="{{ asset('images/product/' . $hinh) }}" alt="{{ $hinh }}" /></a>
                        <h2>{{ $product->price_buy }}</h2>
                        <p>{{ $product->name }}</p>
                        <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to
                            cart</a>
                    </div>
                </div>
            </div>
            <div class="choose">
                <ul class="nav nav-pills nav-justified">
                    <li><a href="#"><i class="fa fa-plus-square"></i>Add to wishlist</a>
                    </li>
                    <li><a href="#"><i class="fa fa-plus-square"></i>Add to compare</a></li>
                </ul>
            </div>
        </div>
    </div>
@endforeach
