<?php

namespace App\Traits;

use Modules\Cart\app\Models\CartItem;
use Modules\Product\app\Models\Product;

trait ValidateCart
{
    private function validateProduct($productId, $productItemId, $amount)
    {
        $product = Product::whereId($productId)
            ->first();
        if (!$product) {
            $this->removeCartItem($productId, $productItemId);

            return [$product, null, PRODUCT_NOT_EXISTS];
        }

        $productItem = $product->productItems->first(function ($pItem) use ($productItemId) {
            return $pItem->id == $productItemId;
        });

        if (($product->productItems->count() && !$productItem) || (!$product->productItems->count() && $productItemId)) {
            $this->removeCartItem($productId, $productItemId);

            return [$product, $productItem, PRODUCT_NOT_EXISTS];
        }

        if ($product->status != Product::STATUS_ACTIVE) {
            $this->unselectedCartItems($productId, $productItemId);

            return [$product, $productItem, PRODUCT_NOT_EXISTS];
        }

        $quantity = $productItem ? $productItem->quantity : $product->quantity;
        if ($quantity === 0 || $quantity < $amount) {
            // $this->unselectedCartItems($productId, $productItemId);

            return [$product, $productItem, PRODUCT_NOT_ENOUGH];
        }

        return [$product, $productItem, null];
    }

    private function removeCartItem($productId, $productItemId, $cartId = null)
    {
        $carts = auth()->user()->carts()->get();

        CartItem::whereIn('cart_id', $carts->pluck('id'))
            ->when($cartId, function ($query) use ($cartId) {
                return $query->whereCartId($cartId);
            })
            ->whereProductId($productId)
            ->when($productItemId, function ($query) use ($productItemId) {
                return $query->orWhere('product_item_id', $productItemId);
            })
            ->delete();
    }

    private function unselectedCartItems($productId, $productItemId)
    {
        $carts = auth()->user()->carts()->get();
        CartItem::whereIn('cart_id', $carts->pluck('id'))
            ->whereProductId($productId)
            ->when($productItemId, function ($query) use ($productItemId) {
                return $query->where('product_item_id', $productItemId);
            })
            ->update(['is_selected' => CartItem::IS_NOT_SELECTED]);
    }

    private function changeCartItemAmount($productId, $productItemId, $amount)
    {
        $carts = auth()->user()->carts()->get();
        CartItem::whereIn('cart_id', $carts->pluck('id'))
            ->whereProductId($productId)
            ->when($productItemId, function ($query) use ($productItemId) {
                return $query->where('product_item_id', $productItemId);
            })
            ->update(['amount' => $amount]);
    }

    private function updateOrChangeCart($productId, $productItemId, $amount)
    {
        if ($amount === 0) {
            $this->unselectedCartItems($productId, $productItemId);
        } else {
            $this->changeCartItemAmount($productId, $productItemId, $amount);
        }
    }

    private function validateCartItem(CartItem $cartItem)
    {
        list($product, $productItem, $code) = $this->validateProduct(
            $cartItem->product_id,
            $cartItem->product_item_id,
            $cartItem->amount
        );

        if (!$code && $cartItem->cart->seller_id != $cartItem->product->seller_id) {
            $this->removeCartItem($cartItem->product_id, $cartItem->product_item_id, $cartItem->cart_id);
            $code = PRODUCT_NOT_EXISTS;
        }

        if ($code) {
            if ($code === PRODUCT_NOT_ENOUGH) {
                $quantity = $productItem ? $productItem->quantity : $product->quantity;

                $this->updateOrChangeCart(
                    $product->id,
                    $productItem ? $productItem->id : null,
                    $quantity
                );
            }

            return $this->responseJsonError(
                'Sản phẩm đã thay đổi hoặc không tồn tại trên hệ thống.',
                $code
            );
        }

        return null;
    }
}
