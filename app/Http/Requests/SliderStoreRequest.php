<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'image' => 'required',
            'sort_order' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Bạn chưa nhập tên slider',
                'image.required' => 'Bạn chưa chọn hình ảnh',
            'sort_order.required' => 'Bạn chưa sắp xếp',


        ];
    }
}
