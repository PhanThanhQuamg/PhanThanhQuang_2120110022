@extends('layouts.site')
@section('title', $row_brand->name)
@section('content')
    <div class="container">
        <h2 class="text-center my-5 category-title"> {{ $row_brand->name }}</h2>
        <div class="product-image-wrapper">
            <div class="row">
                <div class="col-md-3">
                    <x-category-list />
                    <x-brand-list />

                </div>
                <div class="col-md-9">
                    @foreach ($product_list as $product)
                        @php
                            $product_image = $product->productimg;
                            $hinh = null;
                            if (count($product_image) > 0) {
                                $hinh = $product_image[0]['image'];
                            }
                        @endphp
                        <div class="col-md-4">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                    <a href="{{ route('slug.home', ['slug' => $product->slug]) }}">
                                        <img style="height:180px" class="img-fluid w-100"
                                            src="{{ asset('images/product/' . $hinh) }}" alt="{{ $hinh }}" /></a>
                                    <h2>{{ number_format($product->price_buy, 0) }}VNĐ</h2>
                                    <p
                                        style="  text-overflow: ellipsis;
                            overflow: hidden;
                            white-space: nowrap;">
                                        {{ $product->name }}</p>
                                    <a onclick="AddCart({{ $product->id }})" href="javasCrip:"
                                        class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm giỏ
                                        hàng</a>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-12">
            {{ $product_list->links() }}</div>
    </div>
    </div>
@endsection
