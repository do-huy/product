//Xóa địa chỉ / profile
$(function () {
    $('.btn-del-address').click(function (event) {
        event.preventDefault();
        var id_address = $(this).data('id');
        Swal.fire({
            title: 'Bạn có chắc?',
            text: "Muốn xóa địa chỉ.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Đồng ý',
            cancelButtonText: 'Hủy',
        })
        .then((willDelete) => {
            if(willDelete.isConfirmed){
                var data = {
                    "id": id_address,
                };
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type:'DELETE',
                    url: $("#data").data("profile-destroy-address-route"),
                    data: data,
                    dataType:'json',
                    success: function(response){
                        Swal.fire({
                             icon: 'success',
                             title: 'Thành công',
                             text: "Xóa địa chỉ thành công.",
                             showConfirmButton: false,
                             timer: 2000
                         })
                        if(response.success){
                            setTimeout(function() {
                                $("#load-page-ajax").load("#load-page-ajax");
                            }, 2000);
                        }
                    }
                });
            }
        });
    });
});

//Thêm địa chỉ / profile
$(function () {
    $('#submit-store-address').click(function(e) {

        e.preventDefault();
        $('#form-address .text-danger').empty();

        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "POST",
            // url: route('client.address.store'),
            url: $("#form-address").data("profile-store-address-route"),
            data: $('#form-address').serializeArray(),
            dataType: "json",
            success: function(response){
                Swal.fire({
                icon: 'success',
                title: 'Thành công',
                text: "Cập nhập địa chỉ thành công.",
                showConfirmButton: false,
                timer: 2000
                })
                if(response.success){ // if true (1)
                    setTimeout(function(){// wait for 5 secs(2)
                        window.location.href = "/dia-chi";
                    }, 2000);
                }
            },
            error: function(response){
                const errors = response?.responseJSON?.errors || {}
                Object.keys(errors).forEach((field) => {
                    $(`#err-${field}`).html(`<span class="mess-error">
                                    <i class="fas fa-exclamation-triangle"></i> ${errors[field][0]}
                                </span>`);
                })
            }
        });
    });
});

//Cập nhập địa chỉ / profile
$(function () {
    $('#submit-update-address').click(function (e) {

        e.preventDefault();
        $('#update-address .text-danger').empty();
        var slug_address = $(this).data('slug');


        $.ajax({
            type: "PUT",
            // url: route('client.address.update', {slug: slug_address}),
            url: $("#update-address").data("profile-update-address-route"),
            data: $('#update-address').serializeArray(),
            dataType: "json",
            success: function(response){
                Swal.fire({
                icon: 'success',
                title: 'Thành công',
                text: "Cập nhập địa chỉ thành công.",
                showConfirmButton: false,
                timer: 2000
                })
                if(response.success){ // if true (1)
                    setTimeout(function(){// wait for 5 secs(2)
                        window.location.href = "/dia-chi";
                    }, 2000);
                }
            },
            error: function(response){
                const errors = response?.responseJSON?.errors || {}
                Object.keys(errors).forEach((field) => {
                    $(`#err-${field}`).html(`<span class="mess-error">
                                    <i class="fas fa-exclamation-triangle"></i> ${errors[field][0]}
                                </span>`);
                })
            }
        });
    })
});
