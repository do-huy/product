<?php

namespace App\Traits;

trait ValidateVoucher
{
    public function validateSingleCart($voucher, $cart)
    {
        $validated = $this->validateVoucher($voucher, $cart);

        if ($validated) {
            return $validated;
        }

        if (!$voucher->canApplyForSeller($cart->seller_id)) {
            return $this->responseJsonError(
                'Voucher không dùng được cho cửa hàng này',
                VOUCHER_CANNOT_APPLY_FOR_SELLER
            );
        }

        return null;
    }

    public function validateAllCart($voucher, $carts)
    {
        $cartsCanApply = $carts->filter(function ($cart) use ($voucher) {
            return !$this->validateVoucher($voucher, $cart);
        });

        if (!$cartsCanApply->count()) {
            return $this->responseJsonError(
                'Không có giỏ hàng nào dùng được voucher',
                VOUCHER_CANNOT_APPLY_FOR_ANY_CART
            );
        }

        if (!$voucher->canUseAllStore()) {
            return $this->responseJsonError(
                'Voucher không dùng được cho mọi cửa hàng',
                VOUCHER_CANNOT_APPLY_FOR_ALL_SELLER
            );
        }

        return null;
    }

    public function validateVoucher($voucher, $cart)
    {
        if (!$voucher || !$voucher->canUse()) {
            return $this->responseJsonError(
                'Voucher không tồn tại hoặc không thể sử dụng',
                VOUCHER_UNAVAILABLE
            );
        }

        if (!$voucher->canApplyForUser(auth()->id())) {
            return $this->responseJsonError(
                'Voucher đã quá số lượt sử dụng',
                VOUCHER_WAS_MAXIMUM_TO_USE
            );
        }

        if (!$cart || !$cart->total) {
            return $this->responseJsonError(
                'Giỏ hàng không tồn tại hoặc không sản phẩm được chọn.',
                CART_NOT_EXISTS
            );
        }

        if (!$voucher->canApplyForCart($cart)) {
            return $this->responseJsonError(
                'Giá trị đơn hàng của cửa hàng chưa đủ để sử dụng voucher này.',
                CART_NOT_ENOUGH_TO_USE_VOUCHER
            );
        }

        return null;
    }

    public function removeVoucherIfCanNotApply($cart)
    {
        $sellerVoucher = $cart->sellerVoucher;
        if ($sellerVoucher && $this->validateSingleCart($sellerVoucher, $cart)) {
            $cart->update(['seller_voucher_id' => null]);
        }

        $platformVoucher = $cart->platformVoucher;
        if ($platformVoucher && $this->validateAllCart($platformVoucher, collect([$cart]))) {
            $cart->update(['platform_voucher_id' => null]);
        }
    }

    public function setPlatformVoucher($cart)
    {
        $carts = auth()->user()->carts()->get();
        $platformVoucher = null;
        $carts->each(function ($car) use (&$platformVoucher) {
            if ($car->platformVoucher) {
                $platformVoucher = $car->platformVoucher;

                return false;
            }
        });

        if ($platformVoucher && !$this->validateAllCart($platformVoucher, collect([$cart]))) {
            $cart->update(['platform_voucher_id' => $platformVoucher->id]);
        }
    }
}
