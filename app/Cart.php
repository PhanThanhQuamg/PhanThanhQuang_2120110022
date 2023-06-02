<?php

namespace App;

class Cart
{
    public $products = null;
    public $tonggia = 0;
    public $tongsoluong = 0;

    public function __construct($cart)
    {
        if ($cart) {
            $this->products = $cart->products;
            $this->tonggia = $cart->tonggia;
            $this->tongsoluong = $cart->tongsoluong;
        }
    }
    public function AddCart($product, $id)
    {
        $newProduct = ['soluong' => 0, 'gia' => $product->price_buy, 'productInfo' => $product, 'image' => $product->productimg];
        if ($this->products) {
            if (array_key_exists($id, $this->products)) {
                $newProduct = $this->products[$id];
            }
        }
        $newProduct['soluong']++;
        $newProduct['gia'] = $newProduct['soluong'] * $product->price_buy;
        $this->products[$id] = $newProduct;
        $this->tonggia += $product->price_buy;
        $this->tongsoluong++;
    }
    public function DeleteItemCart($id)
    {
        $this->tongsoluong -= $this->products[$id]['soluong'];
        $this->tonggia -= $this->products[$id]['gia'];
        unset($this->products[$id]);
    }
    public function UpdateItemCart($id, $soluong)
    {
        $this->tongsoluong -= $this->products[$id]['soluong'];
        $this->tonggia -= $this->products[$id]['gia'];

        $this->products[$id]['soluong'] = $soluong;
        $this->products[$id]['gia'] = $soluong * $this->products[$id]['productsInfo']->gia;

        $this->tongsoluong += $this->products[$id]['soluong'];
        $this->tonggia += $this->products[$id]['gia'];
    }
}
