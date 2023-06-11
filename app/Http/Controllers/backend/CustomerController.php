<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Support\Str;
use App\Models\Link;
use Illuminate\Support\Facades\File;


class CustomerController extends Controller
{
    public function index()
    {
        $list_customer  = Customer::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        return view('backend.customer.index', compact('list_customer'));
    }

    public function create()
    {
        $list_customer  = Customer::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        $html_sort_order = '';
        foreach ($list_customer as $item) {
            $html_sort_order .= '<option value="' . $item->sort_order . '">Sau: ' . $item->name . '</option>';
        }
        return view('backend.customer.create', compact('html_sort_order'));
    }

    public function store($request)
    {
        $customer = new Customer();
        $customer->name = $request->name;
        $customer->slug = Str::slug($customer->name = $request->name, '-');
        $customer->metakey = $request->metakey;
        $customer->metadesc = $request->metadesc;
        $customer->sort_order = $request->sort_order;
        $customer->status = $request->status;
        $customer->created_at = date('Y-m-d H:i:s');
        $customer->create_by = 1;
        //Upload file
        if ($request->has('image')) {
            $path_dir = "images/customer"; // nơi lưu trữ
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); // lấy phần mở rộng của tập tin 
            $filename = $customer->slug . '.' . $extension; // lấy tên slug  + phần mở rộng 
            $file->move($path_dir, $filename);

            $customer->image = $filename;
        }
        // End upload
        if ($customer->save()) {
            $link = new Link();
            $link->slug = $customer->slug;
            $link->tableid = $customer->id;
            $link->type = 'customer';
            $link->save();
            return redirect()->route('customer.index')->with('message', ['type' => 'success', 'msg' => 'Thêm mẫu tin thành công !']);
        } else
            return redirect()->route('customer.index')->with('message', ['type' => 'danger', 'msg' => 'Thêm mẫu tin không thành công !']);
    }

    public function show(string $id)
    {
        $customer = Customer::find($id);
        if ($customer == null) {
            return redirect()->route('customer.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại !']);
        } else {
            return view('backend.customer.show', compact('customer'));
        }
    }

    public function edit(string $id)
    {
        $customer = Customer::find($id);
        $list_customer  = Customer::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        return view('backend.customer.edit', compact('customer'));
    }

    public function update(Request $request, string $id)
    {
        $customer = Customer::find($id);
        $customer->name = $request->name;
        $customer->username = $request->username;
        $customer->password = $request->password;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->gender = $request->gender;
        $customer->status = $request->status;
        $customer->updated_at = date('Y-m-d H:i:s');
        $customer->update_by = 1;
        $customer->save();
        return redirect()->route('customer.index')->with('message', ['type' => 'success', 'msg' => 'Sửa mẫu tin thành công !']);
    }

    public function destroy(string $id)
    // Xóa hẳn
    {
        $customer = Customer::find($id);
        if ($customer == null) {
            return redirect()->route('customer.trash')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại !']);
        }
        $customer->delete();
        return redirect()->route('customer.index')->with('message', ['type' => 'success', 'msg' => 'Xóa mẫu tin thành công !']);
    }
    #GET: admin/customer/status/
    public function status($id)
    {
        $customer = Customer::find($id);
        if ($customer == null) {
            return redirect()->route('customer.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại !']);
        } else {
            $customer->status = ($customer->status == 1) ? 2 : 1;
            $customer->updated_at = date('Y-m-d H:i:s');
            $customer->update_by = 1;
            $customer->save();
            return redirect()->route('customer.index')->with('message', ['type' => 'success', 'msg' => 'Thay đổi trạng thái thành công !']);
        }
    }

    #GET: admin/customer/delete/
    // xóa vào thùng rác
    public function delete($id)
    {
        $customer = Customer::find($id);
        if ($customer == null) {
            return redirect()->route('customer.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại !']);
        } else {
            $customer->status = 0;
            $customer->updated_at = date('Y-m-d H:i:s');
            $customer->update_by = 1;
            $customer->save();
            return redirect()->route('customer.index')->with('message', ['type' => 'success', 'msg' => 'Xóa vào thùng rác thành công !']);
        }
    }
    #GET:admin/customer/trash
    public function trash()
    {
        $list_customer = Customer::where('status', '=', 0)->orderBy('created_at', 'desc')->get();
        return view('backend.customer.trash', compact('list_customer'));
    }
    #GET: admin/customer/restore/
    // Khôi phục
    public function restore($id)
    {
        $customer = Customer::find($id);
        if ($customer == null) {
            return redirect()->route('customer.trash')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại !']);
        } else {
            $customer->status = 2;
            $customer->updated_at = date('Y-m-d H:i:s');
            $customer->update_by = 1;
            $customer->save();
            return redirect()->route('customer.trash')->with('message', ['type' => 'success', 'msg' => 'Khôi phục thành công !']);
        }
    }
}
