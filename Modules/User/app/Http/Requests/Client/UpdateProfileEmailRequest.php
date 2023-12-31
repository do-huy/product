<?php

namespace Modules\User\app\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileEmailRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $id = $this->request->get('id');
        return [
            'email' => ['required', 'string', 'email', "unique:users,email,{$id},id"],
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
            "email.unique"      =>  "Email đã tồn tại.",
            "email.required"      =>  "Email không được bỏ trống.",
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
