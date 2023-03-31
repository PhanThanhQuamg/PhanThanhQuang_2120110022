<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Link;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;


class PostController extends Controller
{

    public function index()
    {
        // $list_post = Post::all();
        $list_post  = Post::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        return view('backend.post.index', compact('list_post'));
    }

    public function create()
    {
        //$list_post  = Post::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        $html_category_id = Category::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        $html_brand_id = Brand::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        return view('backend.post.create', compact('html_category_id', 'html_brand_id'));
    }
    public function store(Request $request)
    {
        $post = new Post();
        $post->category_id = $request->category_id;
        $post->brand_id = $request->brand_id;
        $post->name = $request->name;
        $post->slug = Str::slug($post->name = $request->name, '-');
        $post->price = $request->price;
        $post->detail = $request->detail;
        $post->metakey = $request->metakey;
        $post->metadesc = $request->metadesc;
        $post->status = $request->status;
        $post->created_at = date('Y-m-d H:i:s');
        $post->create_by = 1;
        //Upload file
        if ($request->has('image')) {
            $path_dir = "images/post"; // nơi lưu trữ
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); // lấy phần mở rộng của tập tin 
            $filename = $post->slug . '.' . $extension; // lấy tên slug  + phần mở rộng 
            $file->move($path_dir, $filename);

            $post->image = $filename;
        }
        // End upload
        if ($post->save()) {
            $link = new Link();
            $link->slug = $post->slug;
            $link->tableid = $post->id;
            $link->type = 'post';
            $link->save();
            return redirect()->route('post.index')->with('message', ['type' => 'success', 'msg' => 'Thêm mẫu tin thành công !']);
        } else
            return redirect()->route('post.index')->with('message', ['type' => 'danger', 'msg' => 'Thêm mẫu tin không thành công !']);
    }

    public function show(string $id)
    {
        $post = Post::find($id);
        if ($post == null) {
            return redirect()->route('post.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại !']);
        } else {
            return view('backend.post.show', compact('post'));
        }
    }

    public function edit(string $id)
    {
        $post = Post::find($id);
        $list_post  = Post::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        $html_sort_order = '';
        foreach ($list_post as $item) {
            $html_sort_order .= '<option value="' . $item->sort_order . '">Sau: ' . $item->name . '</option>';
        }
        return view('backend.post.edit', compact('post', 'html_sort_order'));
    }

    public function update(Request $request, string $id)
    {
        $post = Post::find($id);
        $post->name = $request->name;
        $post->slug = Str::slug($post->name = $request->name, '-');
        $post->metakey = $request->metakey;
        $post->metadesc = $request->metadesc;
        $post->status = $request->status;
        $post->updated_at = date('Y-m-d H:i:s');
        $post->update_by = 1;
        // Upload file
        if ($request->has('image')) {
            $path_dir = "images/post/";
            if (File::exists(($path_dir . $post->image))) {
                File::delete(($path_dir . $post->image));
            }

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); // lấy phần mở rộng của tập tin
            $filename = $post->slug . '.' . $extension; // lấy tên slug  + phần mở rộng 
            $file->move($path_dir, $filename);
            $post->image = $filename;
        }
        //end upload file
        if ($post->save()) {
            $link = Link::where([['type', '=', 'post'], ['tableid', '=', $id]])->first();
            //     $link->slug = $post->slug;
            //  $link->save();
            return redirect()->route('post.index')->with('message', ['type' => 'success', 'msg' => 'Sửa mẫu tin thành công !']);
        } else
            return redirect()->route('post.index')->with('message', ['type' => 'danger', 'msg' => 'Sửa mẫu tin không thành công !']);
    }

    public function destroy(string $id)
    {
        $post = Post::find($id);
        // Lấy ra thông tin tấm hình cần xóa
        $path_dir = "images/post/";
        $path_image_delete = $path_dir . $post->image;
        if ($post == null) {
            return redirect()->route('post.trash')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại !']);
        }
        if ($post->delete()) {
            if (File::exists($path_image_delete)) {
                File::delete($path_image_delete);
            }
        }
        $link = Link::where([['type', '=', 'post'], ['tableid', '=', $id]])->first();
        $link->delete();
        return redirect()->route('post.index')->with('message', ['type' => 'success', 'msg' => 'Xóa mẫu tin thành công !']);
    }
    #GET:admin/post/trash
    public function trash()
    {
        $list_post = Post::where('status', '=', 0)->orderBy('created_at', 'desc')->get();
        return view('backend.post.trash', compact('list_post'));
    }
    #GET: admin/post/status/
    public function status($id)
    {
        $post = Post::find($id);
        if ($post == null) {
            return redirect()->route('post.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại !']);
        } else {
            $post->status = ($post->status == 1) ? 2 : 1;
            $post->updated_at = date('Y-m-d H:i:s');
            $post->update_by = 1;
            $post->save();
            return redirect()->route('post.index')->with('message', ['type' => 'success', 'msg' => 'Thay đổi trạng thái thành công !']);
        }
    }

    #GET: admin/post/delete/
    public function delete($id)
    {
        $post = Post::find($id);
        if ($post == null) {
            return redirect()->route('post.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại !']);
        } else {
            $post->status = 0;
            $post->updated_at = date('Y-m-d H:i:s');
            $post->update_by = 1;
            $post->save();
            return redirect()->route('post.index')->with('message', ['type' => 'success', 'msg' => 'Xóa vào thùng rác thành công !']);
        }
    }
    public function restore($id)
    {
        $post = Post::find($id);
        if ($post == null) {
            return redirect()->route('post.trash')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại !']);
        } else {
            $post->status = 2;
            $post->updated_at = date('Y-m-d H:i:s');
            $post->update_by = 1;
            $post->save();
            return redirect()->route('post.trash')->with('message', ['type' => 'success', 'msg' => 'Khôi phục thành công !']);
        }
    }
}
