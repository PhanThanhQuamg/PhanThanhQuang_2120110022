@foreach ($list_post as $item)
    <a href="{{ route('slug.home', ['slug' => $item->slug]) }}"> <img style="max-width:180px;max-height:100px"
            src="{{ asset('images/post/' . $item->image) }}" class="card-img-top">
    </a>
    <div class="card-body">
        <p class="card-text">{{ $item->title }}</p>
    </div>
    <hr>
@endforeach
