<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Link;
use App\Models\Product;
use App\Models\Post;
use App\Models\Category;

class SiteController extends Controller
{
    public function index($slug = null)
    {
        if ($slug == null) {
            return $this->home();
        } else {
            $link = Link::where('slug', '=', $slug)->first();
            if ($link == null) {
                $product = Product::where([['status', '=', '1'], ['slug', '=', $slug]])->first();
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
        $list_category = Category::where([['parent_id', '=', 0], ['status', '=', '1']])->get();
        return view('frontend.home', compact('list_category'));
    }
    private  function product_category($slug)
    {
        return view('frontend.product-category');
    }
    private  function product_brand($slug)
    {
        return view('frontend.product-brand');
    }
    private  function post_topic($slug)
    {
        return view('frontend.post-topic');
    }
    private  function post_page($slug)
    {
        return view('frontend.post-page');
    }
    private function product_detail($product)
    {
        return view('fronted.product-detail');
    }
    private function post_detail($product)
    {
        return view('fronted.post-detail');
    }
    private function error_404($slug)
    {
        return view('fronted.404');
    }
}
