<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Link;
use App\Models\Product;
use App\Models\Post;
use App\Models\Topic;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Customer;

use Illuminate\Support\Facades\Auth;

class SiteController extends Controller
{
    public function index($slug = null)
    {
        if ($slug == null) {
            return $this->home();
        } else {
            $link = Link::where('slug', '=', $slug)->first();
            if ($link == null) {
                $product = Product::join('ptq_brand', 'ptq_brand.id', '=', 'ptq_product.brand_id')
                    ->select('ptq_product.*', 'ptq_brand.name as braname')
                    ->where([['ptq_product.status', '=', 1], ['ptq_product.slug', '=', $slug]])
                    ->first();
                if ($product != null) {
                    return $this->product_detail($product);
                } else {
                    $args = [
                        ['status', '=', '1'],
                        ['slug', '=', $slug],
                        ['type', '=', 'post']
                    ];
                    $post = Post::where($args)->first();
                    if ($post != null) {
                        return $this->post_detail($post);
                    } else {
                        return $this->error_404($slug);
                    }
                }
            } else {
                $type = $link->type;
                switch ($type) {
                    case 'category': {
                            return $this->product_category($slug);
                        }
                    case 'brand': {
                            return $this->product_brand($slug);
                        }
                    case 'topic': {
                            return $this->post_topic($slug);
                        }
                    case 'page': {
                            return $this->post_page($slug);
                        }
                }
            }
        }
    }

    public function home()
    {
        $list_topic = Topic::where('status', '=', '1')->get();
        $list_category = Category::where([['parent_id', '=', 0], ['status', '=', '1']])->get();
        return view('frontend.home', compact('list_category', 'list_topic'));
    }
    private  function product_category($slug)
    {
        $row_cat = Category::where([['slug', '=', $slug], ['status', '=', 1]])->first();
        $list_category_id = array();
        array_push($list_category_id, $row_cat->id);

        // Xét cấp con
        $list_category1 = Category::where([['parent_id', '=', $row_cat->id], ['status', '=', '1']])->get();
        if (count($list_category1) > 0) {
            foreach ($list_category1 as $row_cat1) {
                array_push($list_category_id, $row_cat1->id);
                $list_category2 = Category::where([['parent_id', '=', $row_cat1->id], ['status', '=', '1']])->get();
                if (count($list_category2) > 0) {
                    foreach ($list_category2 as $row_cat2) {
                        array_push($list_category_id, $row_cat2->id);
                        $list_category3 = Category::where([['parent_id', '=', $row_cat2->id], ['status', '=', '1']])->get();
                        if (count($list_category3) > 0) {
                            foreach ($list_category3 as $row_cat3) {
                                array_push($list_category_id, $row_cat3->id);
                            }
                        }
                    }
                }
            }
        }
        $product_list = Product::where('status', 1)
            ->whereIn('category_id', $list_category_id)
            ->orderBy('created_at', 'desc')
            ->paginate(2);
        return view('frontend.product-category', compact('product_list', 'row_cat'));
    }
    private  function product_brand($slug)
    {
        $row_brand = Brand::where([['slug', '=', $slug], ['status', '=', 1]])->first();
        $product_list = Product::where([['status', '=', '1'], ['brand_id', '=', $row_brand->id]])
            ->orderBy('created_at', 'desc')
            ->paginate(1);
        return view('frontend.product-brand', compact('row_brand', 'product_list'));
    }
    private function product_detail($product)
    {

        $list_category_id = array();
        array_push($list_category_id, $product->category_id);

        // Xét cấp con
        $list_category1 = Category::where([['parent_id', '=', $product->category_id], ['status', '=', '1']])->get();
        if (count($list_category1) > 0) {
            foreach ($list_category1 as $row_cat1) {
                array_push($list_category_id, $row_cat1->id);
                $list_category2 = Category::where([['parent_id', '=', $row_cat1->id], ['status', '=', '1']])->get();
                if (count($list_category2) > 0) {
                    foreach ($list_category2 as $row_cat2) {
                        array_push($list_category_id, $row_cat2->id);
                        $list_category3 = Category::where([['parent_id', '=', $row_cat2->id], ['status', '=', '1']])->get();
                        if (count($list_category3) > 0) {
                            foreach ($list_category3 as $row_cat3) {
                                array_push($list_category_id, $row_cat3->id);
                            }
                        }
                    }
                }
            }
        }
        $product_list = Product::where([['status', '=', '1'], ['id', '!=', $product->id]])
            ->whereIn('category_id', $list_category_id)
            ->orderBy('created_at', 'desc')
            ->take(4)->get();
        return view('frontend.product-detail', compact('product', 'product_list'));
    }
    private  function post_topic($slug)
    {
        $row_topic = Topic::where([['slug', '=', $slug], ['status', '=', 1]])->first();
        $args = [
            ['status', '=', '1'],
            ['type', '=', 'post'],
            ['topic_id', '=', $row_topic->id]
        ];
        $post_list = Post::where($args)
            ->orderBy('created_at', 'desc')
            ->paginate(9);
        return view('frontend.post-topic', compact('row_topic', 'post_list'));
    }
    private  function post_page($slug)
    {
        $args = [
            ['status', '=', '1'],
            ['type', '=', 'page'],
            ['slug', '=', $slug]
        ];
        $post = Post::where($args)->first();
        return view('frontend.post-page', compact('post'));
    }

