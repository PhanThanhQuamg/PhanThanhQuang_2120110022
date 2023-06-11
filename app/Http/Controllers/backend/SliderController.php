<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\Link;
use Illuminate\Support\Str;
use App\Http\Requests\SliderStoreRequest;
use App\Http\Requests\SliderUpdateRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class SliderController extends Controller
{
    #GET: admin/slider , admin/slider/index
    public function index()
    {;
        $list_slider  = Slider::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        return view('backend.slider.index', compact('list_slider'));
    }
    #GET: admin/slider/create , admin/slider/index
    public function create()
    {
        $list_slider  = Slider::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        $html_sort_order = '';
        foreach ($list_slider as $item) {
            $html_sort_order .= '<option value="' . $item->sort_order . '">Sau: ' . $item->name . '</option>';
        }
        return view('backend.slider.create', compact('html_sort_order'));
    }

    // thêm
    public function store(SliderStoreRequest $request)
    {
        $slider = new Slider();
        $slider->name = $request->name;
        $slider->link = $request->link;
        $slider->sort_order = $request->sort_order;
        $slider->posistion = $request->posistion;
        $slider->status = $request->status;
        $slider->created_at = date('Y-m-d H:i:s');
        $slider->create_by = 1;
        //Upload file
        if ($request->has('image')) {
            $path_dir = "images/slider"; // nơi lưu trữ
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); // lấy phần mở rộng của tập tin 
            $filename = $slider->name . '.' . $extension; // lấy tên slug  + phần mở rộng 
            $file->move($path_dir, $filename);

            $slider->image = $filename;
            $slider->save();
            return redirect()->route('slider.index')->with('message', ['type' => 'success', 'msg' => 'Thêm mẫu tin thành công !']);
        }
        // End upload
    }

    public function show(string $id)
    {
        $slider = Slider::find($id);
        if ($slider == null) {
            return redirect()->route('slider.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại !']);
        } else {
            return view('backend.slider.show', compact('slider'));
        }
    }

    public function edit(string $id)
    {
        $slider = Slider::find($id);
        $list_slider  = Slider::where('status', '!=', 0)->orderBy('created_at', 'desc')->get();
        $html_parent_id = '';
        $html_sort_order = '';
        foreach ($list_slider as $item) {
            $html_parent_id .= '<option value="' . $item->id . '">' . $item->name . '</option>';
            $html_sort_order .= '<option value="' . $item->sort_order . '">Sau: ' . $item->name . '</option>';
        }
        return view('backend.slider.edit', compact('slider', 'html_parent_id', 'html_sort_order'));
    }

    public function update(SliderUpdateRequest $request, $id)
    {
        $slider = Slider::find($id);
        $slider->name = $request->name;
        $slider->slug = Str::slug($slider->name = $request->name, '-');
        $slider->metakey = $request->metakey;
        $slider->metadesc = $request->metadesc;
        $slider->parent_id = $request->parent_id;
        $slider->sort_order = $request->sort_order;
        $slider->status = $request->status;
        $slider->updated_at = date('Y-m-d H:i:s');
        $slider->update_by = 1;
        // Upload file
        if ($request->has('image')) {
            $path_dir = "images/slider/";
            if (File::exists(($path_dir . $slider->image))) {
                File::delete(($path_dir . $slider->image));
            }

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); // lấy phần mở rộng của tập tin
            $filename = $slider->slug . '.' . $extension; // lấy tên slug  + phần mở rộng 
            $file->move($path_dir, $filename);
            $slider->image = $filename;
        }
        //end upload file
        if ($slider->save()) {
            $link = Link::where([['type', '=', 'slider'], ['tableid', '=', $id]])->first();
            $link->slug = $slider->slug;
            $link->save();
            return redirect()->route('slider.index')->with('message', ['type' => 'success', 'msg' => 'Sửa mẫu tin thành công !']);
        } else
            return redirect()->route('slider.index')->with('message', ['type' => 'danger', 'msg' => 'Sửa mẫu tin không thành công !']);
    }

    #GET: admin/slider/destroy/
    // Xóa hẳn
    public function destroy(string $id)
    {
        $slider = Slider::find($id);
        //thong tin hinh xoa
        $path_dir = "images/slider/";
        $path_image_delete = $path_dir . $slider->image;
        if ($slider == null) {
            return redirect()->route('slider.trash')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }
        if ($slider->delete()) {
            //xoa hinh
            if (File::exists($path_image_delete)) {
                File::delete($path_image_delete);
            }
        }
        return redirect()->route('slider.index')->with('message', ['type' => 'success', 'msg' => 'Xóa mẫu tin thành công !']);
    }

    #GET: admin/slider/status/
    public function status($id)
    {
        $slider = Slider::find($id);
        if ($slider == null) {
            return redirect()->route('slider.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại !']);
        }
        $slider->status = ($slider->status == 1) ? 2 : 1;
        $slider->updated_at = date('Y-m-d H:i:s');
        $slider->update_by = 1;
        $slider->save();
        return redirect()->route('slider.index')->with('message', ['type' => 'success', 'msg' => 'Thay đổi trạng thái thành công !']);
    }

    #GET: admin/slider/delete/
    // xóa vào thùng rác
    public function delete($id)
    {
        $slider = Slider::find($id);
        if ($slider == null) {
            return redirect()->route('slider.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại !']);
        } else {
            $slider->status = 0;
            $slider->updated_at = date('Y-m-d H:i:s');
            $slider->update_by = 1;
            $slider->save();
            return redirect()->route('slider.index')->with('message', ['type' => 'success', 'msg' => 'Xóa vào thùng rác thành công !']);
        }
    }
    #GET:admin/slider/trash
    public function trash()
    {
        $list_slider = Slider::where('status', '=', 0)->orderBy('created_at', 'desc')->get();
        return view('backend.slider.trash', compact('list_slider'));
    }
    #GET: admin/slider/restore/
    // Khôi phục
    public function restore($id)
    {
        $slider = Slider::find($id);
        if ($slider == null) {
            return redirect()->route('slider.trash')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại !']);
        } else {
            $slider->status = 2;
            $slider->updated_at = date('Y-m-d H:i:s');
            $slider->update_by = 1;
            $slider->save();
            return redirect()->route('slider.trash')->with('message', ['type' => 'success', 'msg' => 'Khôi phục thành công !']);
        }
    }
}
