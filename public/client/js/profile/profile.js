//update profile account
$(function () {
    $(document).ready(function() {
        $('#submit-update-profile').click(function () {

            $('#update-account .text-danger').empty();
            const formData = new FormData();
            formData.append('name', $('#name').val());
            formData.append('seller_name', $('#seller_name').val());

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                url: $("#update-account").data("update-profile-route"),
                data: formData,
                contentType: false,
                processData: false,
                success: function(response){
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công',
                        text: 'Cập nhập thông tin thành công.',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    if(response.success){
                        setTimeout(function() {
                            $("#load-page-ajax").load("#load-page-ajax");
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
});


