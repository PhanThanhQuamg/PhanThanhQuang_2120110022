<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Link;
use Illuminate\Support\Str;
use App\Http\Requests\MenuStoreRequest;
use App\Http\Requests\MenuUpdateRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class MenuController extends Controller
{
    #GET: admin/menu , admin/menu/index
    public function index()
    {
        $list_menu  = Menu::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        return view('backend.menu.index', compact('list_menu'));
    }
    #GET: admin/menu/create , admin/menu/index
    public function create()
    {
        //$list_menu = Menu::where('status', '!=', 0)->get();
        $list_menu  = Menu::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        $html_parent_id = '';
        $html_sort_order = '';
        foreach ($list_menu as $item) {
            $html_parent_id .= '<option value="' . $item->id . '">' . $item->name . '</option>';
            $html_sort_order .= '<option value="' . $item->sort_order . '">Sau: ' . $item->name . '</option>';
        }
        return view('backend.menu.create', compact('html_parent_id', 'html_sort_order'));
    }

    // thêm
    public function store(menuStoreRequest $request)
    {
        $menu = new menu();
        $menu->name = $request->name;
        $menu->slug = Str::slug($menu->name = $request->name, '-');
        $menu->metakey = $request->metakey;
        $menu->metadesc = $request->metadesc;
        $menu->parent_id = $request->parent_id;
        $menu->sort_order = $request->sort_order;
        $menu->status = $request->status;
        $menu->created_at = date('Y-m-d H:i:s');
        $menu->create_by = 1;
        //Upload file
        if ($request->has('image')) {
            $path_dir = "images/menu"; // nơi lưu trữ
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); // lấy phần mở rộng của tập tin 
            $filename = $menu->slug . '.' . $extension; // lấy tên slug  + phần mở rộng 
            $file->move($path_dir, $filename);

            $menu->image = $filename;
        }
        // End upload
        if ($menu->save()) {
            $link = new Link();
            $link->slug = $menu->slug;
            $link->tableid = $menu->id;
            $link->type = 'menu';
            $link->save();
            return redirect()->route('menu.index')->with('message', ['type' => 'success', 'msg' => 'Thêm mẫu tin thành công !']);
        } else
            return redirect()->route('menu.index')->with('message', ['type' => 'danger', 'msg' => 'Thêm mẫu tin không thành công !']);
    }

    public function show(string $id)
    {
        $menu = Menu::find($id);
        if ($menu == null) {
            return redirect()->route('menu.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại !']);
        } else {
            return view('backend.menu.show', compact('menu'));
        }
    }

    public function edit(string $id)
    {
        $menu = Menu::find($id);
        $list_menu  = Menu::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        $html_parent_id = '';
        $html_sort_order = '';
        foreach ($list_menu as $item) {
            $html_parent_id .= '<option value="' . $item->id . '">' . $item->name . '</option>';
            $html_sort_order .= '<option value="' . $item->sort_order . '">Sau: ' . $item->name . '</option>';
        }
        return view('backend.menu.edit', compact('menu', 'html_parent_id', 'html_sort_order'));
    }

    public function update(menuUpdateRequest $request, $id)
    {
        $menu = Menu::find($id);
        $menu->name = $request->name;
        $menu->slug = Str::slug($menu->name = $request->name, '-');
        $menu->metakey = $request->metakey;
        $menu->metadesc = $request->metadesc;
        $menu->parent_id = $request->parent_id;
        $menu->sort_order = $request->sort_order;
        $menu->status = $request->status;
        $menu->updated_at = date('Y-m-d H:i:s');
        $menu->update_by = 1;
        // Upload file
        if ($request->has('image')) {
            $path_dir = "images/menu/";
            if (File::exists(($path_dir . $menu->image))) {
                File::delete(($path_dir . $menu->image));
            }

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); // lấy phần mở rộng của tập tin
            $filename = $menu->slug . '.' . $extension; // lấy tên slug  + phần mở rộng 
            $file->move($path_dir, $filename);
            $menu->image = $filename;
        }
        //end upload file
        if ($menu->save()) {
            $link = Link::where([['type', '=', 'menu'], ['tableid', '=', $id]])->first();
            $link->slug = $menu->slug;
            $link->save();
            return redirect()->route('menu.index')->with('message', ['type' => 'success', 'msg' => 'Sửa mẫu tin thành công !']);
        } else
            return redirect()->route('menu.index')->with('message', ['type' => 'danger', 'msg' => 'Sửa mẫu tin không thành công !']);
    }

    #GET: admin/menu/destroy/
    // Xóa hẳn
    public function destroy(string $id)
    {
        $menu = Menu::find($id);
        //thong tin hinh xoa
        $path_dir = "images/menu/";
        $path_image_delete = $path_dir . $menu->image;
        if ($menu == null) {
            return redirect()->route('menu.trash')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }
        if ($menu->delete()) {
            //xoa hinh
            if (File::exists($path_image_delete)) {
                File::delete($path_image_delete);
            }
        }
        $link = Link::where([['type', '=', 'menu'], ['tableid', '=', $id]])->first();
        $link->delete();
        return redirect()->route('menu.index')->with('message', ['type' => 'success', 'msg' => 'Xóa mẫu tin thành công !']);
    }

    #GET: admin/menu/status/
    public function status($id)
    {
        $menu = Menu::find($id);
        if ($menu == null) {
            return redirect()->route('menu.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại !']);
        }
        $menu->status = ($menu->status == 1) ? 2 : 1;
        $menu->updated_at = date('Y-m-d H:i:s');
        $menu->update_by = 1;
        $menu->save();
        return redirect()->route('menu.index')->with('message', ['type' => 'success', 'msg' => 'Thay đổi trạng thái thành công !']);
    }

    #GET: admin/menu/delete/
    // xóa vào thùng rác
    public function delete($id)
    {
        $menu = Menu::find($id);
        if ($menu == null) {
            return redirect()->route('menu.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại !']);
        } else {
            $menu->status = 0;
            $menu->updated_at = date('Y-m-d H:i:s');
            $menu->update_by = 1;
            $menu->save();
            return redirect()->route('menu.index')->with('message', ['type' => 'success', 'msg' => 'Xóa vào thùng rác thành công !']);
        }
    }
    #GET:admin/menu/trash
    public function trash()
    {
        $list_menu = Menu::where('status', '=', 0)->orderBy('created_at', 'desc')->get();
        return view('backend.menu.trash', compact('list_menu'));
    }
    #GET: admin/menu/restore/
    // Khôi phục
    public function restore($id)
    {
        $menu = Menu::find($id);
        if ($menu == null) {
            return redirect()->route('menu.trash')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại !']);
        } else {
            $menu->status = 2;
            $menu->updated_at = date('Y-m-d H:i:s');
            $menu->update_by = 1;
            $menu->save();
            return redirect()->route('menu.trash')->with('message', ['type' => 'success', 'msg' => 'Khôi phục thành công !']);
        }
    }
}
