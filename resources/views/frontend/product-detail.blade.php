@extends('layouts.site')
@section('title', $product->name)
@section('content')
    @php
        $product_image = $product->productimg;
        $hinh = null;
        if (count($product_image) > 0) {
            $hinh = $product_image[0]['image'];
        }
    @endphp
    <section>

        <div class="col-md-12 ">
            <div class="row">

                <div class="col-md-7">

                    <div class="product ">
                        <div class="product-img">
                            @if (count($product_image) > 1)
                                @for ($i = 0; $i <= count($product_image) - 1; $i++)
                                    @php $image=$product_image[$i]['image']; @endphp
                                    <img src={{ asset('images/product/' . $image) }} alt="{{ $image }}"
                                        onclick="myFunction(this)">
                                @endfor
                            @endif
                        </div>
                    </div>
                    <div class="img-container">
                        <img class="img-fluid" src="{{ asset('images/product/' . $hinh) }}" id="imgBox">
                    </div>
                </div>


                <div class="col-md-5">
                    <div class="product-information">
                        <!--/product-information-->
                        <img src="images/product-details/new.jpg" class="newarrival" alt="">
                        <h2>{{ $product->name }}</h2>
                        <span>

                            <span>{{ number_format($product->price_buy, 0) }} VNĐ</span>
                            <label>Quantity:</label>
                            <input type="text" value="3">

                        </span>


                        <p><b>Trạng thái:</b>
                            @if ($product->status == 1)
                                Còn hàng
                            @else
                                Ngừng kinh doanh
                            @endif
                        </p>

                        <p><b>Thời gian bảo hành: </b> 2 Năm</p>
                        <p><b>Thời gian vận chuyển: </b> 3-5 Ngày</p>
                        <p><b>Thời hiệu:</b> {{ $product->braname }}</p>

                        <button type="button" class="btn btn-fefault cart">
                            <i class="fa fa-shopping-cart"></i>Add to cart
                        </button>
                    </div>
                    <!--/product-information-->
                </div>
            </div>
            <div class="my-4">
                <h2>Chi Tiết Sản Phẩm</h2>
                <p> {{ $product->detail }}</p>
            </div>




            <!--/category-tab-->

            @if (count($product_list) > 0)
                <div class="recommended_items">
                    <!--recommended_items-->
                    <h2 class="title text-center">Sản phẩm cùng loại</h2>
                    <div class="col-md-9">
                        @foreach ($product_list as $row)
                            @php
                                $product_image = $row->productimg;
                                $hinh = null;
                                if (count($product_image) > 0) {
                                    $hinh = $product_image[0]['image'];
                                }
                            @endphp
                            <div class="col-md-4">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        <a href="{{ route('slug.home', ['slug' => $row->slug]) }}">
                                            <img src="{{ asset('images/product/' . $hinh) }}" alt="{{ $hinh }}" />
                                        </a>
                                        <h2>{{ number_format($row->price_buy, 0) }} VNĐ</h2>
                                        <p>{{ $row->name }}</p>
                                        <a href="#" class="btn btn-default add-to-cart"><i
                                                class="fa fa-shopping-cart"></i>Add
                                            to
                                            cart</a>
                                    </div>

                                </div>
                                <div class="choose">
                                    <ul class="nav nav-pills nav-justified">
                                        <li><a href="#"><i class="fa fa-plus-square"></i>Add to wishlist</a>
                                        </li>
                                        <li><a href="#"><i class="fa fa-plus-square"></i>Add to compare</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            @endif
            <!--/recommended_items-->

        </div>


    </section>
    <script>
        function myFunction(smallimg) {
            var fullImg = document.getElementById('imgBox')
            fullImg.src = smallimg.src;
        }
    </script>

@endsection
