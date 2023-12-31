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

                            <div class="div-add-address">
                                <a href="{{ route('client.profile.create.address') }}">
                                    <div class="add-address"><i class="fas fa-plus"></i> Thêm mới địa chỉ</div>
                                </a>
                            </div>

                            @foreach($addresses as $address)
                            <div class="des-address">
                                <div class="user-name-address">
                                    {{ $address->name }}
                                    @if($address->is_default == 1)
                                        <span class="is-default-address">
                                            <i class="far fa-check-circle"></i> Địa chỉ mặc định
                                        </span>
                                    @endif
                                </div>
                                <div class="user-address-address">Địa chỉ :
                                    {{ $address->description }},
                                    {{$address->ward->name}},
                                    {{$address->district->name}},
                                    {{$address->province->name}}, Việt Nam
                                </div>
                                <div class="user-phone-address">Điện thoại : {{ $address->phone }}</div>
                                <div class="button-address">
                                    @if($address->is_default !== 1)
                                        <button type="submit" data-id="{{ $address->id }}" class="btn-del-address" id="data" data-profile-destroy-address-route="{{ route('client.profile.destroy.address', [$address->id]) }}">Xóa địa chỉ</button>
                                    @endif
                                    <div class="button-delete-account-address">
                                        <a href="{{ route('client.profile.edit.address', [$address->slug]) }}">
                                            <button type="button" class="btn-edit-address">Sửa địa chỉ</button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                            {{-- <div class="des-address">
                                <div class="user-name-address">Đỗ Huy</div>
                                <div class="user-address-address">Địa chỉ : 12312, Quang Trung, Hà Giang, Hà Giang, Việt Nam</div>
                                <div class="user-phone-address">Điện thoại : 0367096315</div>
                                <div class="button-address">
                                    <button type="submit" data-id="" class="btn-del-address">Xóa địa chỉ</button>

                                    <div class="button-delete-account-address">
                                        <a href="">
                                            <button type="submit" class="btn-edit-address">Sửa địa chỉ</button>
                                        </a>
                                    </div>
                                </div>
                            </div> --}}

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
    <script src="{{ asset('client/js/profile/address.js') }}"></script>
@endsection
