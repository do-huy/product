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
                                        <th scope="col">Mã đơn hàng</th>
                                        <th scope="col">Ngày mua</th>
                                        <th scope="col">Tổng tiền</th>
                                        <th scope="col">Trạng thái</th>
                                        <th scope="col">Xem chi tiết</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bills as $stt => $bill)
                                            <tr>
                                                <th scope="row">{{ $stt+1 }}</th>
                                                <td>{{ 'SENE-'.$bill->id }}</td>
                                                <td>{{ $bill->created_at->format('d-m-Y') }}</td>
                                                <td>{{ number_format($bill->total, 0, '', ',') }} (VND)(Chưa phí ship)</td>
                                                <td>
                                                  
                                                    <span class="back-stt-order status-order">{{ $bill->status }}</span>
                                              
                                                </td>
                                                <td>                                              
                                                    <a href="{{ route('client.bill.detail',[$bill->id]) }}">
                                                        <span class="view-order">Xem chi tiết </span>
                                                    </a>
                                                </td>
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

