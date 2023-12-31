@extends('client.master')
@section('css')
    <!--- Css breadcrumb --->
    <link href="{{ asset('client/css/payment/display-bill.css')}}" rel="stylesheet" type="text/css">
@endsection
@section('content')
    <section class="display-bill">
        <div class="container">
            <div class="grid-dis-bill">
                <div class="img-dis-bill">
                    <img src="{{ asset('client/images/success.png') }}" width="100%">
                </div>
                <div class="success-dis-bill">
                    <div class="payment-pay-display">
                        <p class="thanks">Cảm ơn bạn đã mua hàng ở SENE.VN !</p>
                        <p> <i class="fa fa-clock-o" aria-hidden="true"></i> Giao hàng tiêu chuẩn: thời gian giao hàng sẽ được triển khai sau khi đặt hàng thành công - giao cả ngày Thứ Bảy & Chủ Nhật.</p>
                        <p> <i class="fa fa-info-circle" aria-hidden="true"></i> Thông tin chi tiết về đơn hàng đã được gửi đến tài khoản <a style="color: red; font-size: 16px">{{Auth::user()->name}}</a>. Nếu không tìm thấy đơn hàng vui lòng kiểm tra trong lịch sử đơn hàng của bạn hoặc liên hệ tổng đài sene.vn hotline: 03.3979.5553 để được hỗ trợ.</p>
                        <div class="fast-display">
                            <p> <i class="fa fa-fighter-jet" aria-hidden="true" style="color:#33ccff"></i> Nhằm giúp việc xử lý đơn hàng nhanh hơn nữa, Sene.vn sẽ liên hệ bạn để xác nhận đơn hàng cho chính xác địa chỉ.</p>
                        </div>
                        <div class="go-btn">
                            <a href="{{route('home')}}" >
                                <button class="btn-success-display-bill"> Tiếp tục mua hàng</button>
                            </a>
                            <a href="{{ route('client.bill.index') }}" >
                                <button class="btn-success-display-bill"> Danh sách đơn hàng đã mua</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
