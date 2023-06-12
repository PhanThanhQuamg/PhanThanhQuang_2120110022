<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>@yield('title')</title>
    <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
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
    <link rel="shortcut icon" href="frontend/images/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144"
        href="frontend/images/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114"
        href="frontend/images/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="frontend/images/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="frontend/images/apple-touch-icon-57-precomposed.png">
</head>
<!--/head-->
<style>
    .product {
        width: 100%;
        height: 100%;
        position: absolute;
        top: 50%;
        transform: translate(-50% -50%);

    }

    .product-img img {
        height: 80px;
        width: 90px;
        margin: 10px 0;
        display: block;
        cursor: pointer;
        opacity: 0.6;
        transform: 0.8s;
    }

    .product-img img:hover {
        opacity: 1;
    }

    .img-container {
        float: left;
    }

    .img-container img {
        height: 480px;
        width: 600px;
        margin: 10px;
        margin-top: 10px;
    }

    input[type=text] {
        margin-top: 10px;
        width: 80%;
        -webkit-transition: width 0.4s ease-in-out;
        transition: width 0.4s ease-in-out;
    }

    /* When the input field gets focus, change its width to 100% */
    input[type=text]:focus {
        width: 100%;
    }
</style>

<body>
    <header id="header">
        <div class="header-middle">
            <!--header-middle-->
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <div class="logo pull-left">
                            <a href="index.html"><img style="width:120px;hieght:50px";
                                    src="frontend/images/thanhquang.png" alt="" /></a>
                        </div>
                    </div>
                    <div class="col-md-5 ">

                        <form action="{{ route('site.search') }}" method="get">

                            <input class="form-control" type="text" name="key" placeholder="Tìm kiếm..">


                        </form>
                    </div>
                    <div class="col-md-4">
                        <div class="shop-menu pull-right">
                            <ul class="nav navbar-nav">
                                <li>
                                    <!-- Button trigger modal -->
                                    <a data-toggle="modal" data-target="#staticBackdrop">
                                        <i style="font-size: 16px" class="fa fa-shopping-cart"> Giỏ hàng</i>
                                    </a>

                                    <!-- Modal -->
                                    <div class="modal fade" id="staticBackdrop" data-backdrop="static"
                                        data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="staticBackdropLabel">GIỎ HÀNG</h5>
                                                    <button style="margin-bottom:25px" type="button" class="close"
                                                        data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <div id="change-item-cart">
                                                    @if (Session::has('Cart') != null)
                                                        <div class="modal-body">
                                                            <table class="table table-bordered">
                                                                <tbody>
                                                                    @foreach (Session::get('Cart')->products as $item)
                                                                        @php
                                                                            $product_image = $item['image'];
                                                                            $hinh = null;
                                                                            if (count($product_image) > 0) {
                                                                                $hinh = $product_image[0]['image'];
                                                                            }
                                                                            
                                                                        @endphp

                                                                        <tr class="align-middle">
                                                                            <td style="width:100px"
                                                                                class="align-middle">
                                                                                <img style="width:80px"
                                                                                    src="{{ asset('images/product/' . $hinh) }}"
                                                                                    alt="{{ $hinh }}">
                                                                            </td>
                                                                            <td style="width:400px">
                                                                                <p>{{ $item['productInfo']->name }}</p>
                                                                                {{ number_format($item['productInfo']->price_buy) }}
                                                                                x {{ $item['soluong'] }}
                                                                            </td>

                                                                            <td class="si-close ">
                                                                                <i class="fa fa-times"
                                                                                    style="margin-right: 15px; margin-top:15px"
                                                                                    data-id="{{ $item['productInfo']->id }}"></i>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach

                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>
                                                                            <h6>Tổng</h6>
                                                                        </th>
                                                                        <th>
                                                                            {{ number_format(Session::get('Cart')->tonggia, 0) }}
                                                                            đ
                                                                        </th>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    @else
                                                        <p class="text-center mt-4">Không có sản phẩm trong giỏ hàng
                                                        </p>
                                                    @endif

                                                </div>
                                                <div class="modal-footer">


                                                    <div class="col-md-6">

                                                    </div>
                                                    <div class="col-md-3">
                                                        <a href="{{ route('cart.ListCart') }}"
                                                            class="btn btn-default add-to-cart"><i
                                                                class="fa fa-shopping-cart"></i>Xem gio hang</a>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <a href="{{ route('cart.Checkout') }}"
                                                            class="btn btn-default add-to-cart"><i
                                                                class="fa fa-shopping-cart"></i>Thanh toán</a>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>

                                </li>

                                @if (Auth::guard('customer')->check())
                                    <li><a href="#"><i class="fa fa-user"></i>
                                            {{ Auth('customer')->user()->name }}</a>
                                    </li>
                                    <li><a href="{{ route('frontend.logout') }}"><i class="fa fa-lock"></i> Đăng
                                            xuất</a>
                                    </li>
                                @else
                                    <li><a href="{{ route('frontend.login') }}"><i class="fa fa-lock"></i> Đăng
                                            nhập</a>
                                    </li>
                                @endif

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/header-menu-->
        <div class="header-bottom">
            <x-main-menu />
        </div>
        <!--/header-menu-->
    </header>
    <!--/header-->


    <!--/slider-->
    @yield('content')
    <footer id="footer">
        <!--Footer-->
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-sm-2">

                    </div>


                </div>
            </div>
        </div>
        <div class="footer-widget">
            <div class="container">
                <x-footer-menu />
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <p class="pull-left">Copyright © 2013 E-SHOPPER Inc. All rights reserved.</p>
                    <p class="pull-right">Designed by <span><a target="_blank"
                                href="http://www.themeum.com">Themeum</a></span></p>
                </div>
            </div>
        </div>

    </footer>
    <!--/Footer-->



    <script src="{{ asset('frontend/js/jquery.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ asset('frontend/js/price-range.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.prettyPhoto.js') }}"></script>


    <!-- JavaScript -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
    <!-- Semantic UI theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css" />
    <!-- Bootstrap theme -->

    <script>
        function AddCart(id) {
            $.ajax({
                url: 'Add-Cart/' + id,
                type: 'GET',
            }).done(function(ketqua) {
                // console.log(ketqua);
                $("#change-item-cart").empty();
                $("#change-item-cart").html(ketqua);
                alertify.success('Đã thêm sản phẩm vào giỏ hàng !');
            });
        }

        $("#change-item-cart").on("click", ".si-close i", function() {

            //  console.log(id);
            $.ajax({
                url: 'Delete-Item-Cart/' + $(this).data("id"),
                type: 'GET',
            }).done(function(ketqua) {
                $("#change-item-cart").empty();
                $("#change-item-cart").html(ketqua);
                alertify.success('Đã xóa sản phẩm thành công!');
            });
        });
    </script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>

</body>

</html>
