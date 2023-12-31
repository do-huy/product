@extends('admin.master')
@section('content')
<!-- === Admin show and order status table === -->
<section>
    <div class="all-admin my-5 ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="order-list">
                        <p class="order-ac-title">Danh sách danh mục phụ</p>
                        <a class="card-description btn-add-form" href="{{ route('subCategory.create') }}">
                            Thêm mới
                        </a>
                        <div class="data-table-section table-responsive">
                            {{ $dataTable->table() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- === Admin show and order status table end=== -->
@endsection
@section('js')
    {{ $dataTable->scripts() }}
@endsection
