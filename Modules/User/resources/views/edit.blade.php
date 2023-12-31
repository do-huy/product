@extends('admin.master')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Thêm mới tài khoản</h4>
                    <form class="forms-sample" method="POST" enctype="multipart/form-data" action="{{ route('user.update', [ $user->id ]) }}">
                        @csrf
                        @method('PUT')

                        <div style="display: none" class="form-group">
                            <input type="text" name="id" value="{{ $user->id }}" class="form-control" id="exampleInputEmail1" >
                        </div>

                        <div class="form-group">
                            <label for="exampleInputName1">Tên tài khoản *</label>
                            <input type="text" class="form-control" name="name" value="{{ $user->name }}" placeholder="Nhập tên tài khoản ...">
                            @error('name') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail3">Email*</label>
                            <input type="email" class="form-control" name="email" value="{{ $user->email }}" placeholder="Nhâp email ...">
                            @error('email') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail3">Số điện thoại *</label>
                            <input type="number" class="form-control" name="phone" value="{{ $user->phone }}" placeholder="Nhâp số điện thoại ...">
                            @error('phone') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group ">
                            <label for="exampleInputPassword4">Trạng thái</label>
                            <select name="status" class="form-control">
                                <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>
                                    Hoạt động
                                </option>
                                <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>
                                    Không hoạt động
                                </option>
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Cập nhập</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
  </div>
@endsection
