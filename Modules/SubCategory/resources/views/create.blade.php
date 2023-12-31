@extends('admin.master')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Thêm mới danh mục phụ</h4>
                    <form class="forms-sample" method="POST" action="{{ route('subCategory.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputName1">Tên danh mục phụ *</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Nhập tên danh mục ...">
                            @error('name') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label class="bmd-label-floating">Danh mục chính (*)</label>
                            <select id="category_id" class="form-control" name="category_id">
                                <option value="">Vui lòng chọn danh mục chính</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{$category->name}}</option>
                                @endforeach
                            </select>
                            @error('category_id') <span class="text-danger">{{ $message }}</span>@enderror
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

