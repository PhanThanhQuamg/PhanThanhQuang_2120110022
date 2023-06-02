<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Phan Thanh Quang</title>
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
</style>

<body>
    <header id="header">
        <!--header-->
        <div class="header_top">
            <!--header_top-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="contactinfo">
                            <ul class="nav nav-pills">
                                <li><a href="#"><i class="fa fa-phone"></i> +2 95 01 88 821</a></li>
                                <li><a href="#"><i class="fa fa-envelope"></i> info@domain.com</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="social-icons pull-right">
                            <ul class="nav navbar-nav">
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/header_top-->

        <div class="header-middle">
            <!--header-middle-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="logo pull-left">
                            <a href="index.html"><img src="frontend/images//logo.png" alt="" /></a>
                        </div>
                        <div class="btn-group pull-right">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default dropdown-toggle usa"
                                    data-toggle="dropdown">
                                    USA
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Canada</a></li>
                                    <li><a href="#">UK</a></li>
                                </ul>
                            </div>

                            <div class="btn-group">
                                <button type="button" class="btn btn-default dropdown-toggle usa"
                                    data-toggle="dropdown">
                                    DOLLAR
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Canadian Dollar</a></li>
                                    <li><a href="#">Pound</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="shop-menu pull-right">
                            <ul class="nav navbar-nav">

                                {{-- <li><a href="#"><i class="fa fa-star"></i> Wishlist</a></li>
                                <li><a href="checkout.html"><i class="fa fa-crosshairs"></i> Checkout</a></li> --}}
                                <li>
                                    <!-- Button trigger modal -->
                                    <a data-toggle="modal" data-target="#staticBackdrop">
                                        <i class="fa fa-shopping-cart"></i>
                                    </a>

                                    <!-- Modal -->
                                    <div class="modal fade" id="staticBackdrop" data-backdrop="static"
                                        data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
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
                                                                                {{-- <button style="margin-right: 15px; margin-top:15px" type="button">
                                <i data-id="{{ $item['productInfo']->id }}">&times;</i>
                            </button> --}}
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
                                                        <a href="" class="btn btn-default add-to-cart"><i
                                                                class="fa fa-shopping-cart"></i>Xem gio hang</a>
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
                                    <li><a href="{{ route('frontend.login') }}"><i class="fa fa-lock"></i> Login</a>
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
                        <div class="companyinfo">
                            <h2><span>e</span>-shopper</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,sed do eiusmod tempor
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="col-sm-3">
                            <div class="video-gallery text-center">
                                <a href="#">
                                    <div class="iframe-img">
                                        <img src="frontend/images/iframe1.png" alt="" />
                                    </div>
                                    <div class="overlay-icon">
                                        <i class="fa fa-play-circle-o"></i>
                                    </div>
                                </a>
                                <p>Circle of Hands</p>
                                <h2>24 DEC 2014</h2>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="video-gallery text-center">
                                <a href="#">
                                    <div class="iframe-img">
                                        <img src="frontend/images/iframe2.png" alt="" />
                                    </div>
                                    <div class="overlay-icon">
                                        <i class="fa fa-play-circle-o"></i>
                                    </div>
                                </a>
                                <p>Circle of Hands</p>
                                <h2>24 DEC 2014</h2>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="video-gallery text-center">
                                <a href="#">
                                    <div class="iframe-img">
                                        <img src="frontend/images/iframe3.png" alt="" />
                                    </div>
                                    <div class="overlay-icon">
                                        <i class="fa fa-play-circle-o"></i>
                                    </div>
                                </a>
                                <p>Circle of Hands</p>
                                <h2>24 DEC 2014</h2>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="video-gallery text-center">
                                <a href="#">
                                    <div class="iframe-img">
                                        <img src="frontend/images/iframe4.png" alt="" />
                                    </div>
                                    <div class="overlay-icon">
                                        <i class="fa fa-play-circle-o"></i>
                                    </div>
                                </a>
                                <p>Circle of Hands</p>
                                <h2>24 DEC 2014</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="address">
                            <img src="frontend/images//map.png" alt="" />
                            <p>505 S Atlantic Ave Virginia Beach, VA(Virginia)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-widget">
            <div class="container">
                <div class="row">
                    <x-footer-menu />

                    <div class="col-sm-3 col-sm-offset-1">
                        <div class="single-widget">
                            <h2>About Shopper</h2>
                            <form action="#" class="searchform">
                                <input type="text" placeholder="Your email address" />
                                <button type="submit" class="btn btn-default"><i
                                        class="fa fa-arrow-circle-o-right"></i></button>
                                <p>Get the most recent updates from <br />our site and be updated your self...
                                </p>
                            </form>
                        </div>
                    </div>

                </div>
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
