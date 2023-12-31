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
                            <li class="active">Thêm địa chỉ</li>
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
                            <h4 class="title-form-profile">Cập nhập địa chỉ</h4>
                            <form id="update-address" data-profile-update-address-route="{{ route('client.profile.update.address', [$address->slug]) }}">
                                @csrf
                                <div class="div-avatar-name-profile">

                                    <div class="div-name-profile">

                                        <div class="form-group form-name">
                                            <label id="label-file" class="label-name" for="name">Tên người nhận*</label>
                                            <input type="text" id="name" name="name" class="form-control" value="{{ $address->name }}">
                                            <div class="text-danger" id="err-name"></div>
                                        </div>

                                        <div class="form-group form-name">
                                            <label id="label-file" class="label-name" for="name">Số điện thoại người nhận*</label>
                                            <input type="number" id="phone" name="phone" class="form-control" value="{{ $address->phone }}">
                                            <div class="text-danger" id="err-phone"></div>
                                        </div>

                                        <div class="form-group">
                                            <label id="label-file" for="name">Thành phố</label>
                                            <select id="province_id" class="form-control height-input-select" name="province_id">
                                                @foreach($provinces as $province)
                                                    <option {{$address->province_id ==
                                                    $province->id?'selected':''}}
                                                    value="{{$province->id}}">{{$province->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger" id="err-province_id"></span>
                                        </div>
                                        <div class="form-group">
                                            <label id="label-file" for="name">Tỉnh thành</label>
                                            <select class="form-control height-input-select" id="district_id" name="district_id" data-old="{{ $address->district_id }}">
                                            </select>
                                            <span class="text-danger" id="err-district_id"></span>
                                        </div>
                                        <div class="form-group">
                                            <label id="label-file" for="name">Quận huyện</label>
                                            <select id="ward_id" class="form-control height-input-select" name="ward_id" data-old="{{ $address->ward_id }}">
                                            </select>
                                            <span class="text-danger" id="err-ward_id"></span>
                                        </div>
                                        <div class="form-group">
                                            <label id="label-file" for="name">Địa chỉ chi tiết</label>
                                            <textarea type="text" name="description"  class="form-control height-input-textarea">{!! $address->description !!}</textarea>
                                            <span class="text-danger" id="err-description"></span>
                                        </div>

                                        @if($address->is_default !== 1)
                                            <div class="form-group">
                                                <input type="checkbox" name="is_default" class="check-default" {{  ($address->is_default == 1 ? ' checked' : '') }}> <span class="custom-default"> Đặt làm địa chỉ mặc định</span>
                                                <span class="text-danger" id="err-is_default"></span>
                                            </div>
                                        @endif

                                    </div>

                                </div>
                                <div class="btn-submit-profile">
                                    <div class="form-group">
                                        <button type="button" data-slug="{{ $address->slug }}" id="submit-update-address" class="btn-sene">Lưu thông tin</button>
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
@php
$districts = $provinces->mapWithKeys(function ($item) {
    $item->districts = $item->districts->mapWithKeys(function ($district) {
        return [$district['id'] => $district];
    });
    return [$item['id'] => $item['districts']];
});
@endphp
@endsection
@section('js')
    <script src="{{ asset('client/js/profile/address.js') }}"></script>
    <script type="text/javascript">
        var districts = {!! json_encode($districts->toArray()) !!};
        var district = [];
        var ward = [];

        writeDistricts();
        writeWards();

        $('#province_id').change(function () {
            writeDistricts();
            writeWards();
        });

        $('#district_id').change(function () {
            writeWards();
        });

        function writeDistricts() {

            $idProvince = $('#province_id').val();
            $idDistrict = $('#district_id').val() || $('#district_id').data('old');
            $('#district_id').empty();
            if(!$idProvince){
                return;
            }

            $districts = districts[$idProvince] || {};
            $.each($districts, (idx, districts) => {
                var $selected = "";
                if($idDistrict == districts.id){
                    $selected = "selected";
                    $('#district_id').data('old', null);
                }
                let html = `<option value="${districts.id}" ${$selected}>${districts.name}</option>`;
                $('#district_id').append(html);
            });
        }

        function writeWards() {

            $idProvince = $('#province_id').val();
            $idDistrict = $('#district_id').val() || $('#district_id').data('old');
            $idProductTypeId = $('#ward_id').val() || $('#ward_id').data('old');

            $('#ward_id').empty();
            if(!$idProvince || !$idDistrict){
                return;
            }

            $districts = districts[$idProvince] || {};
            $district = $districts[$idDistrict] || {};

            $wards = $district.wards || {};

            $.each($wards, (idx, wards) => {

                var $selected = "";
                if($idProductTypeId == wards.id){
                    $selected = "selected";
                    $('#ward_id').data('old', null);
                }

                let html = `<option value="${wards.id}" ${$selected}>${wards.name}</option>`;
                $('#ward_id').append(html);
            });
        }
    </script>
@endsection
