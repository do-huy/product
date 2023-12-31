@extends('admin.master')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Cập nhập danh mục</h4>
                    <form class="forms-sample" method="POST" enctype="multipart/form-data" action="{{ route('category.update', [$category->id]) }}">
                        @csrf
                        @method('PUT')
                        <div style="display: none" class="form-group">
                            <input type="text" name="id" value="{{ $category->id }}" class="form-control" id="exampleInputEmail1" >
                        </div>
                        <div class="form-group">
                            <label class="bmd-label-floating">Hình ảnh</label>
                            <div class="avatar-wrapper">
                                <img class="profile-pic" src="{{ $category->getFirstMediaUrl('category')  ?: asset('admin/images/no-image.png') }}" />
                                <div class="upload-button">
                                    {{-- <i class="fa fa-arrow-circle-up" aria-hidden="true"></i> --}}
                                </div>
                                <input class="file-upload" type="file" name="image" accept="image/*"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputName1">Tên danh mục *</label>
                            <input type="text" class="form-control" name="name" value="{{ $category->name }}" placeholder="Nhập tên danh mục ...">
                            @error('name') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group ">
                            <label for="exampleInputPassword4">Trạng thái</label>
                            <select name="status" class="form-control">
                                <option value="1" {{ $category->status == 1 ? 'selected' : '' }}>
                                    Hoạt động
                                </option>
                                <option value="0" {{ $category->status == 0 ? 'selected' : '' }}>
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
@section('js')
<script>
    $(document).ready(function() {

        var readURL = function(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.profile-pic').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $(".file-upload").on('change', function(){
            readURL(this);
        });

        $(".upload-button").on('click', function() {
        $(".file-upload").click();
        });
    });
</script>
@endsection
