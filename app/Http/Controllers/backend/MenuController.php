<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Topic;
use App\Models\Page;
use App\Models\Post;
use App\Models\Link;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    #GET: admin/menu , admin/menu/index
    public function index()
    {

        $list_category  = Category::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        $list_brand  = Brand::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        $list_topic  = Topic::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        $list_page  = Page::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        $list_post  = Post::where([['status', '!=', 0], ['type', '=', 'page']])->orderBy('created_at', 'desc')->get();
        $list_menu  = Menu::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        return view('backend.menu.index', compact('list_category', 'list_brand', 'list_topic', 'list_post', 'list_menu', 'list_page'));
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
    public function store(Request $request)
    {
        if (isset($request->ADDCATEGORY)) {
            $list_id = $request->checkIdCategory;
            foreach ($list_id as $id) {
                $category = Category::find($id);
                $menu = new Menu();
                $menu->name = $category->name;
                $menu->link = $category->slug;
                $menu->table_id = $id;
                $menu->parent_id = 0;
                $menu->sort_order = 1;
                $menu->type = 'category';
                $menu->position = $request->position;
                $menu->status = 2;
                $menu->created_at = date('Y-m-d H:i:s');
                $menu->created_by = 1;
                $menu->save();
            }
            return redirect()->route('menu.index')->with('message', ['type' => 'success', 'msg' => 'Thêm mẫu tin thành công !']);
        }
        if (isset($request->ADDBRAND)) {
            $list_id = $request->checkIdBrand;
            foreach ($list_id as $id) {
                $brand = Brand::find($id);
                $menu = new Menu();
                $menu->name = $brand->name;
                $menu->link = $brand->slug;
                $menu->table_id = $id;
                $menu->parent_id = 0;
                $menu->sort_order = 1;
                $menu->type = 'brand';
                $menu->position = $request->position;
                $menu->status = 2;
                $menu->created_at = date('Y-m-d H:i:s');
                $menu->created_by = 1;
                $menu->save();
            }
            return redirect()->route('menu.index')->with('message', ['type' => 'success', 'msg' => 'Thêm mẫu tin thành công !']);
        }
        if (isset($request->ADDTOPIC)) {
            $list_id = $request->checkIdTopic;
            foreach ($list_id as $id) {
                $topic = Topic::find($id);
                $menu = new Menu();
                $menu->name = $topic->name;
                $menu->link = $topic->slug;
                $menu->table_id = $id;
                $menu->parent_id = 0;
                $menu->sort_order = 1;
                $menu->type = 'topic';
                $menu->position = $request->position;
                $menu->status = 2;
                $menu->created_at = date('Y-m-d H:i:s');
                $menu->created_by = 1;
                $menu->save();
            }
            return redirect()->route('menu.index')->with('message', ['type' => 'success', 'msg' => 'Thêm mẫu tin thành công !']);
        }
        if (isset($request->ADDPAGE)) {
            $list_id = $request->checkIdPage;
            foreach ($list_id as $id) {
                $page = Post::find($id);
                $menu = new Menu();
                $menu->name = $page->name;
                $menu->link = $page->slug;
                $menu->table_id = $id;
                $menu->parent_id = 0;
                $menu->sort_order = 1;
                $menu->type = 'page';
                $menu->position = $request->position;
                $menu->status = 2;
                $menu->created_at = date('Y-m-d H:i:s');
                $menu->created_by = 1;
                $menu->save();
            }
            return redirect()->route('menu.index')->with('message', ['type' => 'success', 'msg' => 'Thêm mẫu tin thành công !']);
        }
        if (isset($request->ADDCUSTOM)) {
            $menu = new Menu();
            $menu->name = $request->name;
            $menu->link = $request->link;
            $menu->type = 'custom';
            $menu->parent_id = 0;
            $menu->sort_order = 1;
            $menu->position = $request->position;
            $menu->status = 2;
            $menu->created_at = date('Y-m-d H:i:s');
            $menu->created_by = 1;
            $menu->save();
            return redirect()->route('menu.index')->with('message', ['type' => 'success', 'msg' => 'Thêm mẫu tin thành công !']);
        }
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
            if ($menu->parentd_id == $item->id) {
                $html_parent_id .= '<option selected value="' . $item->id . '">' . $item->name . '</option>';
            } else {
                $html_parent_id .= '<option value="' . $item->id . '">' . $item->name . '</option>';
            }
            if ($menu->sort_order == $item->sort_order) {
                $html_sort_order .= '<option selected value="' . $item->sort_order . '">Sau: ' . $item->name . '</option>';
            } else {
                $html_sort_order .= '<option value="' . $item->sort_order . '">Sau: ' . $item->name . '</option>';
            }
        }
        return view('backend.menu.edit', compact('menu', 'html_parent_id', 'html_sort_order'));
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::find($id);
        $menu->name = $request->name;
        $menu->link = $request->link;
        $menu->parent_id = $request->parent_id;
        $menu->sort_order = $request->sort_order + 1;
        $menu->position = $request->position;
        $menu->status = $request->status;
        $menu->updated_at = date('Y-m-d H:i:s');
        $menu->updated_by = 1;
        $menu->save();
        return redirect()->route('menu.index')->with('message', ['type' => 'success', 'msg' => 'Thêm mẫu tin thành công !']);
    }

    #GET: admin/menu/destroy/
    // Xóa hẳn
    public function destroy(string $id)
    {
        $menu = Menu::find($id);
        if ($menu == null) {
            return redirect()->route('menu.trash')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }
        $menu->delete();
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
        $menu->updated_by = 1;
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
            $menu->updated_by = 1;
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
            $menu->updated_by = 1;
            $menu->save();
            return redirect()->route('menu.trash')->with('message', ['type' => 'success', 'msg' => 'Khôi phục thành công !']);
        }
    }
}
