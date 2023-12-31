@extends('admin.master')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Thêm mới tài khoản</h4>
                    <form class="forms-sample" method="POST" enctype="multipart/form-data" action="{{ route('user.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputName1">Tên tài khoản *</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Nhập tên tài khoản ...">
                            @error('name') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail3">Email*</label>
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Nhâp email ...">
                            @error('email') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail3">Số điện thoại *</label>
                            <input type="number" class="form-control" name="phone" value="{{ old('phone') }}" placeholder="Nhâp số điện thoại ...">
                            @error('phone') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword4">Mật khẩu *</label>
                            <input type="password" class="form-control"  name="password" value="{{ old('password') }}" placeholder="Nhập mât khẩu ...">
                            @error('password') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword4">Nhập lai mật khẩu *</label>
                            <input type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}" placeholder="Nhâp lại mật khẩu ...">
                            @error('password_confirmation') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group ">
                            <label for="exampleInputPassword4">Trạng thái</label>
                            <select name="status" class="form-control">
                                <option value="1" >
                                    Hoạt động
                                </option>
                                <option value="0" >
                                    Không hoạt động
                                </option>
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Thêm mới</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
  </div>
@endsection
