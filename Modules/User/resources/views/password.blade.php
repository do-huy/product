@extends('admin.master')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Cập nhập mật khẩu</h4>
                    <p class="card-description">
                        <code>{{ $user->name }}</code> Thuộc số điện thoại <code>{{ $user->phone }}</code>.
                    </p>
                    <form class="forms-sample" method="POST" enctype="multipart/form-data" action="{{ route('user.update.pasword',[$user->id]) }}">
                        @csrf
                        @method('PUT')
                        <div style="display: none" class="form-group">
                            <input type="text" name="id" value="{{ $user->id }}" class="form-control" id="exampleInputEmail1" >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName1">Mật khẩu *</label>
                            <input type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Nhập mật khẩu ...">
                            @error('password') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail3">Nhập lại mật khẩu*</label>
                            <input type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}" placeholder="Nhập lại mật khẩu ...">
                            @error('password_confirmation') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                        <button type="submit" class="btn btn-primary mr-2">Cập nhập</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
  </div>
@endsection
