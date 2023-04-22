<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'metakey' => 'required',
            'metadesc' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Bạn chưa nhập tên',
            'metakey.required' => 'Bạn chưa nhập từ khóa tìm kiếm',
            'metadesc.required' => 'Bạn chưa nhập mô tả'
        ];
    }
}
