<div class="row ">
    <div class="col-md-12">
        <div class="form-group">
            <label class="bmd-label-floating">Phân loại hàng hóa</label>&nbsp;
            <button type="button" class="btn btn-primary btn-xs" onclick="addVariantGroup()">Thêm phân loại</button>
        </div>
        <div id="variant-box">
        </div>
        <div id="input-file-box" class="hidden">
        </div>
        <div id="old-images-box" class="hidden">
        </div>
    </div>
</div>

<div class="row m-t-20" id="product-item-box" style="display: none;">
    <div class="col-md-12">
        <div class="form-group">
            <label class="bmd-label-floating">Danh sách phân loại hàng</label>&nbsp;
        </div>

        <table id="product-item-table" class="table table-bordered product-item-table">
            <thead>
                <tr>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
@push('css')
<link href="{{ asset('admin/css/product/variant.css') }}" rel="stylesheet">
@endpush
@push('js')

@if($product)
@php
    $productItems = $product->productItems->map(function ($productItem) {
        return array_merge(
            $productItem->only(['id', 'price', 'comparative_price','quantity', 'sku']),
            [
                'image' => ($firstMedia = $productItem->medias->first()) ? $firstMedia->getUrl() ?? null : null,
                'options' => $productItem->variantOptions->map(function ($option) {
                    return $option->value;
                }),
            ]
        );
    });

    $variants = $product->variants->map(function ($variant) {
        return array_merge(
            $variant->only(['id', 'name']),
            [
                'options' => $variant->variantOptions->map(function ($option) {
                    return $option->value;
                }),
                'option_ids' => $variant->variantOptions->map(function ($option) {
                    return $option->id;
                })
            ]
        );
    });

    $variantOptionImages = [];
    if (!empty($product->variants[0])) {
        foreach ($product->variants[0]->variantOptions as $vOption) {
            if (!empty($errors->get('*') && !empty(old('variant_old_files')) && !in_array($vOption->value, array_keys(old('variant_old_files'))))) {
                continue;
            }
            $media = $vOption->getFirstMedia('variant_option_images');

            $variantOptionImages[$vOption->value] = [
                'path' => $media ? $media->getPathRelativeToRoot() : '',
                'url' => $media ? $media->getUrl() : ''
            ];
        }
    }
@endphp
@endif
<script>
    const DEFAULT_IMAGE = `{{asset('admin/images/default.jpg')}}`;
    const VALIDATOR_ERRORS = {
        variant: {
            name: {!! json_encode($errors->get('variants.*.name')) !!},
            option: {
                ...{!! json_encode($errors->get('variants.*.options.*')) !!}
            },
            firstOptionErrors: {!! json_encode($errors->get('variants.*.options')) !!}
        },

        productItem: {
            price: {!! json_encode($errors->get('product_items.*.price')) !!},
            comparative_price: {!! json_encode($errors->get('product_items.*.comparative_price')) !!},
            quantity: {!! json_encode($errors->get('product_items.*.quantity')) !!},
        },
    }

    const OLD_VARIANTS = {!! !empty($errors->get('*')) ? json_encode(old('variants') ?? []) : json_encode($variants ?? []) !!}
    const OLD_PRODUCT_ITEMS = {!! !empty($errors->get('*')) ? json_encode(old('product_items') ?? []) : json_encode($productItems ?? []) !!}
    const OLD_VARIANT_OPTION_IMAGE = {!! json_encode($variantOptionImages ?? []) !!}
</script>
<script src="{{ asset('admin/js/product/variant.js') }}"></script>
@endpush
