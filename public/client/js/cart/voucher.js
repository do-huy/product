const voucherStore = {
    sellerId: null,
    cartId: null
};
$(function () {
    $('.open-voucher-modal').on('click', function () {
        // Hiển thị modal
        const modal$ = $('#voucher-modal');
        voucherStore.sellerId = $(this).data('seller-id');
        voucherStore.cartId = $(this).data('cart-id');

        $('.voucher-search .message-error').addClass('d-none');
        $('.voucher-search input').val('')
        $('.voucher-search button').attr('disabled', 'disabled')

        modal$.show();
        loadVoucherData();
        // Di chuyển modal đến ngay dưới nút
        modal$.css({
            top: $(this).position().top + $(this).outerHeight() + 'px',
            left: $(this).position().left + 'px',
            position: 'absolute'
        });

        $('.modal-title', modal$).html(voucherStore.sellerId ? 'Shop voucher' : 'Sene voucher')
    });

    $('.close').on('click', function () {
        // Đóng modal
        $('#voucher-modal').hide();
    });

    $('.voucher-search input').on('input', function () {
        if ($(this).val().length > 0) {
            $('.voucher-search button').removeAttr('disabled')
        } else {
            hideSearchVoucherError();
            loadVoucherData();
            $('.voucher-search button').attr('disabled', 'disabled')
        }
    })

    $('.voucher-search button').on('click', function () {
        const regex = new RegExp(/^[a-zA-Z0-9]+$/)
        const code = $('.voucher-search input').val();
        if (!regex.test(code)) {
            return showSearchVoucherError('Mã giảm giá sai định dạng')
        }

        showSearchVoucher(code)
    });

    $('body').on('click', '.select-voucher', function () {
        $('#voucher-modal').hide();
        const cartId = voucherStore.cartId;
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            method: 'POST',
            url: cartId ? ADD_VOUCHER_URL.replace(':id', cartId) : ADD_VOUCHER_ALL_URL,
            data: {
                code: $(this).data('code')
            },
            success: function (response) {
                handleAddVoucherResponse(response.carts, response.voucher)
                updateTotalCart(response.user_amount, response.user_total)
            },
            error: handleCartError
        })
    })

    $('body').on('click', '.remove-voucher', function () {
        const cartId = $(this).data('cart-id');
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            method: 'POST',
            url: REMOVE_VOUCHER_URL,
            data: {
                cart_id: cartId
            },
            success: function (response) {
                handleRemoveVoucherResponse(response?.cart)
                updateTotalCart(response.user_amount, response.user_total)
            },
            error: handleCartError
        })
    })
})

const handleAddVoucherResponse = (carts, voucher = null) => {
    carts.forEach(cart => {
        if (!voucher) {
            handleRemoveVoucherResponse(cart);

            // continue
            return;
        }

        if (voucher?.use_for == 1) {
            $('#platform-voucher-text').removeClass('d-none');
            $('#platform-voucher-text span.voucher-text').html(voucher.name);
        } else {
            $(`#voucher-cart-id-${cart.id}`).removeClass('d-none');
            $(`#voucher-cart-id-${cart.id}`).html(`<span class="voucher-text">${cart.seller_voucher.name}(-${formatNumber(cart.seller_discount_tmp)}₫)</span>
            <span class="material-icons-sharp remove-voucher" data-cart-id="${cart.id}">cancel</span>`)
        }
    })
}

const handleRemoveVoucherResponse = (cart) => {
    if (!cart) {
        $('#platform-voucher-text').addClass('d-none');
        $('#platform-voucher-text span.voucher-text').html('');
    } else {
        $(`#voucher-cart-id-${cart.id}`).addClass('d-none');
        $(`#voucher-cart-id-${cart.id}`).html(``)
    }
}

const showSearchVoucher = (code) => {
    $('#voucher-modal .voucher-list').empty();
    const sellerId = voucherStore.sellerId;
    $.ajax({
        url: `${GET_DETAIL_VOUCHER_URL.replace(':code', code)}${sellerId ? `?seller_id=${sellerId}` : ''}`,
        method: 'GET',
        success: function (response) {
            renderVoucherList(response?.data ? [response.data] : [])
        }
    })
}

const loadVoucherData = () => {
    const sellerId = voucherStore.sellerId;
    $('#voucher-modal .voucher-list').empty();
    $.ajax({
        url: `${GET_VOUCHER_URL}${sellerId ? `?seller_id=${sellerId}` : ''}`,
        method: 'GET',
        success: function (response) {
            renderVoucherList(response?.data)
        }
    })
}

const renderVoucherList = (vouchers) => {
    const voucherList$ = $('#voucher-modal .voucher-list')
    if (!vouchers || !vouchers.length) {
        voucherList$.html('<div class="text-center">Không có mã giảm giá</div>');
        return;
    }

    voucherList$.html(
        vouchers.map(voucher => `<div class="item">
                <div class="img-item">
                    <img class="size" height="70px" src="${voucher?.media[0]?.original_url || NO_IMAGE}" alt=""
                        onerror="this.src=\`${NO_IMAGE}\`">
                </div>
                <div class="des-item">
                    <div>${voucher.name}</div>
                    <div>Giảm ${formatNumber(voucher.discount_amount)}${VOUCHER_TYPE[voucher.type]}</div>
                    ${VOUCHER_TYPE[voucher.type] == '%' && voucher.max_discount_amount ? `<div>Giảm tối đa ${formatNumber(voucher.max_discount_amount)}₫</div>` : ''}
                    ${voucher.min_order_amount ? `<div>Đơn tối thiểu: ${formatNumber(voucher.min_order_amount)}₫</div>` : ''}
                    <div>HSD: ${moment(`${voucher.expire_at}Z`).locale('vi').fromNow()}</div>
                </div>
                <div class="save-item">
                    <button class="select-voucher" ${voucher.can_apply_now ? '' : 'disabled'} data-code="${voucher.code}">Chọn</button>
                </div>
            </div>`)
    );
}

const formatNumber = (number) => Number(number).toLocaleString('en-US', { maximumFractionDigits: 2 })

const showSearchVoucherError = (error) => {
    $('.voucher-search .message-error').html(error);
    $('.voucher-search .message-error').removeClass('d-none');
}

const hideSearchVoucherError = () => {
    $('.voucher-search .message-error').html('');
    $('.voucher-search .message-error').addClass('d-none');
}
