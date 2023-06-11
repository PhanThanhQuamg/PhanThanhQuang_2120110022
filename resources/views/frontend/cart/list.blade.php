 <div class="table-responsive cart_info">
     <table class="table table-condensed">
         <thead>
             <tr class="cart_menu">
                 <td class="image text-center">Hình ảnh</td>
                 <td class="description text-center">Tên</td>
                 <td class="price text-center">Giá</td>
                 <td class="quantity text-center">Số lượng</td>
                 <td class="total text-center">Tổng</td>
                 {{-- <td class="total">Lưu</td> --}}
                 <td class="total"></td>
             </tr>
         </thead>
         <tbody>
             @if (Session::has('Cart') != null)
                 @foreach (Session::get('Cart')->products as $item)
                     @php
                         $product_image = $item['image'];
                         $hinh = null;
                         if (count($product_image) > 0) {
                             $hinh = $product_image[0]['image'];
                         }
                         
                     @endphp
                     <tr>
                         <td class="cart_product">
                             <img style="width:80px" src="{{ asset('images/product/' . $hinh) }}"
                                 alt="{{ $hinh }}">
                         </td>
                         <td class="cart_description">
                             <p>{{ $item['productInfo']->name }}</p>
                         </td>
                         <td class="cart_price">
                             <p>{{ number_format($item['productInfo']->price_buy) }}</p>
                         </td>
                         <td class="cart_quantity">
                             <div class="cart_quantity_button">
                                 <input id="quanty-item-{{ $item['productInfo']->id }}" class="cart_quantity_input"
                                     type="text" value="{{ $item['soluong'] }}" autocomplete="off" size="2">
                             </div>
                         </td>
                         <td class="cart_total">
                             <p class="cart_total_price">
                                 {{ number_format($item['gia']) }} VNĐ
                             </p>
                         </td>
                         <td class="cart_delete">
                             <a class="cart_quantity_delete"
                                 onclick="DeleteListItemCart({{ $item['productInfo']->id }});"><i
                                     class="fa fa-times"></i></a>
                             <a onclick="SaveListItemCart({{ $item['productInfo']->id }})";><i
                                     class="fa fa-save"></i></a>
                         </td>
                     </tr>
                 @endforeach
             @endif
         </tbody>
     </table>
 </div>
 {{-- tính tổng --}}
 <div class="row">
     <div class="col-lg-4 offset-lg-8 float-end">
         <div class="proceed-checkout">
             <table class="table table-bordered table-striped">
                 <tr>
                     <td class="text-center">Tổng số lượng</td>
                     <td class="text-center">Tông tiền</td>
                 </tr>
                 <tr>
                     <td class="text-center">
                         @if (Session::has('Cart') != null)
                             {{ number_format(Session::get('Cart')->tonggia, 0) }} VNĐ
                         @else
                             0
                         @endif
                     </td>
                     <td class="text-center">
                         @if (Session::has('Cart') != null)
                             {{ Session::get('Cart')->tongsoluong }}
                         @else
                             0
                         @endif
                     </td>
                 </tr>
             </table>
         </div>
     </div>
 </div>
 {{-- end  tính tổng --}}
