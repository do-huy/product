@extends('admin.master')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Thêm mới sản phẩm</h4>
                    <form class="product-form" id="product-form" method="POST" enctype="multipart/form-data" action="{{ route('product.store') }}">
                        @include('product::form')
                        <button type="submit" class="btn btn-primary mr-2 btn-product">Thêm mới</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
  </div>
@endsection

