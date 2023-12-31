@php
use Modules\Product\app\Models\Product;
@endphp
@extends('client.master')
@section('css')
<!-- custom css -->
<link rel="stylesheet" href="{{ asset('client/css/cart/cart.css') }}">
<link rel="stylesheet" href="{{ asset('client/css/cart/style.css') }}">
@endsection
@section('content')
<section class="sec-cart">
    <div class="container">
        <div class="tit-cart">1. Giỏ hàng </div>

        @if($carts->count() == 0)
        <div class="empty-cart">
            <div class="ico-empty-cart"><i class="fas fa-cart-plus"></i></div>
            <div class="text-empty-cart">Giỏ hàng của bạn đang trống</div>

            <div class="home-cart">
                <a href="{{ route('home') }}">
                    <button type="button" class="btn-empty-cart btn-sene">Tiếp tục mua hàng</button>
                </a>
            </div>
        </div>
        @else
        <div class="content-notifi">
            <div class="titlen-notifi">
                <i class="fas fa-star"></i>
                Hãy chia thành nhiều đơn nhỏ để áp dụng nhiều lần khuyến mãi.
            </div>
        </div>
        <div class="grid-title-pro-cart">
            <div class="title-pro-cart">
                <div class="item-title-pro-cart">
                    <input class="select-all-seller" type="checkbox" value="">
                    Sản Phẩm
                </div>
                <div class="item-title-pro-cart center">
                    Đơn giá
                </div>
                <div class="item-title-pro-cart center">
                    Số lượng
                </div>
                <div class="item-title-pro-cart center">
                    Số tiền
                </div>
                <div class="item-title-pro-cart center">
                    Thao tác
                </div>
            </div>
        </div>

        <div class="item-pro">
            @php
            $totalAlreadyCartItem = 0;
            $platformVoucher = null;
            @endphp
            @foreach ($carts as $cart)
            @if ($cart->platformVoucher && !$platformVoucher)
            @php $platformVoucher = $cart->platformVoucher; @endphp
            @endif
            @if ($cart->cartItems->count())
            <div class="div-item-pro">
                <div class="div-store">
                    <input type="checkbox" value="">
                    <span class="name-store">{{ $cart->seller->name }}</span>
                </div>
                @foreach ($cart->cartItems as $cartItem)
                @php
                $cartItemInfo = $cartItem->getItemInfo();
                $alreadyCartItem = $cartItem->product->status == Product::STATUS_ACTIVE && $cartItemInfo['quantity'] > 0;
                if ($alreadyCartItem) {
                    $totalAlreadyCartItem++;
                }
                @endphp
                <div class="grid-item-pro  {{ !$alreadyCartItem ? 'cart-item-disable' : '' }}">
                    <div class="item-name-pro-c">
                        <div class="item-pro-c">
                            <div class="check-pro">
                                @if($alreadyCartItem)
                                <input class="select-cart-item" data-cart-item-id="{{ $cartItem->id }}" type="checkbox"
                                    {{ $cartItem->is_selected ? 'checked' : '' }}
                                data-url-change-selected="{{ route('cart.select', $cartItem->id) }}">
                                @endif
                            </div>
                        </div>
                        <div class="img-pro">
                            <img width="80" src="{{ $cartItemInfo['image'] }}" alt=""
                                onerror="this.src='{{asset('admin/images/default.jpg')}}'">
                        </div>
                        <div class="item-pro-c">
                            <div class="name-pro">
                                <span>{{ $cartItemInfo['name'] }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="item-pro-c">
                        <div class="price-pro">
                            <div>{{ number_format($cartItemInfo['price'],0, '', '.') }}<span> ₫ </span></div>
                        </div>
                    </div>
                    <div class="item-pro-c">
                        <div class="control-pro">
                            <div class="cart-control-child">
                                <div class="desc control-cart" data-can-update-item="{{$alreadyCartItem ? 1 : 0}}"
                                    send_to="{{ route('cart.down', [$cartItem->id]) }}">-</div>
                                <div class="carttity cart-item-amount"> {{ $cartItem->amount }}</div>
                                <div class="asc control-cart" data-can-update-item="{{$alreadyCartItem ? 1 : 0}}"
                                    send_to="{{ route('cart.up', [$cartItem->id]) }}">+</div>
                                <input type="hidden" class="max-result" value="{{$cartItem->product->amount}}" />
                            </div>
                        </div>
                    </div>
                    <div class="item-pro-c">
                        <span class="cart-item-total">{{ number_format($cartItem->total,0, '', '.') }} ₫</span>
                    </div>
                    <div class="item-pro-c delete-cart-item">
                        <form id="cart-destroy">
                            @csrf
                            <button type="button" data-id="{{ $cartItem->id }}" class="btn-cart destroy-cart-btn">
                                Xóa
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
                <input type="hidden" data-url="{{ route('destroy.cart', ['id' => ":id"]) }}" id="urlDelteCart">
                <div class="voucher">
                    @php
                    $voucherText = $cart->sellerVoucher
                    ? $cart->sellerVoucher->name . '(-' . number_format($cart->seller_discount_tmp, 0, '', ',') . '₫)'
                    : '';
                    @endphp
                    Shop voucher:
                    <span class="voucher-text-group text-danger {{ $cart->sellerVoucher ? '' : 'd-none'}}"
                        id="voucher-cart-id-{{ $cart->id }}">
                        <span class="voucher-text">{{ $voucherText }}</span>
                        <span class="material-icons-sharp remove-voucher" data-cart-id="{{ $cart->id }}">cancel</span>
                    </span>
                    <a type="button" class="open-voucher-modal" data-cart-id="{{ $cart->id }}"
                        data-seller-id="{{ $cart->seller_id }}">
                        Xem thêm Voucher
                    </a>
                </div>
            </div>
            @endif
            @endforeach

        </div>

        <div class="sene-voucher">
            <div class="voucher-s">
                <span><i class="fas fa-percentage"></i> Sene voucher: </span>
                <span class="voucher-text-group text-danger {{ $platformVoucher ? '' : 'd-none'}}" id="platform-voucher-text">
                    <span class="voucher-text">{{ $platformVoucher ? $platformVoucher->name : '' }}</span>
                    <span class="material-icons-sharp remove-voucher">cancel</span>
                </span>
                <a type="button" class="open-voucher-modal">Chọn hoặc nhập mã</a>
            </div>
        </div>

        <div class="total-pro-cart">
            {{-- <div class="title-order-cart">Thanh toán</div> --}}
            <div class="grid-total">
                <div class="item-total">
                    <input class="select-all-seller" type="checkbox"> Chọn tất cả({{ $totalAlreadyCartItem }})
                </div>
                <div class="item-total end">
                    <div class="total-pro">
                        Tổng đơn hàng ( tạm tính )(<span class="number-product-cart">{{ auth()->user()->amountCartSelectedCanBuy
                            }}</span> sản phẩm) : <span id="cart-total-all">{{
                            number_format(auth()->user()->totalSelectedCanBuy,0, '', '.') }}</span><span> ₫ </span>
                    </div>
                </div>
                <div class="but-checkout">
                    <div class="cart-order-sum-xn">
                        <button type="button" class="btn-success-cart" id="to-order"
                            @disabled(!auth()->user()->amountCartSelectedCanBuy)>
                            Tiến hành đặt hàng
                        </button>
                    </div>
                </div>
            </div>
        </div>

        @endif
    </div>
    @include('client.cart.layouts.errors')
    @include('client.cart.layouts.voucher')

</section>
@endsection
@section('js')
<script>
    $(function() {
        $('#to-order').on('click', function() {
            window.location.href= `{{route('checkout.address')}}`
        })
    });
</script>
<script src="{{ asset('client/js/error.js') }}"></script>
<script src="{{ asset('client/js/cart/cart.js') }}"></script>
@if(session()->has('cartError'))
<script>
    $(function() {
        showError(`{{ session()->get('cartError') }}`, () => window.location.reload())
    })
</script>
@php
session()->forget('cartError');
@endphp
@endif
@endsection
