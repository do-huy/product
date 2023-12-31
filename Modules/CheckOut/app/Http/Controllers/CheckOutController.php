<?php

namespace Modules\CheckOut\app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ValidateCart;
use App\Traits\ValidateVoucher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Address\app\Models\Address;
use Modules\Province\app\Models\Province;
use Illuminate\Support\Facades\Session;
use Modules\Address\app\Http\Requests\Client\StoreAddressRequest;
use Modules\Bill\app\Models\Bill;
use Modules\Cart\app\Models\CartItem;

class CheckOutController extends Controller
{
    use ValidateCart, ValidateVoucher;
    /**
     * Display a listing of the resource.
     */
    public function choseAddress()
    {
        $provinces = Province::with('districts', 'districts.wards')
            ->select('id', 'name')
            ->get();
        $addresses = auth()->user()->addresses()->get();
        return view('checkout::index', compact('addresses', 'provinces'));
    }

    public function choseAddressStore(StoreAddressRequest $request)
    {
        $address = new Address($request->all());
        $address->user_id = Auth::user()->id;
        $address->save();

        return redirect()->route('checkout.address')->with('success', 'Thêm địa chỉ thành công.');
    }

    public function chosePayment(Request $request)
    {
        list($carts, $allCartAlready) = $this->getCurrentCartAlreadyToPaid();

        if (!$allCartAlready || !$carts->count()) {
            Session::flash('cartError', 'Giỏ hàng bị thay đổi hoặc số lượng một số sản phẩm trên hệ thống không đủ.');

            return redirect()->route('client.cart.detail');
        }

        $address = auth()->user()->addresses()->find($request->address_id);
        session(['address' => $address]);
        $delivery = $carts->count() * 20000;

        return view('checkout::payment.index', compact('address', 'delivery', 'carts'));
    }

    private function getCurrentCartAlreadyToPaid()
    {
        $carts = auth()->user()->carts()
            ->with(['cartItems' => function ($query) {
                return $query->whereIsSelected(1);
            }])
            ->withCount(['cartItems' => function ($query) {
                return $query->whereIsSelected(1);
            }])
            ->having('cart_items_count', '>', 0)
            ->get();

        $allCartAlready = true;
        $carts->each(function ($cart) use (&$allCartAlready) {
            $cart->cartItems->each(function ($cartItem) use (&$allCartAlready) {
                $validated = $this->validateCartItem($cartItem);
                if (is_object($validated)) {
                    $allCartAlready = false;
                }
            });

            $this->removeVoucherIfCanNotApply($cart);
        });

        return [$carts, $allCartAlready];
    }

    public function store(Request $request)
    {
        list($carts, $allCartAlready) = $this->getCurrentCartAlreadyToPaid();

        if (!$allCartAlready || !$carts->count()) {
            Session::flash('cartError', 'Giỏ hàng bị thay đổi hoặc số lượng một số sản phẩm trên hệ thống không đủ.');
            return redirect()->route('client.cart.detail');
        }

        $shipInformation = [
            'address' => session()->get('address')->full,
            'receiver_name' => session()->get('address')->name,
            'receiver_phone' => session()->get('address')->phone,
            'user_id' => Auth::id(),
        ];

        DB::beginTransaction();
        try {
            $carts->each(function ($cart) use ($shipInformation, $request) {
                $note = !empty($request->notes[$cart->id]) && is_string($request->notes[$cart->id])
                    ? $request->notes[$cart->id]
                    : null;

                $bill = Bill::create(array_merge($shipInformation, [
                    'seller_id' => $cart->seller_id,
                    'total' => $cart->cartItems->sum(function ($cartItem) {
                        return $cartItem->total;
                    }),
                    'shipping_fee' => Bill::DEFAULT_SHIPPING_FEE,
                    'seller_voucher_id' => $cart->seller_voucher_id,
                    'platform_voucher_id' => $cart->platform_voucher_id,
                    'seller_discount' => $cart->seller_discount_tmp,
                    'platform_discount' => $cart->seller_discount_tmp,
                    'note' => $note,
                ]));


                $this->updateApplyCount($cart);
                 $bill->billDetails()->createMany($cart->cartItems->map(function ($cartItem) {
                    $cartItem->delete();
                    $this->updateProductQuantity($cartItem);

                    return array_merge(
                        ['price' => $cartItem->getItemInfo()['price']],
                        $cartItem->only([
                            'name',
                            'amount',
                            'product_id',
                            'product_item_id',
                            'note',
                        ])
                    );
                }));
                if(!DB::table('cart_items')->where("cart_id", $cart->id)->count()){
                    $cart->delete();
                };
            });

            DB::commit();
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollback();
        }

        return redirect()->route('bill.show')->with('success', 'Đặt hàng thành công');
    }

    private function updateProductQuantity(CartItem $cartItem)
    {
        if ($cartItem->productItem) {
            $cartItem->productItem->update(['quantity' => $cartItem->productItem->quantity - $cartItem->amount]);
        } else {
            $cartItem->product->update(['quantity' => $cartItem->product->quantity - $cartItem->amount]);
        }
    }

    private function updateApplyCount($cart)
    {
        if ($sellerVoucher = $cart->sellerVoucher) {
            $sellerVoucher->update(['apply_count' => $sellerVoucher->apply_count++]);
        }

        if ($platformVoucher = $cart->platformVoucher) {
            $platformVoucher->update(['apply_count' => $platformVoucher->apply_count++]);
        }
    }

    public function billShow()
    {
        return view('checkout::payment.display-bill');
    }


}
