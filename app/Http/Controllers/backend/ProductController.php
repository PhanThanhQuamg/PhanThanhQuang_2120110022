<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Link;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;


class ProductController extends Controller
{

    public function index()
    {
        // $list_product = Product::all();
        $list_product  = Product::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        return view('backend.product.index', compact('list_product'));
    }

    public function create()
    {
        //$list_product  = Product::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        $html_category_id = Category::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        $html_brand_id = Brand::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        return view('backend.product.create', compact('html_category_id', 'html_brand_id'));
    }
    public function store(Request $request)
    {
        $product = new Product();
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->name = $request->name;
        $product->slug = Str::slug($product->name = $request->name, '-');
        $product->price = $request->price;
        $product->detail = $request->detail;
        $product->metakey = $request->metakey;
        $product->metadesc = $request->metadesc;
        $product->status = $request->status;
        $product->created_at = date('Y-m-d H:i:s');
        $product->create_by = 1;
        //Upload file
        if ($request->has('image')) {
            $path_dir = "images/product"; // nơi lưu trữ
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); // lấy phần mở rộng của tập tin 
            $filename = $product->slug . '.' . $extension; // lấy tên slug  + phần mở rộng 
            $file->move($path_dir, $filename);

            $product->image = $filename;
        }
        // End upload
        if ($product->save()) {
            $link = new Link();
            $link->slug = $product->slug;
            $link->tableid = $product->id;
            $link->type = 'product';
            $link->save();
            return redirect()->route('product.index')->with('message', ['type' => 'success', 'msg' => 'Thêm mẫu tin thành công !']);
        } else
            return redirect()->route('product.index')->with('message', ['type' => 'danger', 'msg' => 'Thêm mẫu tin không thành công !']);
    }

    public function show(string $id)
    {
        $product = Product::find($id);
        if ($product == null) {
            return redirect()->route('product.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại !']);
        } else {
            return view('backend.product.show', compact('product'));
        }
    }

    public function edit(string $id)
    {
        $product = Product::find($id);
        $list_product  = Product::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        $html_sort_order = '';
        foreach ($list_product as $item) {
            $html_sort_order .= '<option value="' . $item->sort_order . '">Sau: ' . $item->name . '</option>';
        }
        return view('backend.product.edit', compact('product', 'html_sort_order'));
    }

    public function update(Request $request, string $id)
    {
        $product = Product::find($id);
        $product->name = $request->name;
        $product->slug = Str::slug($product->name = $request->name, '-');
        $product->metakey = $request->metakey;
        $product->metadesc = $request->metadesc;
        $product->status = $request->status;
        $product->updated_at = date('Y-m-d H:i:s');
        $product->update_by = 1;
        // Upload file
        if ($request->has('image')) {
            $path_dir = "images/product/";
            if (File::exists(($path_dir . $product->image))) {
                File::delete(($path_dir . $product->image));
            }

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); // lấy phần mở rộng của tập tin
            $filename = $product->slug . '.' . $extension; // lấy tên slug  + phần mở rộng 
            $file->move($path_dir, $filename);
            $product->image = $filename;
        }
        //end upload file
        if ($product->save()) {
            $link = Link::where([['type', '=', 'product'], ['tableid', '=', $id]])->first();
            //     $link->slug = $product->slug;
            //  $link->save();
            return redirect()->route('product.index')->with('message', ['type' => 'success', 'msg' => 'Sửa mẫu tin thành công !']);
        } else
            return redirect()->route('product.index')->with('message', ['type' => 'danger', 'msg' => 'Sửa mẫu tin không thành công !']);
    }

    public function destroy(string $id)
    {
        $product = Product::find($id);
        // Lấy ra thông tin tấm hình cần xóa
        $path_dir = "images/product/";
        $path_image_delete = $path_dir . $product->image;
        if ($product == null) {
            return redirect()->route('product.trash')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại !']);
        }
        if ($product->delete()) {
            if (File::exists($path_image_delete)) {
                File::delete($path_image_delete);
            }
        }
        $link = Link::where([['type', '=', 'product'], ['tableid', '=', $id]])->first();
        $link->delete();
        return redirect()->route('product.index')->with('message', ['type' => 'success', 'msg' => 'Xóa mẫu tin thành công !']);
    }
    #GET:admin/product/trash
    public function trash()
    {
        $list_product = Product::where('status', '=', 0)->orderBy('created_at', 'desc')->get();
        return view('backend.product.trash', compact('list_product'));
    }
    #GET: admin/product/status/
    public function status($id)
    {
        $product = product::find($id);
        if ($product == null) {
            return redirect()->route('product.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại !']);
        } else {
            $product->status = ($product->status == 1) ? 2 : 1;
            $product->updated_at = date('Y-m-d H:i:s');
            $product->update_by = 1;
            $product->save();
            return redirect()->route('product.index')->with('message', ['type' => 'success', 'msg' => 'Thay đổi trạng thái thành công !']);
        }
    }

    #GET: admin/product/delete/
    public function delete($id)
    {
        $product = Product::find($id);
        if ($product == null) {
            return redirect()->route('product.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại !']);
        } else {
            $product->status = 0;
            $product->updated_at = date('Y-m-d H:i:s');
            $product->update_by = 1;
            $product->save();
            return redirect()->route('product.index')->with('message', ['type' => 'success', 'msg' => 'Xóa vào thùng rác thành công !']);
        }
    }
    public function restore($id)
    {
        $product = Product::find($id);
        if ($product == null) {
            return redirect()->route('product.trash')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại !']);
        } else {
            $product->status = 2;
            $product->updated_at = date('Y-m-d H:i:s');
            $product->update_by = 1;
            $product->save();
            return redirect()->route('product.trash')->with('message', ['type' => 'success', 'msg' => 'Khôi phục thành công !']);
        }
    }
}
