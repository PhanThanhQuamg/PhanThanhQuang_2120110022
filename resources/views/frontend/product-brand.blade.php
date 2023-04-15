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
                                    <img class="img-fluid w-100" src="{{ asset('images/product/' . $hinh) }}"
                                        alt="{{ $hinh }}" />
                                    <h2>{{ $product->price_buy }}</h2>
                                    <p>{{ $product->name }}</p>
                                    <a href="#" class="btn btn-default add-to-cart"><i
                                            class="fa fa-shopping-cart"></i>Add
                                        to
                                        cart</a>
                                </div>
                                <div class="product-overlay">
                                    <div class="overlay-content">
                                        <a href="{{ route('slug.home', ['slug' => $product->slug]) }}">
                                            <img src="{{ asset('images/product/' . $hinh) }}" alt="{{ $hinh }}" />
                                        </a>
                                        <h2>{{ $product->price_buy }}</h2>
                                        <p>{{ $product->name }}</p>
                                        <a href="#" class="btn btn-default add-to-cart"><i
                                                class="fa fa-shopping-cart"></i>Add to
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
                    @endforeach
                </div>
                <div>{{ $product_list->links() }}</div>
            </div>

        </div>
    @endsection
