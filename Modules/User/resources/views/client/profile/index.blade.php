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
            <div class="col-lg-6 order-lg-2 order-1">
                <div class="row li-main-content">
                    <div class="col-lg-12">
                        <div class="li-blog-single-item pb-30 pt-25">
                            <h4 class="title-form-profile">Hồ sơ của bạn</h4>
                            <form id="update-account" method="POST" enctype="multipart/form-data" data-update-profile-route="{{ route('client.profile.update') }}">
                                @csrf
                                <div class="div-avatar-name-profile">

                                    <div class="div-name-profile">

                                        <div class="form-group form-name">
                                            <label id="label-file" class="label-name" for="name">Họ và tên</label>
                                            <input type="text" id="name" name="name" class="form-control" value="{{ Auth::user()->name }}">
                                            <div class="text-danger" id="err-name"></div>
                                        </div>

                                        <div class="form-group form-seller">
                                            <label id="label-file" class="label-seller" for="seller">Cửa hàng</label>
                                            <input type="text" id="seller_name" name="seller_name" class="form-control" value="{{ Auth::user()->seller->name }}">
                                            <div class="text-danger" id="err-seller_name"></div>
                                        </div>

                                    </div>

                                </div>
                                <div class="btn-submit-profile">
                                    <div class="form-group">
                                        <button type="button" id="submit-update-profile" class="btn-sene">Lưu thông tin</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 order-lg-2 order-1">
                @include('user::client.layouts.sidebar-right')
            </div>
            <!-- Li's Main Content Area End Here -->
        </div>
    </div>
</div>
<!-- Li's Main Blog Page Area End Here -->
@endsection
@section('js')
    <script src="{{ asset('client/js/profile/profile.js') }}"></script>
@endsection
