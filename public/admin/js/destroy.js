function actionDelete(event){
    event.preventDefault();
    let urlRequest = $(this).data('url');
    let that = $(this);
    Swal.fire({
        title: 'Bạn có chắc?',
        text: "Muốn xóa.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Đồng ý.',
        cancelButtonText: 'Hủy.',
    }).then((result) => {
        if(result.value){
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'DELETE',
                url:urlRequest,
                success:function(data){
                    if(data.code == 200){
                        that.parent().parent().remove();
                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công',
                            text: "Xóa thành công.",
                            showConfirmButton: true,
                            timer: 2000
                        })
                    }
                },
                error:function(){

                }
            });
        }
    })
}
$(function () {
    $(document).on('click', '.action-delete', actionDelete);
});
