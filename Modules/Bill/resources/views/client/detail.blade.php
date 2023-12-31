@extends('client.master')
@section('css')
<link rel="stylesheet" href="{{ asset('client/css/profile/profile.css') }}">
@endsection
@section('content')
<!-- Begin Li's Breadcrumb Area -->
            <div class="breadcrumb-area">
                <div class="container">
                    <div class="breadcrumb-content">
                        <ul>
                            <li><a href="{{ route('home') }}">Trang chủ</a></li>
                            <li class="active">Quản lý tài khoản</li>
                        </ul>
                    </div>
                </div>
            </div>
<!-- Li's Breadcrumb Area End Here -->
<!-- Begin Li's Main Blog Page Area -->
<div class="li-main-blog-page li-main-blog-details-page  pb-sm-45 pb-xs-45">
    <div class="container">
        <div class="row">
            <!-- Begin Li's Blog Sidebar Area -->
            <div class="col-lg-3 order-lg-1 order-2">
                @include('user::client.layouts.sidebar-profile')
            </div>
            <!-- Li's Blog Sidebar Area End Here -->
            <!-- Begin Li's Main Content Area -->
            <div class="col-lg-9 order-lg-2 order-1">
                <div class="row li-main-content">
                    <div class="col-lg-12">
                        <div class="li-blog-single-item pb-30 pt-25">
                            <h4 class="title-form-profile">Danh sách đơn hàng đã mua</h4>

                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Hình ảnh</th>
                                        <th scope="col">Tên sản phẩm</th>
                                        <th scope="col">Số lượng</th>
                                        <th scope="col">Tổng tiền</th>
                                       
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bill->billDetails as $stt => $bill_detail)
                                            <tr>
                                                <th scope="row">{{ $stt+1 }}</th>
                                                <th scope="row">
                                                    <img style="border-radius:3px" width="40" src="{{$bill_detail->product->getFirstMediaUrl('product') ?: asset('images/product/default-product.png') }}" alt="">
                                                </th>
                                                <th scope="row">
                                                    <a href="{{ route('client.product.detail', [$bill_detail->product->slug]) }}">
                                                        {{ $bill_detail->name }}
                                                    </a>
                                                </th>
                                                <th scope="row">{{ $bill_detail->amount }}</th>
                                                <th scope="row">{{ number_format($bill_detail->price) }} đ</th>
                                            </tr>
                                        @endforeach                             
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Li's Main Content Area End Here -->
        </div>
    </div>
</div>
<!-- Li's Main Blog Page Area End Here -->
@endsection

