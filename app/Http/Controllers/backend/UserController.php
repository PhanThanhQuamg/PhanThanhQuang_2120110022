<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Link;
use Illuminate\Support\Facades\File;


class UserController extends Controller
{
    public function index()
    {
        $list_user  = User::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        return view('backend.user.index', compact('list_user'));
    }

    public function create()
    {
        $list_user  = User::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        $html_sort_order = '';
        foreach ($list_user as $item) {
            $html_sort_order .= '<option value="' . $item->sort_order . '">Sau: ' . $item->name . '</option>';
        }
        return view('backend.user.create', compact('html_sort_order'));
    }

    public function store($request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->slug = Str::slug($user->name = $request->name, '-');
        $user->metakey = $request->metakey;
        $user->metadesc = $request->metadesc;
        $user->sort_order = $request->sort_order;
        $user->status = $request->status;
        $user->created_at = date('Y-m-d H:i:s');
        $user->create_by = 1;
        //Upload file
        if ($request->has('image')) {
            $path_dir = "images/user"; // nơi lưu trữ
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); // lấy phần mở rộng của tập tin 
            $filename = $user->slug . '.' . $extension; // lấy tên slug  + phần mở rộng 
            $file->move($path_dir, $filename);

            $user->image = $filename;
        }
        // End upload
        if ($user->save()) {
            $link = new Link();
            $link->slug = $user->slug;
            $link->tableid = $user->id;
            $link->type = 'user';
            $link->save();
            return redirect()->route('user.index')->with('message', ['type' => 'success', 'msg' => 'Thêm mẫu tin thành công !']);
        } else
            return redirect()->route('user.index')->with('message', ['type' => 'danger', 'msg' => 'Thêm mẫu tin không thành công !']);
    }

    public function show(string $id)
    {
        $user = User::find($id);
        if ($user == null) {
            return redirect()->route('user.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại !']);
        } else {
            return view('backend.user.show', compact('user'));
        }
    }

    public function edit(string $id)
    {
        $user = User::find($id);
        $list_user  = User::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        return view('backend.user.edit', compact('user'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->username = $request->username;
        $user->password = $request->password;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->gender = $request->gender;
        $user->status = $request->status;
        $user->updated_at = date('Y-m-d H:i:s');
        $user->update_by = 1;
        $user->save();
        return redirect()->route('user.index')->with('message', ['type' => 'success', 'msg' => 'Sửa mẫu tin thành công !']);
    }

    public function destroy(string $id)
    // Xóa hẳn
    {
        $user = User::find($id);
        if ($user == null) {
            return redirect()->route('user.trash')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại !']);
        }
        $user->delete();
        return redirect()->route('user.index')->with('message', ['type' => 'success', 'msg' => 'Xóa mẫu tin thành công !']);
    }
    #GET: admin/user/status/
    public function status($id)
    {
        $user = User::find($id);
        if ($user == null) {
            return redirect()->route('user.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại !']);
        } else {
            $user->status = ($user->status == 1) ? 2 : 1;
            $user->updated_at = date('Y-m-d H:i:s');
            $user->update_by = 1;
            $user->save();
            return redirect()->route('user.index')->with('message', ['type' => 'success', 'msg' => 'Thay đổi trạng thái thành công !']);
        }
    }

    #GET: admin/user/delete/
    // xóa vào thùng rác
    public function delete($id)
    {
        $user = User::find($id);
        if ($user == null) {
            return redirect()->route('user.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại !']);
        } else {
            $user->status = 0;
            $user->updated_at = date('Y-m-d H:i:s');
            $user->update_by = 1;
            $user->save();
            return redirect()->route('user.index')->with('message', ['type' => 'success', 'msg' => 'Xóa vào thùng rác thành công !']);
        }
    }
    #GET:admin/user/trash
    public function trash()
    {
        $list_user = User::where('status', '=', 0)->orderBy('created_at', 'desc')->get();
        return view('backend.user.trash', compact('list_user'));
    }
    #GET: admin/user/restore/
    // Khôi phục
    public function restore($id)
    {
        $user = User::find($id);
        if ($user == null) {
            return redirect()->route('user.trash')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại !']);
        } else {
            $user->status = 2;
            $user->updated_at = date('Y-m-d H:i:s');
            $user->update_by = 1;
            $user->save();
            return redirect()->route('user.trash')->with('message', ['type' => 'success', 'msg' => 'Khôi phục thành công !']);
        }
    }
}
