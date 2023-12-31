@extends('client.master')
@section('css')
    <!--- Css css --->
    <link href="{{ asset('client/css/choseAddress/choseAddress.css')}}" rel="stylesheet" type="text/css">
@endsection
@section('content')
    <section class="chose-address">
        <div class="container">
            <div class="tit-address">2. Địa chỉ giao hàng</div>
            <div class="grid-any-address">
                @foreach($addresses as $address)
                    <div class="text-left bg-white siggle-contact">
                        <div class="name-contact"><h3>{{$address->name}}@if($address->is_default == 1)
                            <span class="is-default-address">
                                <i class="far fa-check-circle"></i> Địa chỉ mặc định
                            </span>
                        @endif</h3></div>
                        <div class="address-contact">Địa chỉ : {{$address->description}}, {{$address->ward->name}}, {{$address->district->name}}, {{$address->province->name}}, Việt Nam</div>
                        <div class="phone-contact">Số điện thoại : {{$address->phone}}</div>
                        <div>
                            <form action="{{ route('checkout.payment') }}" method="POST">
                            @csrf
                                <input type="hidden" value="{{ $address->id }}" name="address_id">
                                <button type="submit" class="btn-chose-address">Giao đến địa chỉ này</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="add-address-cart">
                <p class="other">
                    Bạn muốn giao hàng đến địa chỉ khác?
                    <a href="#" id="addNewAddress" data-toggle="modal" data-target="#AdressCart">
                        Thêm địa chỉ giao hàng mới
                    </a>
                </p>
            </div>
        </div>
    </section>


    <!-- Modal -->
    <div class="modal fade" id="AdressCart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('client.choseAddress.store') }}" method="POST">
            @csrf
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm mới địa chỉ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group address-model">
                            <label for="name">Tên người nhận</label>
                            <input type="text" class="form-control hei-address"  name="name" value="{{ old('name') }}" value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">
                                    <span class="mess-error"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</span>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group address-model">
                            <label for="number">Sđt người nhận</label>
                            <input type="number" class="form-control hei-address" name="phone" value="{{ old('phone') }}">
                            @error('phone')
                                <span class="text-danger">
                                    <span class="mess-error"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</span>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group address-model">
                            <label for="province">Tỉnh / Thành Phố</label>
                            <select id="province_id" class="form-control hei-address" name="province_id">
                                <option value="">Vui lòng chọn thành phố</option>
                                @foreach ($provinces as $province)
                                <option value="{{ $province->id }}">{{ $province->name }}</option>
                                @endforeach
                            </select>
                            @error('province_id')
                            <span class="text-danger">
                                <span class="mess-error"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</span>
                            </span>
                        @enderror
                        </div>
                        <div class="form-group address-model">
                            <label for="district_id">Quận huyện</label>
                            <select id="district_id" class="form-control hei-address" name="district_id">
                            </select>
                            @error('district_id')
                                <span class="text-danger">
                                    <span class="mess-error"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</span>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group address-model">
                            <label for="ward_id">Phường xã</label>
                            <select id="ward_id" class="form-control hei-address" name="ward_id">
                            </select>
                            @error('ward_id')
                                <span class="text-danger">
                                    <span class="mess-error"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</span>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group address-model">
                            <label for="description">Địa chỉ chi tiết</label>
                            <input type="text" class="form-control hei-address" name="description" value="{{ old('description') }}">
                            @error('description')
                                <span class="text-danger">
                                    <span class="mess-error"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</span>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary btn-address-model">Thêm mới</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


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

@if (session()->has('showModal'))
<script>
$(function () {
    const modalId = {{ session()->get('showModal') }}
    $(modalId).modal('show')
})
</script>
@endif

@endsection
