@extends('layouts.site')
@section('title', $post->title)
@section('content')
    <div class="container">
        <h2 class="text-center text-danger"> {{ $post->title }}</h2>
        <img src="{{ asset('images/post/' . $post->image) }}" />
        <p> {{ $post->detail }}</p>
    </div>
    <div class="recommended_items">

        <h2 class="title text-center">Bài viết cùng chủ đề</h2>
        <div class="col-md-9">

            <ul>
                <li>
                    @foreach ($post_list as $item)
                        <a href="{{ route('slug.home', ['slug' => $item->slug]) }}">
                            <h4>{{ $item->title }}</h4>
                        </a>
                    @endforeach
                </li>
            </ul>
        </div>

    </div>

@endsection
