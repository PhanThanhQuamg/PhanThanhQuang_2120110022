 @if (count($list_category) > 0)
     <ul class="list-group mb-4">
         <li class="list-group-item active">Danh mục sản phẩm</li>
         @foreach ($list_category as $category)
             <li class="list-group-item">
                 <a href="{{ route('slug.home', ['slug' => $category->slug]) }}">{{ $category->name }}</a>
             </li>
         @endforeach
     </ul>
 @endif
