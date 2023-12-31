<?php

namespace Modules\Cart\app\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class CreateCartRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'amount' => 'required|integer|min:0',
            'product_id' => 'required|integer',
            'product_item_id' => 'nullable|integer',
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
            'amount.*' => 'Số lượng sản phẩm không được bỏ trống .',
            'product_id.*' => 'Sản phẩm không tồn tại.',
            'product_item_id.*' => 'Loại sản phẩm không tồn tại.',
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
