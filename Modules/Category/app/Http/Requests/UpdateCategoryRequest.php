<?php

namespace Modules\Category\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $id = $this->request->get('id');
        return [
            'name' => ['required', 'string', "unique:categories,name,{$id},id"],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            "name.required"    =>  "Tên danh mục không được bỏ trống.",
            "name.unique"      =>  "Tên danh mục đã tồn tại.",
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
