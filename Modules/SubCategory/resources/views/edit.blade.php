@extends('admin.master')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Cập nhập danh mục phụ</h4>
                    <form class="forms-sample" method="POST" action="{{ route('subCategory.update',[$subCategory->id]) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="exampleInputName1">Tên danh mục phụ *</label>
                            <input type="text" class="form-control" name="name" value="{{ $subCategory->name }}" placeholder="Nhập tên danh mục phụ ...">
                            @error('name') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label class="bmd-label-floating">Danh mục chính (*)</label>
                            <select id="category_id" class="form-control" name="category_id">
                                @foreach($categories as $category)
                                    <option {{$subCategory->category_id == $category->id?'selected':''}} value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                            @error('category_id') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group ">
                            <label for="exampleInputPassword4">Trạng thái</label>
                            <select name="status" class="form-control">
                                <option value="1" {{ $subCategory->status == 1 ? 'selected' : '' }}>
                                    Hoạt động
                                </option>
                                <option value="0" {{ $subCategory->status == 0 ? 'selected' : '' }}>
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

