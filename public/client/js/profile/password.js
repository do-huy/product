$(function (){
    $('#submit-update-password').click(function(event) {
        event.preventDefault();
        $('#update-account .text-danger').empty();
        $.ajax({
            type:'PUT',
            url: $("#update-account").data("update-profile-password-route"),
            data: $('#update-account').serializeArray(),
            dataType: "json",
            success: function(response){
                Swal.fire({
                icon: 'success',
                title: 'Thành công',
                text: "Cập nhập mật khẩu thành công.",
                showConfirmButton: false,
                timer: 2000
                });
                window.location.replace('/login');
            },
            error: function(response){
                const errors = response?.responseJSON?.errors || {}
                Object.keys(errors).forEach((field) => {
                    $(`#err-${field}`).html(`<span class="mess-error">
                                    <i class="fas fa-exclamation-triangle"></i> ${errors[field][0]}
                                </span>`);
                })
            },
        });
    });
})
