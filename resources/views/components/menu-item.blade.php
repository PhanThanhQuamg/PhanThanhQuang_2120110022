@if ($sub_menu == true)
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="{{ $menu->link }}" role="button" data-toggle="dropdown">
            {{ $menu->name }}
        </a>
        <div class="dropdown-menu ">
            @foreach ($list_menu_sub as $item)
                <a class="dropdown-item " href="{{ $item->link }}">
                    <p style="margin-left: 25px;">{{ $item->name }}</p>
                </a>
            @endforeach
        </div>
    </li>
@else
    <li class="nav-item">
        <a class="nav-link" href="{{ $menu->link }}">{{ $menu->name }}</a>
    </li>

@endif
