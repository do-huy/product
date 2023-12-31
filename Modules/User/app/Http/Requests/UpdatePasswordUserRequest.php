<?php

namespace Modules\User\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
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
             'password.required' => 'Mật khẩu không được bỏ trống.',
             'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
             'password.confirmed' => 'Mật khẩu không trùng khớp.',
             'password_confirmation.required' => 'Nhập lại mật khẩu không được bỏ trống.',
         ];
     }
}
