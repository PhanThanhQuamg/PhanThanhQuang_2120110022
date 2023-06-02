<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Cart;
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

    public function SaveListItemCart(Request $req, $id, $quanty)
    {
        $oldCart = Session('Cart') ? Session('Cart') : null;
        $newCart = new Cart($oldCart);
        $newCart->UpdateItemCart($id, $quanty);

        $req->session()->put('Cart', $newCart);
        return view('frontend.cart.list');
    }

    public function ListCart()
    {
        return view('frontend.cart.list-cart');
    }
}
