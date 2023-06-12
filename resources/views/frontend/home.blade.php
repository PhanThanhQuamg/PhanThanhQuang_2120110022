@extends('layouts.site')
@section('title', 'Trang chủ')
@section('content')
    <section id="slider">
        <div class="col-md-12">
            <div class="container">
                <div class="col-md-1">
                </div>
                <div class="col-md-8">
                    <x-slideshow />
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <x-brand-content />
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row">
                @foreach ($list_category as $row_category)
                    <div class="container">
                        <div class="features_items">
                            <a href="{{ route('slug.home', ['slug' => $row_category->slug]) }}">
                                <h2 class="title text-center">{{ $row_category->name }}</h2>
                            </a>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <x-product-home :rowcat="$row_category" />
                            </div>
                        </div>
                    </div>
                    {{-- <div style="margin-bottom: 15px" class="text-center d-flex justify-content-center">
                        <button class="btn btn-light" style="margin-right: 5px; margin-top:5px">
                            <a href="{{ route('site.allproduct', ['slug' => $row_category->slug]) }}">Xem Thêm</a>
                        </button>
                    </div> --}}
                @endforeach
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-3 featured-items">
                                <img style="width:270px;height:350px;" src="{{ asset('images/sale.jpg') }}" alt="">
                            </div>
                            <div class="col-md-4">
                                @foreach ($post as $item)
                                    <a href="{{ route('slug.home', ['slug' => $item->slug]) }}"> <img
                                            style="max-width:350px;max-height:350px"
                                            src="{{ asset('images/post/' . $item->image) }}" class="card-img-top"></a>
                                    <h3>{{ $item->title }}</h3>
                                @endforeach
                            </div>
                            <div class="col-md-5 featured-items">
                                @foreach ($list_post as $item)
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td> <a href="{{ route('slug.home', ['slug' => $item->slug]) }}"> <img
                                                            style="max-width:150px;max-height:150px"
                                                            src="{{ asset('images/post/' . $item->image) }}"
                                                            class="card-img-top"></a></td>
                                                <td>
                                                    <span>{{ $item->title }}</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
