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

        <div class="row">
            <div class="col-md-6">
                <div class="">
                    <div class="product">
                        <div class="card " style="max-width: 450px;">
                            <div class="row no-gutters">
                                <div class="col-md-4">
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
                                <div class="col-md-6">
                                    <div class="card-body">
                                        <div class="img-container">
                                            <img style="height:400px" class="img-fluid"
                                                src="{{ asset('images/product/' . $hinh) }}" id="imgBox">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="product-information">
                    <!--/product-information-->
                    <img src="images/product-details/new.jpg" class="newarrival" alt="">
                    <h2>{{ $product->name }}</h2>
                    <span>

                        <span>{{ number_format($product->price_buy, 0) }} VNĐ</span>


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

                    <a onclick="AddCart({{ $product->id }})" href="javasCrip:" class="btn btn-default add-to-cart"><i
                            class="fa fa-shopping-cart"></i>Thêm giỏ hàng</a>
                </div>
                <!--/product-information-->
            </div>
        </div>
        <div style="margin-top: 50px" class="container">
            <h2 class="text-center text-danger">Chi Tiết Sản Phẩm</h2>
            <p> {!! $product->detail !!}</p>
        </div>




        <!--/category-tab-->

        @if (count($product_list) > 0)
            <div class="recommended_items">
                <!--recommended_items-->
                <h2 class="title text-center">Sản phẩm cùng loại</h2>
                <div class="col-md-12">
                    @foreach ($product_list as $row)
                        @php
                            $product_image = $row->productimg;
                            $hinh = null;
                            if (count($product_image) > 0) {
                                $hinh = $product_image[0]['image'];
                            }
                        @endphp
                        <div class="col-md-3">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                    <a href="{{ route('slug.home', ['slug' => $row->slug]) }}">
                                        <img style="width:250px;height:200px" src="{{ asset('images/product/' . $hinh) }}"
                                            alt="{{ $hinh }}" />
                                    </a>
                                    <h2>{{ number_format($row->price_buy, 0) }} VNĐ</h2>
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
        @endif
        <!--/recommended_items-->




    </section>
    <script>
        function myFunction(smallimg) {
            var fullImg = document.getElementById('imgBox')
            fullImg.src = smallimg.src;
        }
    </script>

@endsection
