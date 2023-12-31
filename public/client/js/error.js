var ERROR_CODE = {
    COMMON_ERROR: 1000,
    PRODUCT_NOT_EXISTS: 1001,
    PRODUCT_NOT_ENOUGH: 1002,
    CART_ITEM_NOT_EXISTS: 1003,
    CART_NOT_EXISTS: 1004,
    VOUCHER_UNAVAILABLE: 1005,
    VOUCHER_CANNOT_APPLY_FOR_SELLER: 1006,
    VOUCHER_WAS_MAXIMUM_TO_USE: 1007,
    CART_NOT_ENOUGH_TO_USE_VOUCHER: 1008,
    VOUCHER_CANNOT_APPLY_FOR_ANY_CART: 1009,
    VOUCHER_CANNOT_APPLY_FOR_ALL_SELLER: 1010,
}

var MAP_CODE_TO_ERROR = {
    [ERROR_CODE.COMMON_ERROR]: 'Lỗi không xác định.',
    [ERROR_CODE.PRODUCT_NOT_EXISTS]: 'Sản phẩm không tồn tại hoặc đã bị thay đổi.',
    [ERROR_CODE.PRODUCT_NOT_ENOUGH]: 'Số lượng sản phẩm trên hệ thống không đủ.',
    [ERROR_CODE.CART_ITEM_NOT_EXISTS]: 'Không thể chọn sản phẩm không tồn tại trong giỏ hàng.',
    [ERROR_CODE.CART_NOT_EXISTS]: 'Giỏ hàng không tồn tại.',
    [ERROR_CODE.VOUCHER_UNAVAILABLE]: 'Mã giảm giá không thể sử dụng.',
    [ERROR_CODE.VOUCHER_CANNOT_APPLY_FOR_SELLER]: 'Mã giảm giá không áp dụng với cửa hàng này.',
    [ERROR_CODE.VOUCHER_WAS_MAXIMUM_TO_USE]: 'Mã giảm giá đã hết.',
    [ERROR_CODE.CART_NOT_ENOUGH_TO_USE_VOUCHER]: 'Giỏ hàng không đủ điều kiện để sử dụng voucher.',
    [ERROR_CODE.VOUCHER_CANNOT_APPLY_FOR_ANY_CART]: 'Không thể sử dụng mã giả giá.',
    [ERROR_CODE.VOUCHER_CANNOT_APPLY_FOR_ALL_SELLER]: 'Mã giảm giá không thể sử dụng cho tất cả cửa hàng.',
}

var showError = (message, callbackError = null) => {
    $('#errors-modal .modal-body').html(message || MAP_CODE_TO_ERROR[ERROR_CODE.COMMON_ERROR])
    $('#errors-modal').modal('show')

    if (typeof callbackError == 'function') {
        $('#errors-modal').on('hide.bs.modal', function () {
            $('.modal-body', $(this)).html('')
            callbackError();
        });
    }
}

var handleCartError = (response, callbackError = null) => {
    const reloadWithCodes = [
        ERROR_CODE.PRODUCT_NOT_ENOUGH,
        ERROR_CODE.CART_ITEM_NOT_EXISTS
    ];
    if (response?.status === 422 && response?.responseJSON?.code) {
        showError(
            MAP_CODE_TO_ERROR[response?.responseJSON?.code],
            callbackError || (reloadWithCodes.includes(response?.responseJSON?.code)
                ? () => window.location.reload()
                : null)
        )
    }
}
