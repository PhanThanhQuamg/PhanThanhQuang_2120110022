@extends('layouts.site')
@section('title', 'Trang chủ')
@section('content')
    <section id="slider">
        <div class="container">
            <x-slideshow />
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row">
                <div class="left-sidebar">
                    <div class="col-sm-3">
                        <x-category-list />
                        <x-brand-list />
                        <div class="price-range">
                            <!--price-range-->
                            <h2>Price Range</h2>
                            <div class="well text-center">
                                <input type="text" class="span2" value="" data-slider-min="0" data-slider-max="600"
                                    data-slider-step="5" data-slider-value="[250,450]" id="sl2"><br />
                                <b class="pull-left">$ 0</b> <b class="pull-right">$ 600</b>
                            </div>
                        </div>
                        <div class="shipping text-center">
                            <img src="frontend/images//shipping.jpg" alt="" />
                        </div>
                    </div>
                </div>
                @foreach ($list_category as $row_category)
                    <div class="col-sm-9 padding-right">
                        <div class="features_items">
                            <a href="{{ route('slug.home', ['slug' => $row_category->slug]) }}">
                                <h2 class="title text-center">{{ $row_category->name }}</h2>
                            </a>
                        </div>
                        <x-product-home :rowcat="$row_category" />
                    </div>
                @endforeach
                <div class="col-md-3"></div>
                <div class="col-sm-9">
                    <div class="row">
                        @foreach ($list_topic as $topic)
                            <div class="col-sm-6">
                                <div class="card" style="width: 25rem;">
                                    <h3>{{ $topic->name }}</h3>
                                    <x-post-home :rowpost="$topic" />
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
