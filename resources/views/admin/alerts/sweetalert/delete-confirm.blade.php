<script>
    $(document).ready(function () {
        var className = '{{$className}}'
        var element = $('.' + className);
        element.on('click', function (e) {
            debugger
            e.preventDefault();
            const swalWithBootstrapButton = Swal.mixin({
                customClass:{
                    confirmButton:'btn btn-success btn-sm mx-2',
                    cancelButton:'btn btn-danger btn-sm mx-2'
                },
                buttonsStyling:false
            });

            swalWithBootstrapButton.fire({
                     title: 'آیا از حذف داده خود مطمن هستید؟',
                        text: "میتوانید درخواست خود را لغو نمایید",
                         icon: 'warning',
                         showCancelButton: true,
                        confirmButtonText: 'بله - داده حذف شود',
                        cancelButtonText: 'خیر - درخواست لغو شود',
                        reverseButtons: true
                        }).then((result) => {

                            if(result.value == true){
                                $(this).parent().submit();
                            }
                            else if(result.dismiss === Swal.DismissReason.cancel){
                                swalWithBootstrapButton.fire({
                                         title: 'لغو درخواست',
                                         text: "درخواست شما لغو شد",
                                        icon: 'error',
                                       confirmButtonText: 'باشه'
                                })
                            }
                        })
        })
    })
</script>