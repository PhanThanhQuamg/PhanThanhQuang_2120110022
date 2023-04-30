<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Link;
use App\Models\Post;
use App\Models\Topic;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    public function index()
    {
        $list_post = Post::join('ptq_topic', 'ptq_topic.id', '=', 'ptq_post.topic_id')
            ->select('ptq_post.*', 'ptq_topic.name as tenchude')
            ->where('ptq_post.status', '!=', 0)
            ->orderBy('ptq_post.created_at', 'desc')
            ->get();
        return view('backend.post.index', compact('list_post'));
    }

    public function create()
    {
        $list_topic  = Topic::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        $html_topic_id = '';
        foreach ($list_topic as $item) {
            $html_topic_id .= '<option value="' . $item->id . '">' . $item->name . '</option>';

            //  $html_topic_id = Topic::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        }
        // $html_brand_id = Brand::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        return view('backend.post.create', compact('html_topic_id'));
    }
    public function store(Request $request)
    {
        $post = new Post();
        $post->topic_id = $request->topic_id;
        $post->title = $request->title;
        $post->slug = Str::slug($post->title = $request->title, '-');
        $post->detail = $request->detail;
        $post->type = 'post';
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
            $post->save();
            return redirect()->route('post.index')->with('message', ['type' => 'success', 'msg' => 'Thêm mẫu tin thành công !']);
        }
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
        $html_topic_id = '';
        foreach ($list_post as $item) {
            $html_topic_id = Topic::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        }
        return view('backend.post.edit', compact('post', 'html_topic_id'));
    }

    public function update(Request $request, string $id)
    {
        $post = Post::find($id);
        $post->title = $request->title;
        $post->slug = Str::slug($post->title = $request->title, '-');
        $post->type = 'post';
        $post->metakey = $request->metakey;
        $post->metadesc = $request->metadesc;
        $post->detail = $request->detail;
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
