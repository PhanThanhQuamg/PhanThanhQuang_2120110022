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
                <h1>XIN CHÀO! {{ Auth::guard('customer')->user()->name }} </h1>
                <p>Cảm ơn bạn đã đặt hàng tại shop chúng tôi. Chúng tôi sẽ thực hiện đơn hàng và giao đên bạn trong thời
                    gian sớm nhất có thế</p>
            </div>
        </section>


    </body>

    </html>
@endsection
