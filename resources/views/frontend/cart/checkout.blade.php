@extends('layouts.site')
@section('title', 'Trang chủ')
@section('content')

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Cart | E-Shopper</title>
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend/css/font-awesome.min.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend/css/prettyPhoto.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend/css/price-range.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend/css/animate.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend/css/main.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend/css/responsive.css') }}" rel="stylesheet">

        <link rel="shortcut icon" href="images/ico/favicon.ico">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
    </head>
    <!--/head-->

    <body>
        <section id="cart_items">
            <div class="container">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4">
                            <h3>Thông tin khách hàng</h3>
                            <div class="col form-group">
                                <label>Họ tên khách hàng</label>
                                <input class="form-control" readonly type="text"
                                    value="{{ Auth::guard('customer')->user()->name }}">
                            </div>
                            <div class="col form-group">
                                <label>Số điện thoại</label>
                                <input class="form-control" readonly type="text"
                                    value="{{ Auth::guard('customer')->user()->phone }}">
                            </div>
                            <div class="col form-group">
                                <label>Email</label>
                                <input class="form-control" type="text" readonly type="text"
                                    value="{{ Auth::guard('customer')->user()->email }}">
                            </div>
                            <div class="col form-group">
                                <label>Địa chỉ </label>
                                <textarea readonly class="form-control" name="" id="" cols="30" rows="4">{{ Auth::guard('customer')->user()->address }}</textarea>

                            </div>
                        </div>
                        <div class="col-md-8">
                            <h3>Thông tin đơn hàng</h3>

                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>

                                        <th style="width:200px">Hình</th>
                                        <th style="width:100px" class="text-center text-truncate">Tên sản phẩm</th>
                                        <th style="width:50px" class="text-center">SL</th>
                                        <th style="width:100px" class="text-center">Đơn giá</th>
                                        <th style="width:100px" class="text-center">Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach (Session::get('Cart')->products as $item)
                                        @php
                                            $product_image = $item['image'];
                                            $hinh = null;
                                            if (count($product_image) > 0) {
                                                $hinh = $product_image[0]['image'];
                                            }
                                            
                                        @endphp
                                        <tr>
                                            <td>
                                                <img style="width:100px" src="{{ asset('images/product/' . $hinh) }}"
                                                    alt="{{ $hinh }}">
                                            </td>
                                            <td class=" align-middle"
                                                style="text-overflow: ellipsis;overflow: hidden;white-space: nowrap;">
                                                {{ $item['productInfo']->name }}</td>
                                            <td class=" align-middle">{{ $item['soluong'] }}</td>
                                            <td class=" align-middle">
                                                {{ number_format($item['productInfo']->price_buy) }}</td>
                                            <td class="text-center align-middle">
                                                {{ number_format($item['soluong'] * $item['productInfo']->price_buy) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <h2>Tổng tiền: {{ number_format(Session::get('Cart')->tonggia, 0) }} VNĐ
                            </h2>

                        </div>

                    </div>
                </div>
                <button type="submit" class="btn btn-sm text-center" style="margin-bottom:20px;width:120px;"><a
                        style="font-size:20px" href="{{ route('cart.thanhcong') }}">Đặt
                        hàng</a></button>
            </div>

        </section>


    </body>

    </html>
@endsection
