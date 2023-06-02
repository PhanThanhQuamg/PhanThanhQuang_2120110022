@if (Session::has('Cart') != null)
    <div class="modal-body">
        <table class="table table-bordered">
            <tbody>
                @foreach (Session::get('Cart')->products as $item)
                    @php
                        $product_image = $item['image'];
                        $hinh = null;
                        if (count($product_image) > 0) {
                            $hinh = $product_image[0]['image'];
                        }
                        
                    @endphp

                    <tr class="align-middle">
                        <td style="width:100px" class="align-middle">
                            <img style="width:80px" src="{{ asset('images/product/' . $hinh) }}" alt="{{ $hinh }}">
                        </td>
                        <td style="width:400px">
                            <p>{{ $item['productInfo']->name }}</p>
                            {{ number_format($item['productInfo']->price_buy) }} x {{ $item['soluong'] }}
                        </td>

                        <td class="si-close ">
                            <i class="fa fa-times" style="margin-right: 15px; margin-top:15px"
                                data-id="{{ $item['productInfo']->id }}"></i>
                            {{-- <button style="margin-right: 15px; margin-top:15px" type="button">
                                <i data-id="{{ $item['productInfo']->id }}">&times;</i>
                            </button> --}}
                        </td>
                    </tr>
                @endforeach

            </tbody>
            <tfoot>
                <tr>
                    <th>
                        <h6>Tổng</h6>
                    </th>
                    <th>
                        {{ number_format(Session::get('Cart')->tonggia, 0) }} đ
                    </th>
                </tr>
            </tfoot>
        </table>
    </div>
@endif