    private function post_detail($post)
    {
        $args = [
            ['status', '=', '1'],
            ['id', '!=', $post->id],
            ['type', '=', 'post'],
            ['topic_id', '=', $post->topic_id]
        ];
        $post_list = Post::where($args)
            ->orderBy('created_at', 'desc')
            ->take(4)->get();
        return view('frontend.post_detail', compact('post', 'post_list'));
    }
    private function error_404($slug)
    {
        return view('frontend.404');
    }
    //tât cả sản phẩm

    public function product()
    {

        $product_list = Product::where('status', '1')
            ->orderBy('created_at', 'desc')
            ->paginate(9);
        return view('fronted.product', compact('product_list'));
    }

    //tât cả thuong hieu

    public function brand()
    {
        $brand_list = Brand::where('status', '1')
            ->orderBy('created_at', 'desc')
            ->paginate(9);
        return view('fronted.brand', compact('brand_list'));
    }

    //tât cả bài viết

    public function post()
    {
        $post_list = Post::where([['status', '=', '1'], ['type', '=', 'post']])
            ->orderBy('created_at', 'desc')
            ->paginate(9);
        return view('fronted.brapostnd', compact('post_list'));
    }

    public function search(Request $req)
    {
        $listsp = Product::where("name", "like", "%" . $req->key . "%")
            ->orWhere('price_buy', $req->key)->get();
        //var_dump($listsp);
        return view('frontend.search', compact('listsp'));
    }
    public function getlogin()
    {

        return view('frontend.login');
    }
    public function postlogin(Request $request)
    {
        $username = $request->username;
        $password = $request->password;
        $data = ['username' => $username, 'password' => $password];
        if (Auth::guard('customer')->attempt($data)) {

            // echo 'Thanh cong';
            // echo bcrypt($password);

            return redirect()->route('site.home')->with('message', ['type' => 'success', 'msg' => 'Đăng nhập tài khoản thành công!']);
        } else {
            return redirect()->route('frontend.login');
            // echo 'That bai';
            // var_dump($data);
            // echo bcrypt($password);
        }
    }
    public function  logoutcustomer()
    {

        Auth::guard('customer')->logout();
        return redirect()->route('frontend.login');
    }
    public function getregister()
    {

        return view('frontend.login');
    }
    public function postregister(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'phone' => 'required',
            'address' => 'required',
            'username' => 'required',
            'email' => 'required|email|unique:ptq_user,email',
            'password' => 'required|min:3|max:32',
        ], [
            'name.required' => 'Bạn chưa nhập tên người dùng',
            'name.min' => 'Tên người dùng ít nhất phải 3 kí tự',
            'email.required' => 'Bạn chưa nhập địa chỉ email',
            'email.email' => 'Bạn chưa nhập địa chỉ email không đúng dạng',
            'email.unique' => 'Địa chỉ email đã tồn tại',
            'password.required' => 'Bạn chưa nhập mật khẩu',
            'password.min' => 'Mật khẩu có ít nhất 3 kí tự',
            'password.max' => 'Mật khẩu tối đa 32 kí tự',
            'phone.required' => 'Bạn chưa nhập số điện thoại',
            'address.required' => 'Bạn chưa nhập địa chỉ',
            'username.required' => 'Bạn chưa nhập tên tài khoản',
        ]);
        $customer = new Customer;
        $customer->name = $request->name;
        $customer->username = $request->username;
        $customer->password = bcrypt($request->password);
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->roles = 2;
        $customer->create_by = 1;
        $customer->created_at = date('Y-m-d H:i:s');
        $customer->status = 1;
        //dd($customer);
        $customer->save();
        return redirect()->route('frontend.login');
    }
}
