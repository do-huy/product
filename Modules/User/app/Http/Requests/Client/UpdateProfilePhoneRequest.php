<?php

namespace Modules\User\app\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfilePhoneRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $id = $this->request->get('id');
        return [
            'phone' => ['required', 'string', "unique:users,phone,{$id},id"],
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
            "phone.unique"      =>  "Số điện thoại đã tồn tại.",
            "phone.required"      =>  "Số điện thoại không được bỏ trống.",
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
