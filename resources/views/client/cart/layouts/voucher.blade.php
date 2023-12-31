@php
use Modules\Voucher\app\Models\Voucher;
@endphp
<div class="modal-container" id="voucher-modal">
    <div class="modal-header">
        <h5 class="modal-title">Shop voucher </h5>
        <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="voucher mb-3 mt-2 voucher-search">
            <span>Mã voucher</span>
            <input type="text" value="">
            <button type="button" disabled>Áp dụng</button>
            <div class="message-error">Không tìm thấy voucher</div>
        </div>
        <div class="voucher-list">
        </div>

    </div>

</div>
@push('js')
<script>
    const GET_VOUCHER_URL = `{{ route('client.vouchers.index') }}`;
    const GET_DETAIL_VOUCHER_URL = `{{ route('client.vouchers.detail', ['code' => ':code']) }}`;
    const ADD_VOUCHER_URL = `{{ route('cart.voucher', ['id' => ':id']) }}`;
    const ADD_VOUCHER_ALL_URL = `{{ route('cart.voucher.all') }}`;
    const REMOVE_VOUCHER_URL = `{{ route('cart.voucher.remove') }}`
    const NO_IMAGE = `{{ asset('images/no-image.png') }}`
    const VOUCHER_TYPE = {
        {{Voucher::TYPE_PERCENT}}: '%',
        {{Voucher::TYPE_FIX}}: '₫'
    }
</script>
<script src="{{ asset('vendor/moment/moment.min.js') }}"></script>
<script src="{{ asset('vendor/moment/moment-with-locales.min.js') }}"></script>
<script src="{{ asset('client/js/cart/voucher.js') }}"></script>
@endpush
