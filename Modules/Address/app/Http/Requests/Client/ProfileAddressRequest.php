<?php

namespace Modules\Address\app\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class ProfileAddressRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'phone' => 'required|min:10|max:20',
            'description' => 'required',
            'province_id' => 'required',
            'district_id' => 'required',
            'ward_id' => 'required',
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
            "name.required"             =>  "Tên người nhận không được bỏ trống.",
            "phone.required"            =>  "Số điện thoại không được bỏ trống.",
            "phone.min"                 =>  "Số điện thoại không hợp lệ.",
            "phone.max"                 =>  "Số điện thoại không hợp lệ.",
            "description.required"      =>  "Chi tiết địa chỉ không được bỏ trống.",
            "province_id.required"      =>  "Tỉnh thành không được bỏ trống.",
            "district_id.required"      =>  "Quận huyện không được bỏ trống.",
            "ward_id.required"          =>  "Phường xã không được bỏ trống.",
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
