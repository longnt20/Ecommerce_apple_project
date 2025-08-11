<?php

namespace App\Http\Requests\Admin\Category;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:categories,slug',
            'parent_id'   => 'nullable|integer',
            'description' => 'nullable|string|max:2000',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status'      => 'required|boolean',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Tên danh mục không được để trống!!!',
            'name.string'   => 'Tên danh mục phải là chuỗi kí tự!!!',
            'name.max'      => 'Tên danh mục tối đa 255 kí tự!!!',
            'slug.required' => 'Tên đường dẫn không được để trống!!!',
            'slug.string'   => 'Tên đường dẫn phải là chuỗi kí tự!!!',
            'slug.max'      => 'Tên đường dẫn tối đa 255 kí tự!!!',
            'slug.unique'   => 'Tên đường dẫn đã tồn tại!!!',
            'description.string'=>'Mô tả phải là chuối kí tự!!!',
            'description.max'   =>'Mô tả không được quá 2000 kí tự!!!',
            'image.image'       =>'Không đúng định dạng ảnh!!!',
            'image.mimes'       =>'Không đúng loại ảnh được upload!!!',
            'image.max'         =>'Ảnh không được quá 2048MB!!!'
        ];
    }
}
