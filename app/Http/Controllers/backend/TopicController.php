<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Link;
use Illuminate\Support\Str;
use App\Http\Requests\TopicStoreRequest;
use App\Http\Requests\TopicUpdateRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class TopicController extends Controller
{
    #GET: admin/topic , admin/topic/index
    public function index()
    {
      
        $list_topic  = Topic::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        return view('backend.topic.index', compact('list_topic'));
    }
    #GET: admin/topic/create , admin/topic/index
    public function create()
    {
        //$list_topic = Topic::where('status', '!=', 0)->get();
        $list_topic  = Topic::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        $html_parent_id = '';
        $html_sort_order = '';
        foreach ($list_topic as $item) {
            $html_parent_id .= '<option value="' . $item->id . '">' . $item->name . '</option>';
            $html_sort_order .= '<option value="' . $item->sort_order . '">Sau: ' . $item->name . '</option>';
        }
        return view('backend.topic.create', compact('html_parent_id', 'html_sort_order'));
    }

    // thêm
    public function store(TopicStoreRequest $request)
    {
        $topic = new Topic();
        $topic->name = $request->name;
        $topic->slug = Str::slug($topic->name = $request->name, '-');
        $topic->metakey = $request->metakey;
        $topic->metadesc = $request->metadesc;
        $topic->parent_id = $request->parent_id;
        $topic->sort_order = $request->sort_order;
        $topic->status = $request->status;
        $topic->created_at = date('Y-m-d H:i:s');
        $topic->create_by = 1;
        //Upload file
        if ($request->has('image')) {
            $path_dir = "images/topic"; // nơi lưu trữ
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); // lấy phần mở rộng của tập tin 
            $filename = $topic->slug . '.' . $extension; // lấy tên slug  + phần mở rộng 
            $file->move($path_dir, $filename);

            $topic->image = $filename;
        }
        // End upload
        if ($topic->save()) {
            $link = new Link();
            $link->slug = $topic->slug;
            $link->tableid = $topic->id;
            $link->type = 'topic';
            $link->save();
            return redirect()->route('topic.index')->with('message', ['type' => 'success', 'msg' => 'Thêm mẫu tin thành công !']);
        } else
            return redirect()->route('topic.index')->with('message', ['type' => 'danger', 'msg' => 'Thêm mẫu tin không thành công !']);
    }

    public function show(string $id)
    {
        $topic = Topic::find($id);
        if ($topic == null) {
            return redirect()->route('topic.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại !']);
        } else {
            return view('backend.topic.show', compact('topic'));
        }
    }

    public function edit(string $id)
    {
        $topic = Topic::find($id);
        $list_topic  = Topic::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        $html_parent_id = '';
        $html_sort_order = '';
        foreach ($list_topic as $item) {
            $html_parent_id .= '<option value="' . $item->id . '">' . $item->name . '</option>';
            $html_sort_order .= '<option value="' . $item->sort_order . '">Sau: ' . $item->name . '</option>';
        }
        return view('backend.topic.edit', compact('topic', 'html_parent_id', 'html_sort_order'));
    }

    public function update(TopicUpdateRequest $request, $id)
    {
        $topic = Topic::find($id);
        $topic->name = $request->name;
        $topic->slug = Str::slug($topic->name = $request->name, '-');
        $topic->metakey = $request->metakey;
        $topic->metadesc = $request->metadesc;
        $topic->parent_id = $request->parent_id;
        $topic->sort_order = $request->sort_order;
        $topic->status = $request->status;
        $topic->updated_at = date('Y-m-d H:i:s');
        $topic->update_by = 1;
        // Upload file
        if ($request->has('image')) {
            $path_dir = "images/topic/";
            if (File::exists(($path_dir . $topic->image))) {
                File::delete(($path_dir . $topic->image));
            }

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); // lấy phần mở rộng của tập tin
            $filename = $topic->slug . '.' . $extension; // lấy tên slug  + phần mở rộng 
            $file->move($path_dir, $filename);
            $topic->image = $filename;
        }
        //end upload file
        if ($topic->save()) {
            $link = Link::where([['type', '=', 'topic'], ['tableid', '=', $id]])->first();
            $link->slug = $topic->slug;
            $link->save();
            return redirect()->route('topic.index')->with('message', ['type' => 'success', 'msg' => 'Sửa mẫu tin thành công !']);
        } else
            return redirect()->route('topic.index')->with('message', ['type' => 'danger', 'msg' => 'Sửa mẫu tin không thành công !']);
    }

    #GET: admin/topic/destroy/
    // Xóa hẳn
    public function destroy(string $id)
    {
        $topic = Topic::find($id);
        //thong tin hinh xoa
        $path_dir = "images/topic/";
        $path_image_delete = $path_dir . $topic->image;
        if ($topic == null) {
            return redirect()->route('topic.trash')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }
        if ($topic->delete()) {
            //xoa hinh
            if (File::exists($path_image_delete)) {
                File::delete($path_image_delete);
            }
        }
        $link = Link::where([['type', '=', 'topic'], ['tableid', '=', $id]])->first();
        $link->delete();
        return redirect()->route('topic.index')->with('message', ['type' => 'success', 'msg' => 'Xóa mẫu tin thành công !']);
    }

    #GET: admin/topic/status/
    public function status($id)
    {
        $topic = Topic::find($id);
        if ($topic == null) {
            return redirect()->route('topic.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại !']);
        }
        $topic->status = ($topic->status == 1) ? 2 : 1;
        $topic->updated_at = date('Y-m-d H:i:s');
        $topic->update_by = 1;
        $topic->save();
        return redirect()->route('topic.index')->with('message', ['type' => 'success', 'msg' => 'Thay đổi trạng thái thành công !']);
    }

    #GET: admin/topic/delete/
    // xóa vào thùng rác
    public function delete($id)
    {
        $topic = Topic::find($id);
        if ($topic == null) {
            return redirect()->route('topic.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại !']);
        } else {
            $topic->status = 0;
            $topic->updated_at = date('Y-m-d H:i:s');
            $topic->update_by = 1;
            $topic->save();
            return redirect()->route('topic.index')->with('message', ['type' => 'success', 'msg' => 'Xóa vào thùng rác thành công !']);
        }
    }
    #GET:admin/topic/trash
    public function trash()
    {
        $list_topic = Topic::where('status', '=', 0)->orderBy('created_at', 'desc')->get();
        return view('backend.topic.trash', compact('list_topic'));
    }
    #GET: admin/topic/restore/
    // Khôi phục
    public function restore($id)
    {
        $topic = Topic::find($id);
        if ($topic == null) {
            return redirect()->route('topic.trash')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại !']);
        } else {
            $topic->status = 2;
            $topic->updated_at = date('Y-m-d H:i:s');
            $topic->update_by = 1;
            $topic->save();
            return redirect()->route('topic.trash')->with('message', ['type' => 'success', 'msg' => 'Khôi phục thành công !']);
        }
    }
}
