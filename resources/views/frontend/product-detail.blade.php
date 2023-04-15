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
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="left-sidebar">
                        <h2>Category</h2>
                        <div class="panel-group category-products" id="accordian">
                            <!--category-productsr-->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordian" href="#sportswear">
                                            <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                                            Sportswear
                                        </a>
                                    </h4>
                                </div>
                                <div id="sportswear" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <ul>
                                            <li><a href="">Nike </a></li>
                                            <li><a href="">Under Armour </a></li>
                                            <li><a href="">Adidas </a></li>
                                            <li><a href="">Puma</a></li>
                                            <li><a href="">ASICS </a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordian" href="#mens">
                                            <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                                            Mens
                                        </a>
                                    </h4>
                                </div>
                                <div id="mens" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <ul>
                                            <li><a href="">Fendi</a></li>
                                            <li><a href="">Guess</a></li>
                                            <li><a href="">Valentino</a></li>
                                            <li><a href="">Dior</a></li>
                                            <li><a href="">Versace</a></li>
                                            <li><a href="">Armani</a></li>
                                            <li><a href="">Prada</a></li>
                                            <li><a href="">Dolce and Gabbana</a></li>
                                            <li><a href="">Chanel</a></li>
                                            <li><a href="">Gucci</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordian" href="#womens">
                                            <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                                            Womens
                                        </a>
                                    </h4>
                                </div>
                                <div id="womens" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <ul>
                                            <li><a href="">Fendi</a></li>
                                            <li><a href="">Guess</a></li>
                                            <li><a href="">Valentino</a></li>
                                            <li><a href="">Dior</a></li>
                                            <li><a href="">Versace</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a href="#">Kids</a></h4>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a href="#">Fashion</a></h4>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a href="#">Households</a></h4>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a href="#">Interiors</a></h4>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a href="#">Clothing</a></h4>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a href="#">Bags</a></h4>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a href="#">Shoes</a></h4>
                                </div>
                            </div>
                        </div>
                        <!--/category-products-->

                        <div class="brands_products">
                            <!--brands_products-->
                            <h2>Brands</h2>
                            <div class="brands-name">
                                <ul class="nav nav-pills nav-stacked">
                                    <li><a href=""> <span class="pull-right">(50)</span>Acne</a></li>
                                    <li><a href=""> <span class="pull-right">(56)</span>Grüne Erde</a></li>
                                    <li><a href=""> <span class="pull-right">(27)</span>Albiro</a></li>
                                    <li><a href=""> <span class="pull-right">(32)</span>Ronhill</a></li>
                                    <li><a href=""> <span class="pull-right">(5)</span>Oddmolly</a></li>
                                    <li><a href=""> <span class="pull-right">(9)</span>Boudestijn</a></li>
                                    <li><a href=""> <span class="pull-right">(4)</span>Rösch creative culture</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!--/brands_products-->

                        <div class="price-range">
                            <!--price-range-->
                            <h2>Price Range</h2>
                            <div class="well">
                                <div class="slider slider-horizontal" style="width: 182px;">
                                    <div class="slider-track">
                                        <div class="slider-selection" style="left: 41.6667%; width: 33.3333%;"></div>
                                        <div class="slider-handle round left-round" style="left: 41.6667%;"></div>
                                        <div class="slider-handle round" style="left: 75%;"></div>
                                    </div>
                                    <div class="tooltip top" style="top: -30px; left: 73.1667px;">
                                        <div class="tooltip-arrow"></div>
                                        <div class="tooltip-inner">250 : 450</div>
                                    </div><input type="text" class="span2" value="" data-slider-min="0"
                                        data-slider-max="600" data-slider-step="5" data-slider-value="[250,450]"
                                        id="sl2" style="">
                                </div><br>
                                <b>$ 0</b> <b class="pull-right">$ 600</b>
                            </div>
                        </div>
                        <!--/price-range-->

                        <div class="shipping text-center">
                            <!--shipping-->
                            <img src="images/product/shipping.jpg" alt="">
                        </div>
                        <!--/shipping-->

                    </div>
                </div>

                <div class="col-sm-9 padding-right">
                    <div class="product-details">
                        <!--product-details-->
                        <div class="col-sm-5">
                            <div class="view-product">
                                <img src={{ asset('images/product/' . $hinh) }} alt="{{ $hinh }}">
                            </div>
                            <div id="similar-product" class="carousel slide" data-ride="carousel">
                                <!-- Wrapper for slides -->
                                {{-- <div class="carousel-inner">
                                    @for ($i = 1; $i < count($product_image) - 1; $i++)
                                        <img src={{ asset('images/product/' . $hinh) }} alt="{{ $hinh }}">
                                    @endfor
                                </div> --}}
                            </div>

                        </div>
                        <div class="col-sm-7">
                            <div class="product-information">
                                <!--/product-information-->
                                <img src="images/product-details/new.jpg" class="newarrival" alt="">
                                <h2>{{ $product->name }}</h2>
                                {{-- <img src="images/product-details/rating.png" alt=""> --}}
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
                                <p><b>Thương hiệu:</b> {{ $product->braname }}</p>

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
                            <h2 class="title text-center">sản phẩm cùng loại</h2>
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
                                                    <img src="{{ asset('images/product/' . $hinh) }}"
                                                        alt="{{ $hinh }}" />
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
            </div>
        </div>
    </section>
@endsection
