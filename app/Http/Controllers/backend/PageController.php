<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Link;
use App\Models\Page;
use App\Models\Topic;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{

    public function index()
    {
        $list_page = Page::join('ptq_topic', 'ptq_topic.id', '=', 'ptq_page.topic_id')
            ->select('ptq_page.*', 'ptq_topic.name as tenchude')
            ->where('ptq_page.status', '!=', 0)
            ->orderBy('ptq_page.created_at', 'desc')
            ->get();
        return view('backend.page.index', compact('list_page'));
    }

    public function create()
    {

        $list_topic  = Topic::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        $html_topic_id = '';
        // $html_brand_id = Brand::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        foreach ($list_topic as $item) {
            $html_topic_id .= '<option value="' . $item->id . '">' . $item->name . '</option>';
        }
        return view('backend.page.create', compact('html_topic_id'));
    }
    public function store(Request $request)
    {
        $page = new Page();
        $page->topic_id = $request->topic_id;
        $page->title = $request->title;
        $page->slug = Str::slug($page->title = $request->title, '-');
        $page->detail = $request->detail;
        $page->type = 'page';
        $page->metakey = $request->metakey;
        $page->metadesc = $request->metadesc;
        $page->status = $request->status;
        $page->created_at = date('Y-m-d H:i:s');
        $page->create_by = 1;
        //Upload file
        if ($request->has('image')) {
            $path_dir = "images/page"; // nơi lưu trữ
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); // lấy phần mở rộng của tập tin 
            $filename = $page->slug . '.' . $extension; // lấy tên slug  + phần mở rộng 
            $file->move($path_dir, $filename);
            $page->image = $filename;
            //var_dump($page);
        }
        // End upload
        if ($page->save()) {
            $link = new Link();
            $link->slug = $page->slug;
            $link->tableid = $page->id;
            $link->type = 'page';
            $link->save();

            return redirect()->route('page.index')->with('message', ['type' => 'success', 'msg' => 'Thêm mẫu tin thành công !']);
        } else
            return redirect()->route('page.index')->with('message', ['type' => 'danger', 'msg' => 'Thêm mẫu tin không thành công !']);
    }

    public function show(string $id)
    {
        $page = Page::find($id);
        if ($page == null) {
            return redirect()->route('page.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại !']);
        } else {
            return view('backend.page.show', compact('page'));
        }
    }

    public function edit(string $id)
    {
        $page = Page::find($id);
        $list_page  = Page::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        $html_topic_id = '';
        foreach ($list_page as $item) {
            $html_topic_id = Topic::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        }
        return view('backend.page.edit', compact('page', 'html_topic_id'));
    }

    public function update(Request $request, string $id)
    {

        $page = Page::find($id);
        $page->title = $request->title;
        $page->slug = Str::slug($page->title = $request->title, '-');
        $page->type = 'page';
        $page->metakey = $request->metakey;
        $page->metadesc = $request->metadesc;
        $page->status = $request->status;
        $page->updated_at = date('Y-m-d H:i:s');
        $page->update_by = 1;
        // Upload file
        if ($request->has('image')) {
            $path_dir = "images/page/";
            if (File::exists(($path_dir . $page->image))) {
                File::delete(($path_dir . $page->image));
            }

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); // lấy phần mở rộng của tập tin
            $filename = $page->slug . '.' . $extension; // lấy tên slug  + phần mở rộng 
            $file->move($path_dir, $filename);
            $page->image = $filename;
        }
        //end upload file
        if ($page->save()) {
            $link = Link::where([['type', '=', 'page'], ['tableid', '=', $id]])->first();
            // $link->slug = $page->slug;
            //$link->save();
            return redirect()->route('page.index')->with('message', ['type' => 'success', 'msg' => 'Sửa mẫu tin thành công !']);
        } else
            return redirect()->route('page.index')->with('message', ['type' => 'danger', 'msg' => 'Sửa mẫu tin không thành công !']);
    }

    public function destroy(string $id)
    {
        $page = Page::find($id);
        // Lấy ra thông tin tấm hình cần xóa
        $path_dir = "images/page/";
        $path_image_delete = $path_dir . $page->image;
        if ($page == null) {
            return redirect()->route('page.trash')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại !']);
        }
        if ($page->delete()) {
            if (File::exists($path_image_delete)) {
                File::delete($path_image_delete);
            }
        }
        $link = Link::where([['type', '=', 'page'], ['tableid', '=', $id]])->first();
        $link->delete();
        return redirect()->route('page.index')->with('message', ['type' => 'success', 'msg' => 'Xóa mẫu tin thành công !']);
    }
    #GET:admin/page/trash
    public function trash()
    {
        $list_page = Page::where('status', '=', 0)->orderBy('created_at', 'desc')->get();
        return view('backend.page.trash', compact('list_page'));
    }
    #GET: admin/page/status/
    public function status($id)
    {
        $page = Page::find($id);
        if ($page == null) {
            return redirect()->route('page.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại !']);
        } else {
            $page->status = ($page->status == 1) ? 2 : 1;
            $page->updated_at = date('Y-m-d H:i:s');
            $page->update_by = 1;
            $page->save();
            return redirect()->route('page.index')->with('message', ['type' => 'success', 'msg' => 'Thay đổi trạng thái thành công !']);
        }
    }

    #GET: admin/page/delete/
    public function delete($id)
    {
        $page = Page::find($id);
        if ($page == null) {
            return redirect()->route('page.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại !']);
        } else {
            $page->status = 0;
            $page->updated_at = date('Y-m-d H:i:s');
            $page->update_by = 1;
            $page->save();
            return redirect()->route('page.index')->with('message', ['type' => 'success', 'msg' => 'Xóa vào thùng rác thành công !']);
        }
    }
    public function restore($id)
    {
        $page = Page::find($id);
        if ($page == null) {
            return redirect()->route('page.trash')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại !']);
        } else {
            $page->status = 2;
            $page->updated_at = date('Y-m-d H:i:s');
            $page->update_by = 1;
            $page->save();
            return redirect()->route('page.trash')->with('message', ['type' => 'success', 'msg' => 'Khôi phục thành công !']);
        }
    }
}
