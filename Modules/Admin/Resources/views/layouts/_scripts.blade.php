<script src="{{ Module::asset('admin:plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ Module::asset('admin:plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ Module::asset('admin:plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
<script src="{{ Module::asset('admin:js/adminlte.min.js') }}"></script>
@stack('scripts')
<script>
    $(document).ready(function () {
        //option A
        $("button[data-ask=1]").click(function (e, params) {
            let localParams = params || {};
            if (!localParams.send) {
                e.preventDefault();
            }
            let button = this;

            Swal.fire({
                title: $(button).data('title'),
                text: $(button).data('message'),
                icon: $(this).data('type') ? $(this).data('type') : 'warning',
                input: $(this).data('input') ? $(this).data('input') : false,
                showCancelButton: true,
                confirmButtonColor: $(this).data('confirm-button-color') ? $(this).data('confirm-button-color') : "#1e88e5",
                confirmButtonText: $(this).data('confirm-button-text') ? $(this).data('confirm-button-text') : 'Confirm',
                cancelButtonColor: $(this).data('cancel-button-color') ? $(this).data('cancel-button-color') : "grey",
                cancelButtonText: $(this).data('cancel-button-text') ? $(this).data('cancel-button-text') : 'Cancel',
                // closeOnConfirm: false,
                // closeOnCancel: false,
                showLoaderOnConfirm: true,
                preConfirm: function (amount) {
                    if (amount && $(this).data('form-id')) {

                        let formId = $(this).data('form-id');
                        let inputName = $(this).data('input-name');
                        $('#' + formId + ' input[name = ' + inputName + ']').val(amount);
                    }
                    $(this).trigger('click', {send: true});
                },
                // allowOutsideClick: () => !swal.isLoading()
            }).then((results) => {
                if (results.isConfirmed) {
                    $(`#${$(button).data('form-id')}`).submit()
                }
            });
        });
    });

</script>
