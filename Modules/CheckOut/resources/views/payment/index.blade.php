@php
use Modules\Product\app\Models\Product;
use Modules\Bill\app\Models\Bill;
@endphp
@extends('client.master')
@section('css')
<!--- Css breadcrumb --->
<link href="{{ asset('client/css/payment/payment.css')}}" rel="stylesheet" type="text/css">
@endsection
@section('content')
<section class="payment-cart">
    <div class="container">
        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <div class="title-checkout">3. Thanh toán</div>
            {{-- <div class="payment-pay">
                <input type="radio" name="form" value="Giao thu tiền" checked>Thanh toán chi phí hóa đơn khi
                nhận được hàng<br>
                <input type="radio" name="form" value="Chuyển khoản"> Chuyển khoản / Thẻ ATM nội địa / Internet
                Banking - <a data-toggle="modal" data-target="#atmModal" style="color:#f30">Lấy thông tin tài
                    khoản</a><br>
            </div> --}}
            <div class="address-checkout">
                <div class="title-add">
                    <i class="fas fa-map-marker-alt"></i>
                    Địa chỉ nhận hàng
                </div>
                <div class="content-add">
                    <span class="name-add">{{$address->name}}</span>
                    <span class="phone-add">({{$address->phone}})</span>
                    <span class="desc-add">{{$address->full}}</span>
                    <button class="butt-add">
                        <a class="but-change-add" href="{{ route('checkout.address') }}">Thay đổi địa chỉ</a>
                    </button>
                </div>
            </div>
            <div class="product-checkout">
                <div class="col-pro-checkout">
                    <div class="tit-name-pro-checkout">Sản phẩm</div>
                    <div class="tit-price-pro-checkout">Đơn giá</div>
                    <div class="tit-amount-pro-checkout">Số lượng</div>
                    <div class="tit-total-pro-checkout">Thành tiền</div>
                </div>
            </div>

            @foreach($carts as $cart)
            <div class="product-checkout">
                <div class="name-store">Cửa hàng: {{ $cart->seller->name }}</div>
                @foreach ($cart->cartItems as $cartItem)
                @php
                $cartItemInfo = $cartItem->getItemInfo();
                $alreadyCartItem = $cartItem->product->status == Product::STATUS_ACTIVE && $cartItemInfo['quantity'] >
                0;
                @endphp
                <div class="flexpro-check">
                    <div class="tboby-pro-checkout">
                        <div class="name-pro-checkout">
                            <img class="size-img-checkout" src="{{ $cartItemInfo['image'] }}" alt=""
                                onerror="this.src='{{asset('admin/images/default.jpg')}}'">
                            <span>{{ $cartItemInfo['name'] }}</span>
                        </div>
                        <div class="price-pro-checkout">{{ number_format($cartItemInfo['price'],0, '', '.') }} ₫</div>
                        <div class="amount-pro-checkout">{{ $cartItem->amount }}</div>
                        <div class="total-pro-checkout">{{ number_format($cartItem->total,0, '', '.') }} ₫</div>
                    </div>
                    @endforeach

                    <div class="footer-pro-checkout">
                        <div class="cont-pro-check">
                            <input type="text" name="notes[{{$cart->id}}]" placeholder="Lưu ý cho người bán" class="form-control-checkout">
                        </div>
                        <div class="cont-total-pro-check">
                            <div>Phí giao hàng: {{ number_format(Bill::DEFAULT_SHIPPING_FEE,0, '', '.') }}₫</div>
                            @if ($sellerDiscount = $cart->seller_discount_tmp)
                            <div>Khuyến mại của {{ $cart->seller->name }}: {{ number_format($sellerDiscount,0, '', '.')
                                }} ₫</div>
                            @endif
                            @if ($platformDiscount = $cart->platform_discount_tmp)
                            <div>Khuyến mại của Sene: {{ number_format($platformDiscount,0, '', '.') }} ₫</div>
                            @endif
                            <div class="div-total-check">Tổng tiền: <span
                                class="wei-total">{{number_format($cart->total,0, '', '.')}} ₫</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            @php
            $shippingTotal = $carts->count() * Bill::DEFAULT_SHIPPING_FEE;
            $userTotal = auth()->user()->totalSelectedCanBuy;
            $finalTotal = $userTotal + $shippingTotal;
            @endphp
            <div class="title-payment-total">
                <span class="order-payment">Thanh toán khi nhận hàng</span>
                <span class="cod-payment">Phí thu hộ: {{number_format($finalTotal,0, '', '.')}} ₫</span>
            </div>

            <div class="title-payment-sum-total">
                <div class="payment-sum-produc-item">
                    <div class="order-sum-pro-ite">
                        Tổng tiền hàng: <span class="margin-left">{{number_format($userTotal,0, '', '.')}} ₫</span>
                    </div>
                    <div class="order-sum-ship">
                        Phí vận chuyển:
                        <span class="margin-left-1">{{number_format($shippingTotal,0, '', '.')}} ₫</span>
                    </div>
                    <div class="order-sum-total">
                        Tổng thanh toán:
                        <span class="sum-total-pro-item">{{number_format($finalTotal,0, '', '.')}} ₫</span>
                    </div>
                    <div class="cart-order-sum-xn">
                        <button class="btn-success-cart" id="btn-submit-order" type="submit">Đặt mua</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

@endsection
