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
        <!--[if lt IE 9]>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <script src="js/html5shiv.js"></script>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <script src="js/respond.min.js"></script>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <![endif]-->
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
                <div class="breadcrumbs">
                    <ol class="breadcrumb">
                        <li><a href="{{ route('site.home') }}">Home</a></li>
                        <li class="active">Shopping Cart</li>
                    </ol>
                </div>
                <div id="List-Cart">
                    <div class="table-responsive cart_info">
                        <table class="table table-condensed">
                            <thead>
                                <tr class="cart_menu">
                                    <td class="image text-center">Hình ảnh</td>
                                    <td class="description text-center">Tên</td>
                                    <td class="price text-center">Giá</td>
                                    <td class="quantity text-center">Số lượng</td>
                                    <td class="total text-center">Tổng</td>
                                    {{-- <td class="total">Lưu</td> --}}
                                    <td class="total"></td>
                                </tr>
                            </thead>
                            <tbody>
                                @if (Session::has('Cart') != null)
                                    @foreach (Session::get('Cart')->products as $item)
                                        @php
                                            $product_image = $item['image'];
                                            $hinh = null;
                                            if (count($product_image) > 0) {
                                                $hinh = $product_image[0]['image'];
                                            }
                                            
                                        @endphp
                                        <tr>
                                            <td class="cart_product">
                                                <img style="width:80px" src="{{ asset('images/product/' . $hinh) }}"
                                                    alt="{{ $hinh }}">
                                            </td>
                                            <td class="cart_description">
                                                <p>{{ $item['productInfo']->name }}</p>
                                            </td>
                                            <td class="cart_price">
                                                <p>{{ number_format($item['productInfo']->price_buy) }}</p>
                                            </td>
                                            <td class="cart_quantity">
                                                <div class="cart_quantity_button">
                                                    <input id="quanty-item-{{ $item['productInfo']->id }}"
                                                        class="cart_quantity_input" type="text"
                                                        value="{{ $item['soluong'] }}" autocomplete="off" size="2">
                                                </div>
                                            </td>
                                            <td class="cart_total">
                                                <p class="cart_total_price">
                                                    {{ number_format($item['gia']) }} VNĐ
                                                </p>
                                            </td>
                                            <td class="cart_delete">
                                                <a class="cart_quantity_delete"
                                                    onclick="DeleteListItemCart({{ $item['productInfo']->id }});"><i
                                                        class="fa fa-times"></i></a>
                                                <a onclick="SaveListItemCart({{ $item['productInfo']->id }})";><i
                                                        class="fa fa-save"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    {{-- tính tổng --}}
                    <div class="row">
                        <div class="col-lg-4 offset-lg-8 float-end">
                            <div class="proceed-checkout">
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <td class="text-center">Tổng tiền</td>
                                        <td class="text-center"> Tổng số lượng</td>

                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            @if (Session::has('Cart') != null)
                                                {{ number_format(Session::get('Cart')->tonggia, 0) }} VNĐ
                                            @else
                                                0
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if (Session::has('Cart') != null)
                                                {{ Session::get('Cart')->tongsoluong }}
                                            @else
                                                0
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{-- end  tính tổng --}}
                </div>
            </div>
        </section>

        <!--/Footer-->



        <script src="{{ asset('frontend/js/jquery.js') }}"></script>
        <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('frontend/js/jquery.scrollUp.min.js') }}"></script>
        <script src="{{ asset('frontend/js/jquery.prettyPhoto.js') }}"></script>
        <script src="{{ asset('frontend/js/main.js') }}"></script>
        <script>
            function DeleteListItemCart(id) {
                $.ajax({
                    url: 'Delete-Item-List-Cart/' + id,
                    type: 'GET',
                }).done(function(ketqua) {
                    RenderListCart(ketqua)
                    alertify.success('Đã xóa sản phẩm thành công !');
                });
            }

            function SaveListItemCart(id) {
                $.ajax({
                    url: 'Save-Item-List-Cart/' + id + '/' + $("#quanty-item-" + id).val(),
                    type: 'GET',
                }).done(function(ketqua) {
                    RenderListCart(ketqua)
                    //alertify.success('Đã cập nhât sản phẩm thành công !');
                });
            }

            function RenderListCart(ketqua) {
                $("#List-Cart").empty();
                $("#List-Cart").html(ketqua);
            }
        </script>

    </body>

    </html>
@endsection
