@extends('layouts.site')
@section('title', $page->title)
@section('content')
    <div class="container">
        <h2 class="text-center text-danger"> {{ $page->title }}</h2><br>
        <p>{!! $page->metadesc !!}</p><br>
        <p> {!! $page->detail !!}</p>
    </div>
@endsection
