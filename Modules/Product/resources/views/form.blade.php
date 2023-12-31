@csrf
<div class="row">
    <div class="col-md-8 border-right">

        <div class="form-group">
            <label class="bmd-label-floating">Hình ảnh chính</label>
            <div class="avatar-wrapper">
                <img class="profile-pic" src="@if(!empty($product)) {{$product->getFirstMediaUrl('product')}} @endif" />
                <div class="upload-button">
                </div>
                <input class="file-upload" type="file" name="image" accept="image/*"/>
            </div>
        </div>

        <div class="form-group">
            <label for="exampleInputName1">Tên sản phẩm *</label>
            <input type="text" class="form-control" name="name" value="{{ old('name', $product->name ?? '') }}" placeholder="Nhập tên sản phẩm ...">
            @error('name') <span class="text-danger">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label class="bmd-label-floating">Hình ảnh bìa minh họa</label>
            <input id="input-b1" name="srcs[]" multiple type="file" class="file"  data-show-upload="false" data-browse-on-zone-click="true" data-max-file-count="8">
        </div>

        @if(!empty($product))
            <div class="flex-srcs">
                @foreach($product->getMedia('products') as $media)
                    <img class="img-srcs-pro" src="{{ ($media->getUrl()) }}">
                @endforeach
            </div>
        @endif

        <div class="form-group">
            <label class="bmd-label-floating">Mô tả sản phẩm (*)</label>
            <textarea name="content"
                class="form-control my-editor">{!! old('content', $product->content ?? '') !!}</textarea>
            @error('content')
            <span class="text-danger">
                <span class="mess-error"><i class="fas fa-exclamation-triangle"></i>
                    {{ $message }}
                </span>
            </span>
            @enderror
        </div>

    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label class="bmd-label-floating">Danh mục chính (*)</label>
            <select id="category_id" class="form-control" name="category_id">
                <option value="">Chọn danh mục chính</option>
                @foreach($categories as $category)
                <option {{ old('category_id', $product->category_id ?? '') ==
                    $category->id? 'selected' : '' }}
                    value="{{$category->id}}">
                    {{$category->name}}
                </option>
                @endforeach
            </select>
            @error('category_id')
            <span class="text-danger">
                <span class="mess-error"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</span>
            </span>
            @enderror
        </div>
        <div class="form-group">
            <label class="bmd-label-floating">Danh mục phụ (*)</label>
            <select id="sub_category_id" class="form-control" name="sub_category_id"
                data-old="{{ old('sub_category_id', $product->sub_category_id ?? '') }}">
            </select>
        </div>

        <div class="form-group ">
            <label class="bmd-label-floating">Giá sản phẩm (*)</label>
            <input type="number" name="price" value="{{ old('price', $product->price ?? '') }}"
                class="form-control">
            @error('price')
            <span class="text-danger">
                <span class="mess-error"><i class="fas fa-exclamation-triangle"></i> {{ $message
                    }}</span>
            </span>
            @enderror
        </div>

        <div class="form-group ">
            <label class="bmd-label-floating">Giá tham chiếu</label>
            <input type="number" name="comparative_price" value="{{ old('comparative_price', $product->comparative_price ?? '') }}"
                class="form-control">
            @error('comparative_price')
            <span class="text-danger">
                <span class="mess-error"><i class="fas fa-exclamation-triangle"></i> {{ $message
                    }}</span>
            </span>
            @enderror
        </div>

        <div class="form-group ">
            <label class="bmd-label-floating">Số lượng sản phẩm (*)</label>
            <input type="number" name="quantity" value="{{ old('quantity', $product->quantity ?? '') }}"
                class="form-control">
            @error('quantity')
            <span class="text-danger">
                <span class="mess-error"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</span>
            </span>
            @enderror
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
    </div>
</div>

@include('product::variants', ['product' => $product ?? null])
@php
    $sub_categories = $categories->mapWithKeys(function ($item) {
    $item->sub_categories = $item->sub_categories->mapWithKeys(function ($category_item) {
    return [$category_item['id'] => $category_item];
    });
    return [$item['id'] => $item['sub_categories']];
    });
@endphp
@section('js')
<script>
    var sub_categories = {!! json_encode($sub_categories->toArray()) !!};

    writeCategoryItems();

    $('#category_id').change(function () {
        writeCategoryItems();
    });

    function writeCategoryItems(){
        $idCategory = $('#category_id').val();
        $idCategoryItem = $('#sub_category_id').val() || $('#sub_category_id').data('old');
        $('#sub_category_id').empty();
        if(!$idCategory){
            return;
        }

        $sub_categories = sub_categories[$idCategory] || {};
        $.each($sub_categories, (idx, category_item) => {
            var $selected = "";
            if($idCategoryItem == category_item.id){
                $selected = "selected";
                $('#sub_category_id').data('old', null);
            }
            let html = `<option value="${category_item.id}" ${$selected}>${category_item.name}</option>`;
            $('#sub_category_id').append(html);
        });
    }

</script>
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
