<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'detail' => 'required',
            'metakey' => 'required',
            'metadesc' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required',
            'price_buy' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Bạn chưa nhập tên',
            'detail.required' => 'Bạn chưa nhập chi tiết sản phẩm',
            'metakey.required' => 'Bạn chưa nhập từ khóa tìm kiếm',
            'metadesc.required' => 'Bạn chưa nhập mô tả',
            'category_id.required' => 'Bạn chưa chọn danh mục',
            'brand_id.required' => 'Bạn chưa chọn thương hiệu',
            'price_buy.required' => 'Bạn chưa nhập giá bán',
        ];
    }
}
