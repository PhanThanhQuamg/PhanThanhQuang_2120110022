<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Cart;
use App\Models\Order;
use App\Models\Orderdetail;
use Carbon\Carbon;
use Session;

class CartController extends Controller
{
    public function index()
    {

        return view();
    }
    public function AddCart(Request $req, $id)
    {
        $product  = Product::where('id', $id)->first();
        if ($product != null) {
            $oldCart = Session('Cart') ? Session('Cart') : null;
            $newCart = new Cart($oldCart);
            $newCart->AddCart($product, $id);
            $req->session()->put('Cart', $newCart);
        }
        return view('frontend.cart.cart-item');
    }
    public function DeleteListItemCart(Request $req, $id)
    {
        $oldCart = Session('Cart') ? Session('Cart') : null;
        $newCart = new Cart($oldCart);
        $newCart->DeleteItemCart($id);
        if (Count($newCart->products) > 0) {
            $req->session()->put('Cart', $newCart);
        } else {
            $req->session()->forget('Cart');
        }
        return view('frontend.cart.list');
    }
    public function DeleteItemCart(Request $req, $id)
    {
        $oldCart = Session('Cart') ? Session('Cart') : null;
        $newCart = new Cart($oldCart);
        $newCart->DeleteItemCart($id);
        if (Count($newCart->products) > 0) {
            $req->session()->put('Cart', $newCart);
        } else {
            $req->session()->forget('Cart');
        }
        return view('frontend.cart.cart-item');
    }

    public function SaveListItemCart(Request $req, $id, $soluong)
    {
        $oldCart = Session('Cart') ? Session('Cart') : null;
        $newCart = new Cart($oldCart);
        $newCart->UpdateCart($id, $soluong);
        $req->session()->put('Cart', $newCart);
        return view('frontend.cart.list-cart');
    }

    public function ListCart()
    {
        return view('frontend.cart.list-cart');
    }


    public function Checkout(Request $req)
    {
        if (Auth::guard('customer')->check()) {
            return view('frontend.cart.checkout');
        } else {
            return redirect()->route('frontend.login');
        }
        return view('frontend.cart.checkout');
    }
    public function thanhcong(Request $req)
    {
        $cus_id = Auth::guard('customer')->user()->id;
        $auth = Auth::guard('customer')->user();
        $order = new Order;
        $order->cus_id = $cus_id;
        $order->fullname = Auth::guard('customer')->user()->name;
        $order->email = Auth::guard('customer')->user()->email;
        $order->phone = Auth::guard('customer')->user()->phone;
        $order->address = Auth::guard('customer')->user()->address;
        $order->note = Auth::guard('customer')->user()->note;
        //  $order->updated_by = 1;

        $order->created_at = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $order->status = 1;
        if ($order->save()) {
            foreach (Session::get('Cart')->products as $item) {
                $order_detail = new Orderdetail;
                $order_detail->order_id = $order->id;
                $order_detail->product_id = $item['productInfo']->id;
                $order_detail->qty = $item['soluong'];
                $order_detail->price = $item['productInfo']->price_buy;
                $order_detail->amount = (int)$item['productInfo']->price_buy * (int)$item['soluong'];
                //$order_detail->updated_by = 1;
                $order_detail->save();
            }
            // Huy gio hang
            $req->session()->forget('Cart');
            return view('frontend.cart.thanhcong', compact('order'));
        }
    }
}
