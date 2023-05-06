@if ($sub == false)
    <div class="single-widget">
        <h2>{{ $menuitem->name }}</h2>
    </div>
@else
    <div class="single-widget">
        <h2>{{ $menuitem->name }}</h2>
        <ul class="nav nav-pills nav-stacked">
            @foreach ($list_menu_sub as $sub_menu)
                <li><a href="{{ $sub_menu->link }}">{{ $sub_menu->name }}</a></li>
            @endforeach
        </ul>
    </div>
@endif
