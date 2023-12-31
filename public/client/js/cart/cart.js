$(function () {
    // This function will be called when the `.add-cart-product` button is clicked.
    $('.add-cart-product').on('click', function (event) {
        // Prevent the default action of the button, which is to reload the page.
        event.preventDefault();

        // Get the data from the form.
        // const data = $('#create-cart').serializeArray();
        const product_id = $(this).data('id');
        var amount = parseInt($('#amount-product-input').val());
        var product_item_id = $('#product-item-id').val();

        if (!product_item_id && PRODUCT_ITEMS.length) {
            return showError('Hãy chọn phân loại sản phẩm.');
        }

        // Make an AJAX request to add the product to the cart.
        $.ajax({
            type: 'POST',
            url: '/add-to-cart',
            data: {
                amount: Number(amount),
                product_id: Number(product_id),
                product_item_id: product_item_id ? Number(product_item_id) : null,
            },
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            // This function will be called when the request is successful.
            success: function (response) {
                const amount = response.data.user_amount;
                $('.cart-item-count').text(amount)
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công',
                    text: "Thêm giỏ hàng thành công.",
                    showConfirmButton: false,
                    timer: 2000
                });
            },
            // This function will be called when the request fails.
            error: handleCartError
        });
    });

    //Up or Down Cart Product
    var oldTime = 0;
    $(document).on('click', '.control-cart', function (event) {
        let cart_product = $(this).parents('.grid-item-pro');
        let amount = cart_product.find('.cart-item-amount').text();

        if ($(this).data('can-update-item') == 0) {
            return;
        }

        if (($(this).text() == '-' && amount <= 1)) {
            if (amount == 1) {
                $('.destroy-cart', cart_product).click();
            }
            return false;
        }

        let newTime = Date.now();
        let route = $(this).attr('send_to');

        if (newTime - oldTime > 1000) {
            $.ajax({
                type: "POST",
                url: route,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function (response) {
                    total = parseInt(response.total).toLocaleString();
                    amount = parseInt(response.amount).toLocaleString();
                    cart_product.find('.cart-item-total').text(total);
                    cart_product.find('.cart-item-amount').text(amount);
                    updateTotalCart(response.user_amount, response.user_total)

                    if (response?.cart) {
                        handleAddVoucherResponse([response.cart])
                    }
                },
                error: handleCartError
            });
            oldTime = newTime;
        }
        return false;
    });

    // Delete Product Cart
    $(document).on('click', '.destroy-cart-btn', function (event) {
        event.preventDefault();
        var id_cart_product = $(this).data("id");
        Swal.fire({
            title: 'Bạn có chắc?',
            text: "Muốn xóa sản phẩm.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Đồng ý.',
            cancelButtonText: 'Hủy.',
        })
            .then((willDelete) => {
                if (willDelete.isConfirmed) {
                    let url  = $("#urlDelteCart").attr("data-url");
                    url = url.replace(":id", this.getAttribute("data-id"));
                    $.ajax({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        type: "DELETE",
                        url: url,
                        // url: xoa-gio-hang/id_cart_product,
                        dataType: "json",
                        success: function (response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công',
                                text: "Xóa sản phẩm thành công.",
                                showConfirmButton: false,
                                timer: 2000
                            })
                            if (response.success) {
                                setTimeout(function () {
                                    window.location.reload();
                                    // $("#load-page-ajax").load("#load-page-ajax");
                                }, 2000);
                            }
                        },
                    });
                }
            });
    });

    $(document).on('change', '.select-cart-item', function () {
        const $this = $(this);
        $.ajax({
            url: $this.data('url-change-selected'),
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                cart_item_id: $this.data('cart-item-id'),
                is_selected: Number($this.is(":checked"))
            },
            success: function (response) {
                updateTotalCart(response.user_amount, response.user_total)
                handleSelectSellerItems()
            },
            error: function (error) {
                $this.prop('checked', !$this.is(":checked"))
                handleCartError(error, () => window.location.reload());
            }
        })
    })

    $('.select-all-seller').on('change', function () {
        $('.select-cart-item').prop('checked', $(this).is(":checked"));
        $('.select-cart-item').trigger('change');
    })

    $('.div-item-pro').each(function () {
        const $this = $(this);
        $('.div-store > input[type="checkbox"]', $this).on('change', function () {
            $('.select-cart-item', $this).prop('checked', $(this).is(":checked"));
            $('.select-cart-item', $this).trigger('change');
        });
    });

    handleSelectSellerItems();
});

const updateTotalCart = (user_amount, user_total) => {
    $('.number-product-cart').text(parseInt(user_amount).toLocaleString());
    $('#cart-total-all').text(parseInt(user_total).toLocaleString());
    if (user_amount) {
        $('#to-order').prop('disabled', false)
    } else {
        $('#to-order').prop('disabled', false)
    }

}

const handleSelectSellerItems = () => {
    let allSelected = true;
    $('.div-item-pro').each(function () {
        let sellerSelected = true;
        $('.select-cart-item', $(this)).each(function () {
            if (!$(this).is(":checked")) {
                sellerSelected = false;
                allSelected = false;
                return false;
            }
        })

        $('.div-store > input[type="checkbox"]', $(this)).prop('checked', sellerSelected && $('.select-cart-item', $(this)).length);
    })

    $('.select-all-seller').prop('checked', allSelected && $('.select-cart-item').length)
}
