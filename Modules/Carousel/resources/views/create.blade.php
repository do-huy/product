@extends('admin.master')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Thêm mới carousel / banner</h4>
                    <form class="forms-sample" method="POST" enctype="multipart/form-data" action="{{ route('carousel.store') }}">
                        @csrf
                        <div class="form-group">
                            <label class="bmd-label-floating">Hình ảnh</label>
                            <div class="avatar-wrapper">
                                <img class="profile-pic" src="" />
                                <div class="upload-button">
                                    {{-- <i class="fa fa-arrow-circle-up" aria-hidden="true"></i> --}}
                                </div>
                                <input class="file-upload" type="file" name="image" accept="image/*"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputName1">Tiêu đề carousel / banner</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" id="exampleInputName1" placeholder="Nhập tên tiêu đề ...">
                            @error('name') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group ">
                            <label class="bmd-label-floating">Link (*)</label>
                            <input type="text" name="link" value="{{ old('link') }}" class="form-control" placeholder="Nhập liên kết carousel / banner ...">
                            @error('link') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label class="bmd-label-floating">Mô tả sản phẩm (*)</label>
                            <textarea name="description"
                                class="form-control my-editor">{!! old('description') !!}
                            </textarea>
                            @error('description')
                            <span class="text-danger">
                                <span class="mess-error"><i class="fas fa-exclamation-triangle"></i>
                                    {{ $message }}
                                </span>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group ">
                            <label class="bmd-label-floating">Trạng thái:</label>
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
