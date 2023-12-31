<?php

namespace Modules\Cart\app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ValidateCart;
use App\Traits\ValidateVoucher;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\Cart\app\Http\Requests\Client\CreateCartRequest;
use Modules\Cart\app\Models\Cart;
use Modules\Cart\app\Models\CartItem;
use Modules\Product\app\Models\Product;
use Modules\Voucher\app\Models\Voucher;

class CartController extends Controller
{
    use ValidateCart, ValidateVoucher;
    /**
     * Display a listing of the resource.
     */

     public function storeCart(CreateCartRequest $request)
     {
         $amount = $request->amount;
         list($product, $productItem, $code) = $this->validateProduct(
             $request->product_id,
             $request->product_item_id,
             $request->amount
         );



         if ($code || $product->status != Product::STATUS_ACTIVE) {
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

         $cart = Cart::firstOrCreate([
             'user_id' => Auth::id(),
             'seller_id' => $product->seller_id,
         ]);

         $cartItem = CartItem::whereCartId($cart->id)
             ->whereProductId($product->id)
             ->when($productItem, function ($query) use ($productItem) {
                 return $query->whereProductItemId($productItem->id);
             })
             ->first();

         if ($cartItem) {
             $cartItem->amount += $amount;
             $cartItem->save();
         } else {
             $cartItem = new CartItem;
             $cartItem->amount = $amount;
             $cartItem->cart_id = $cart->id;
             $cartItem->product_id = $product->id;

             if ($productItem) {
                 $cartItem->product_item_id = $productItem->id ?? null;
             }

             $cartItem->name = $cartItem->renderProductName();
             $cartItem->save();
         }

         $this->setPlatformVoucher($cart);

         return response()->json([
             'data' => [
                 'user_total' => auth()->user()->getTotalSelectedCanBuyAttribute(),
                 'user_amount' => auth()->user()->getAmountCartAttribute(),
             ],
             'success' => 'Thêm vào giỏ hàng thành công',
         ], 200);
     }

     public function detailCart(Request $request)
     {
         $carts = $this->getCurrentUserCart();

         $allCartAlready = true;
         $carts->each(function ($cart) use (&$allCartAlready) {
             $cart->cartItems->each(function ($cartItem) use (&$allCartAlready) {
                 $selected = $cartItem->is_selected;
                 $validated = $this->validateCartItem($cartItem);
                 if (is_object($validated) && $selected) {
                     $allCartAlready = false;
                 }
             });

             $this->removeVoucherIfCanNotApply($cart);
         });

         if (!$allCartAlready) {
             Session::flash('cartError', 'Giỏ hàng bị thay đổi do số lượng một số sản phẩm trên hệ thống không đủ.');
         }

         $carts = $this->getCurrentUserCart();

         return view('cart::index', compact('carts'));
     }

     private function getCurrentUserCart()
     {
         return auth()->user()->carts()
             ->with('cartItems')
             ->withCount('cartItems')
             ->having('cart_items_count', '>', 0)
             ->get();
     }

     public function updateUp($cartItemId)
     {
         $carts = auth()->user()->carts();
         $cartItem = CartItem::whereId($cartItemId)->whereIn('cart_id', $carts->pluck('id'))->first();
         if (!$cartItem) {
             return response()->json(['msg' => 'not found'], 404);
         }

         $cartItem->amount++;
         if ($cartItem->amount <= 1) {
             $cartItem->amount = 1;
         }
         $cartItem->save();

         $validated = $this->validateCartItem($cartItem);
         if (is_object($validated)) {
             return $validated;
         }

         return $this->responseCartUpdated($cartItem);
     }

     public function updateDown($cartItemId)
     {
         $carts = auth()->user()->carts();
         $cartItem = CartItem::whereId($cartItemId)->whereIn('cart_id', $carts->pluck('id'))->first();
         if (!$cartItem) {
             return response()->json(['msg' => 'not found'], 404);
         }

         $cartItem->amount--;
         if ($cartItem->amount <= 1) {
             $cartItem->amount = 1;
         }
         $cartItem->save();

         $validated = $this->validateCartItem($cartItem);
         if (is_object($validated)) {
             return $validated;
         }

         return $this->responseCartUpdated($cartItem);
     }

     private function responseCartUpdated(CartItem $cartItem)
     {
         $cart = Cart::find($cartItem->cart_id);

         $this->removeVoucherIfCanNotApply($cart);
         $this->setPlatformVoucher($cart);

         return response()->json(
             array_merge(
                 $cartItem->toArray(),
                 [
                     'user_total' => auth()->user()->getTotalSelectedCanBuyAttribute(),
                     'user_amount' => auth()->user()->getAmountCartSelectedCanBuyAttribute(),
                     'cart' => $cart->refresh(),
                 ]
             ),
             200
         );
     }

     public function destroy($cartItemId)
     {
         $carts = auth()->user()->carts();
         CartItem::whereId($cartItemId)->delete();

         return response()->json([
             'success' => 'Xóa giỏ hàng thành công',
         ], 200);
     }

     public function selectCartItem($cartItemId, Request $request)
     {
         $carts = auth()->user()->carts;
         $cartItem = CartItem::whereId($cartItemId)->whereIn('cart_id', $carts->pluck('id'))->first();

         if (!$cartItem) {
             return $this->responseJsonError(
                 'Giỏ hàng đã thay đổi, không thể chọn sản phẩm này.',
                 CART_ITEM_NOT_EXISTS
             );
         }

         $validated = $this->validateCartItem($cartItem);
         if (is_object($validated) && $request->is_selected == CartItem::IS_SELECTED) {
             return $validated;
         }

         $cartItem->update([
             'is_selected' => (int) ($request->is_selected)
                 ? CartItem::IS_SELECTED
                 : CartItem::IS_NOT_SELECTED,
         ]);

         return response()->json([
             'cart_item' => $cartItem,
             'user_total' => auth()->user()->getTotalSelectedCanBuyAttribute(),
             'user_amount' => auth()->user()->getAmountCartSelectedCanBuyAttribute(),
             'cart' => Cart::find($cartItem->cart_id),
             'success' => 'Thay đổi giỏ hàng thành công',
         ], 200);
     }

     public function selectVoucherForCart(Request $request, $id)
     {
         $voucher = Voucher::whereCode($request->code)->first();
         $cart = auth()->user()->carts()->find($id);

         if ($validated = $this->validateSingleCart($voucher, $cart)) {
             return $validated;
         }

         $cart->update([
             'seller_voucher_id' => $voucher->id,
         ]);

         return [
             'carts' => [auth()->user()->carts()->find($id)],
             'voucher' => $voucher,
             'user_total' => auth()->user()->getTotalSelectedCanBuyAttribute(),
             'user_amount' => auth()->user()->getAmountCartSelectedCanBuyAttribute(),
         ];
     }

     public function selectVoucherForAll(Request $request)
     {
         $voucher = Voucher::whereCode($request->code)->first();
         $carts = auth()->user()->carts()->get();

         if ($validated = $this->validateAllCart($voucher, $carts)) {
             return $validated;
         }

         auth()->user()->carts()->update(['platform_voucher_id' => null]);

         $cartsCanApply = $carts->filter(function ($cart) use ($voucher) {
             return !$this->validateVoucher($voucher, $cart);
         });

         auth()->user()->carts()->whereIn('id', $cartsCanApply->pluck('id'))
             ->update([
                 'platform_voucher_id' => $voucher->id,
             ]);

         return [
             'carts' => auth()->user()->carts()->whereIn('id', $cartsCanApply->pluck('id'))->get(),
             'voucher' => $voucher,
             'user_total' => auth()->user()->getTotalSelectedCanBuyAttribute(),
             'user_amount' => auth()->user()->getAmountCartSelectedCanBuyAttribute(),
         ];
     }

     public function removeVoucher(Request $request)
     {
         if ($request->cart_id) {
             auth()->user()->carts()->find($request->cart_id)->update(['seller_voucher_id' => null]);
         } else {
             auth()->user()->carts()->update(['platform_voucher_id' => null]);
         }

         return response()->json([
             'user_total' => auth()->user()->getTotalSelectedCanBuyAttribute(),
             'user_amount' => auth()->user()->getAmountCartSelectedCanBuyAttribute(),
             'cart' => $request->cart_id ? auth()->user()->carts()->find($request->cart_id) : null,
         ]);
     }

}
