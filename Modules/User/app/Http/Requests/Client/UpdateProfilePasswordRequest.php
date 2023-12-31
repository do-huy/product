<?php

namespace Modules\User\app\Http\Requests\Client;

use App\Rules\MatchOldPassword;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfilePasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'password' => ['required','min:8', new MatchOldPassword],
            'new_password' => ['required','min:8'],
            'new_confirm_password' => ['required','same:new_password'],
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
            "password.required"=>"Vui lòng nhập mật khẩu cũ.",
            "password.min"=>"Mật khẩu phải có ít nhất 8 ký tự.",
            "new_password.required"=>"Vui lòng nhập mật khẩu mới.",
            "new_password.min"=>"Mật khẩu phải có ít nhất 8 ký tự.",
            "new_confirm_password.required"=>"Vui lòng xác nhận lại mật khẩu.",
            "new_confirm_password.same"=>"Mật khẩu chưa trùng khớp.",
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
