<?php

namespace Modules\User\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $id = $this->request->get('id');
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', "unique:users,email,{$id},id"],
            'phone' => ['required', 'string', 'min:10', "unique:users,phone,{$id},id"],
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
            "name.required"  =>  "Tên tài khoản không được bỏ trống.",
            "email.unique"      =>  "Email đã tồn tại.",
            "email.required"      =>  "Email không được bỏ trống.",
            "phone.unique"      =>  "Số điện thoại đã tồn tại.",
            "phone.required"      =>  "Số điện thoại không được bỏ trống.",
            'phone.min' => 'Số điện thoại phải có ít nhất 10 ký tự.',
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
