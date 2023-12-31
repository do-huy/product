@extends('admin.master')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Cập nhập sản phẩm</h4>
                    <form class="forms-sample" id="product-form" method="POST" enctype="multipart/form-data" action="{{ route('product.update', [$product->slug]) }}">
                        @method('PUT')
                        @include('product::form', $product)
                        <button type="submit" class="btn btn-primary mr-2 btn-product">Cập nhập</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
  </div>
@endsection

