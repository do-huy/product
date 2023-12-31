<?php

namespace Modules\User\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string' , 'min:10' ,'max:255', 'unique:users'],
            'password' => ['required','min:8', 'confirmed'],
            'password_confirmation' => ['required'],
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
            'name.required' => 'Tên tài khoản không được bỏ trống.',
            'email.required' => 'Email không được bỏ trống.',
            'email.unique' => 'Email đã tồn tại.',
            'phone.required' => 'Số điện thoại không được bỏ trống.',
            'phone.unique' => 'Số điện thoại đã tồn tại.',
            'phone.min' => 'Số điện thoại phải có ít nhất 10 ký tự.',
            'password.required' => 'Mật khẩu không được bỏ trống.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.confirmed' => 'Mật khẩu không trùng khớp.',
            'password_confirmation.required' => 'Nhập lại mật khẩu không được bỏ trống.',
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
