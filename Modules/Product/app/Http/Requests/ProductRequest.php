<?php

namespace Modules\Product\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric'],
            'comparative_price' => ['nullable', 'numeric'],
            'content' => ['required', 'string', 'max:1000000'],
            'quantity' => 'required|integer|max:1000000',
            'category_id' => ['required'],
            'variants' => 'nullable|array',
            'variants.*.name' => 'required|string|distinct|max:255',
            'variants.*.options' => 'required_with:variants|array|min:1',
            'variants.*.options.*' => 'string|required|max:255',
            'product_items' => 'nullable|required_with:variants|array',
            'product_items.*.options' => 'required|array',
            'product_items.*.options.*' => 'required|string|max:255',
            'product_items.*.price' => 'required|numeric',
            'product_items.*.comparative_price' => 'nullable|numeric',
            'product_items.*.quantity' => 'required|integer|max:1000000',
            'product_items.*.sku' => 'nullable|string|max:255',
            'variant_files' => 'nullable|array',
            'variant_files.*' => 'image|max:4096',
        ];

        foreach (($this->variants ?? []) as $key => $variant) {
            $rules["variants.{$key}.options.*"] = 'distinct';
        }

        // add rules when update
        if ($this->method() == 'PUT') {
            $rules = array_merge($rules, [
                'variants.*.id' => 'nullable|exists:variants,id',
                'variants.*.option_ids' => 'nullable|array',
                'variants.*.option_ids.*' => 'nullable|integer|exists:variant_options,id',
                'product_items.*.id' => 'nullable|exists:product_items,id',
                'variant_old_files' => 'nullable|array',
                'variant_old_files.*' => 'nullable|string',
            ]);
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */

     public function messages()
     {
         return [
             'name.required' => 'Tên sản phẩm không được bỏ trống.',
             'price.required' => 'Giá sản phẩm không được bỏ trống.',
             'comparative_price.*' => 'Giá tham chiếu phải số.',
             'quantity.*' => 'Số lượng sản phẩm không hợp lý',
             'content.required' => 'Mô tả sản phẩm không được bỏ trống.',
             'category_id.required' => 'Danh mục chính không được bỏ trống.',
             'variants.*.name.required' => 'Nhóm phân loại không được bỏ trống.',
             'variants.*.name.required' => 'Nhóm phân loại không được bỏ trống.',
             'variants.*.name.distinct' => 'Nhóm phân loại bị trùng với nhóm khác.',
             'variants.*.options.required_with' => 'Phải có ít nhất 1 phân loại hàng.',
             'variants.*.options.min' => 'Phải có ít nhất 1 phân loại hàng',
             'variants.*.options.*.required' => 'Phân loại hàng không được bỏ trống.',
             'variants.*.options.*.distinct' => 'Các phân loại hàng phải khác nhau.',
             'product_items.*.price.*' => 'Giá không được bỏ trống và phải số.',
             'product_items.*.comparative_price.*' => 'Giá tham chiếu phải số.',
             'product_items.*.quantity.*' => 'Số lượng không hợp lý',
             'product_items.*.sku.*' => 'SKU phân loại không vượt quá 255 ký tự.',
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
