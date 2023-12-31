<?php

namespace Modules\Product\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Modules\Category\app\Models\Category;
use Modules\Product\app\Models\Product;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Product\Repositories\ProductRepository;
use Validators\Product\Repositories\ProductValidator;

/**
 * Class ProductRepositoryEloquent.
 *
 * @package namespace Modules\Product\Repositories;
 */
class ProductRepositoryEloquent extends BaseRepository implements ProductRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Product::class;
    }

    public function getCategory()
    {
        $categories = Category::with('sub_categories')
        ->select('id', 'name')
        ->where('status', 1)
        ->get();
        return $categories;
    }
    public function create($data)
    {
        $product = new $this->model($data);
        $product->status = request()->has('status');
        $product->seller_id = Auth::user()->seller->id;
        $product->save();

        if (request()->hasFile('image')) {
            $product->addMediaFromRequest('image')
                ->usingName($product->name)
                ->toMediaCollection('product');
        }

        if (request()->has('srcs')) {
            foreach (request()->srcs as $src) {
                $product->addMedia($src)->toMediaCollection('products');
            }
        }

        if (!empty(request()->input('variants'))) {
            $this->createProductVariant($product, request());
        }
    }

     /**
     * createProductVariant.
     * @param Request $request
     * @return Renderable
     */
    private function createProductVariant(Product $product)
    {
        $variants = [];
        foreach (request()->input('variants') as $vr) {
            $variant = $product->variants()->firstOrCreate([
                'name' => $vr['name'],
                'category_id' => $product->category_id,
            ]);

            $variant->variantOptions()->createMany(
                array_map(function ($option) {
                    return ['value' => $option];
                }, $vr['options'])
            );

            $variants[] = $variant;
        }

        // addMediaFromDisk
        $this->createVariantImage($variants, request());

        foreach (request()->input('product_items') as $pItem) {
            $firstOption = $pItem['options'][0];
            $firstVariantOption = $variants[0]->variantOptions->first(function ($variantOption) use ($firstOption) {
                return $variantOption->value === $firstOption;
            });

            $productItem = $product->productItems()->create([
                'price' => $pItem['price'],
                'comparative_price' => $pItem['comparative_price'],
                'quantity' => $pItem['quantity'],
                'sku' => $pItem['sku'],
                'first_variant_option_id' => $firstVariantOption->id,
            ]);

            $productItem->variantOptions()->sync($this->mapOptionsToId($pItem['options'], $variants));
        }
    }

    /**
     * createVariantImage.
     * @param Request $request
     * @return Renderable
     */
    private function createVariantImage($variants)
    {
        // clear old file
        $oldFileKeep = request()->input('variant_old_files');

        $firstVariantOptionImages = [];
        $variantFiles = request()->all()['variant_files'] ?? [];
        $variants[0]->variantOptions->each(function ($variantOption) use ($firstVariantOptionImages, &$variantFiles, $oldFileKeep) {
            $firstMedia = $variantOption->getFirstMedia('variant_option_images');
            if (!empty($oldFileKeep[$variantOption->value])
                && !empty($firstMedia)
                && $firstMedia->getPathRelativeToRoot() === $oldFileKeep[$variantOption->value]) {
                // continue each
                return true;
            }

            if ($firstMedia) {
                $firstMedia->delete();
            }

            if (!empty($variantFiles[$variantOption->value]) && empty($firstVariantOptionImages[$variantOption->value])) {
                $firstVariantOptionImages[$variantOption->value] = $variantOption->addMedia($variantFiles[$variantOption->value])
                    ->toMediaCollection('variant_option_images');

            }
        });
    }

    /**
     * mapOptionsToId.
     * @param Request $request
     * @return Renderable
     */
    private function mapOptionsToId($itemOptions, $variants)
    {
        $optionIds = [];
        foreach ($itemOptions as $key => $value) {
            $optionIds[] = $variants[$key]->variantOptions->first(function ($variantOption) use ($value) {
                return $variantOption->value == $value;
            })->id;
        }

        return $optionIds;
    }

    public function getById($slug)
    {
        $product = $this->model->where('slug', $slug)
        ->with([
            'productItems',
            'productItems.variantOptions',
            'variants',
            'variants.variantOptions',
        ])
        ->first();

        if (!$product) {
            throw new ModelNotFoundException();
        }

        return $product;
    }

    public function update($data, $slug)
    {
        $product = $this->model->where('slug', $slug)->first()->fill(request()->all());
        if (!$product) {
            throw new ModelNotFoundException();
        }
        $product->status = request()->has('status');
        $product->save();

        if (request()->hasFile('image')) {
            $product->clearMediaCollection('product');
            $product->addMediaFromRequest('image')->usingName($product->name)->toMediaCollection('product');
        }

        if (request()->has('srcs')) {
            $product->clearMediaCollection('products');
            foreach (request()->srcs as $src) {
                $product->addMedia($src)->toMediaCollection('products');
            }
        }

        $this->updateProductVariant($product, request());
    }

    /**
     * updateProductVariant
     * @param int $id
     * @return Renderable
     */
    private function updateProductVariant(Product $product)
    {
        if (empty(request()->input('variants'))) {
            $product->productItems()->delete();

            $product->variants->each(function ($variant) {

                // Xóa hình ảnh từ bộ sưu tập variant_image của từng variant_option
                $variant->variantOptions->each(function ($variantOption) {
                    $variantOption->clearMediaCollection('variant_option_images');
                });

                $variant->variantOptions()->delete();

            });

            $product->variants()->delete();

            return;
        };

        $variants = [];
        foreach (request()->input('variants') as $vr) {
            $variant = !empty($vr['id'])
            ? $variant = $product->variants()->whereId($vr['id'])->first()
            : $product->variants()->firstOrCreate([
                'name' => $vr['name'],
                'category_id' => $product->category_id,
            ]);
            $variant->update($vr);

            // Lấy danh sách các ID của các `variant_options` cũ của `variant`
            // $oldVariantOptionIds = $variant->variantOptions->pluck('id')->toArray();


            $variant->variantOptions()->whereNotIn('id', $vr['option_ids'])->delete();

            // Xóa hình ảnh của các `variant_options` cũ
            // $oldVariantOptions = $variant->variantOptions()->whereIn('id', $oldVariantOptionIds)->get();
            // foreach ($oldVariantOptions as $oldVariantOption) {
            //     $oldVariantOption->clearMediaCollection('variant_option_images');
            // }


            foreach ($vr['options'] as $key => $op) {
                if (!empty($opId = $vr['option_ids'][$key])) {
                    $variant->variantOptions()->whereId($opId)->first()->update(['value' => $op]);
                } else {
                    $variant->variantOptions()->create(['value' => $op]);
                }
            }

            $variants[] = $variant;
        }


        // addMediaFromDisk
        $this->createVariantImage($variants, request());

        $product->productItems()
            ->whereNotIn('id', array_column(request()->input('product_items'), 'id'))
            ->delete();

        foreach (request()->input('product_items') as $pItem) {
            $firstOption = $pItem['options'][0];
            $firstVariantOption = $variants[0]->variantOptions->first(function ($variantOption) use ($firstOption) {
                return $variantOption->value === $firstOption;
            });

            $productItem = !empty($pItem['id'])
                ? $productItem = $product->productItems()
                    ->whereId($pItem['id'])
                    ->first()
                : $product->productItems()->create([
                    'price' => $pItem['price'],
                    'comparative_price' => $pItem['comparative_price'],
                    'quantity' => $pItem['quantity'],
                    'sku' => $pItem['sku'],
                    'first_variant_option_id' => $firstVariantOption->id,
                ]);

            $productItem->update([
                'price' => $pItem['price'],
                'comparative_price' => $pItem['comparative_price'],
                'quantity' => $pItem['quantity'],
                'sku' => $pItem['sku'],
                'first_variant_option_id' => $firstVariantOption->id,
            ]);

            $productItem->variantOptions()->sync($this->mapOptionsToId($pItem['options'], $variants));
        }
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
