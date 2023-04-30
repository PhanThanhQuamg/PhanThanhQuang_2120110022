@extends('layouts.site')
@section('title', 'Kết quả tìm kiếm')
@section('content')

    <div class="container">
        <div class="row">
            @foreach ($listsp as $product)
                @php
                    $product_image = $product->productimg;
                    $hinh = null;
                    if (count($product_image) > 0) {
                        $hinh = $product_image[0]['image'];
                    }
                @endphp

                <div class="col-md-3 text-center">
                    <div class="card" style="width: 200px;">
                        <a href="{{ route('slug.home', ['slug' => $product->slug]) }}">
                            <img src="{{ asset('images/product/' . $hinh) }}" class="img-fluid" style="width:120px;"
                                alt="{{ $hinh }}">
                        </a>
                        <div class="card-body ">
                            <h5 class="card-title"> {{ $product->name }}</h5>
                            <p class="card-text">{{ $product->price_buy }}</p>
                            <button class="btn btn-sm btn-primary " style="margin-bottom: 10px;">Mua hàng</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

@endsection
