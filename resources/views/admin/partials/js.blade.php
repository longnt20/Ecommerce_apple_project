    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.js') }}"></script>
    <!-- apexcharts -->
    <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Vector map-->
    <script src="{{ asset('assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jsvectormap/maps/world-merc.js') }}"></script>

    <!--Swiper slider js-->
    <script src="{{ asset('assets/libs/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Dashboard init -->
    <script src="{{ asset('assets/js/pages/dashboard-ecommerce.init.js') }}"></script>

    <!-- ckeditor -->
    <script src="{{ asset('assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>

    <!-- dropzone js -->
    <script src="{{ asset('assets/libs/dropzone/dropzone-min.js') }}"></script>

    <script src="{{ asset('assets/js/pages/ecommerce-product-create.init.js') }}"></script>
    <!-- App js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script>
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif

        @if (session('warning'))
            toastr.warning("{{ session('warning') }}");
        @endif

        @if (session('info'))
            toastr.info("{{ session('info') }}");
        @endif
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function handleAction(btnSelector, title, message, icon, iconColor, confirmText, confirmClass) {
                document.querySelectorAll(btnSelector).forEach(function(btn) {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        const name = btn.getAttribute('data-name') || 'mục này';
                        const form = btn.closest('form');

                        Swal.fire({
                            title: title,
                            html: `<p style="font-size:16px; color:#555;">
                            ${message} <b style="color:#d33;">"${name}"</b>?
                        </p>`,
                            icon: icon,
                            iconColor: iconColor,
                            showCancelButton: true,
                            confirmButtonText: confirmText,
                            cancelButtonText: '<i class="fa fa-times"></i> Hủy',
                            reverseButtons: true,
                            buttonsStyling: false,
                            customClass: {
                                confirmButton: confirmClass + ' mx-1',
                                cancelButton: 'btn btn-secondary mx-1'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    });
                });
            }

            // Xóa mềm
            handleAction(
                '.btn-delete',
                'Xóa mềm?',
                'Bạn chắc chắn muốn xóa mềm',
                'warning',
                '#f59e0b',
                '<i class="fa fa-trash"></i> Xóa mềm',
                'btn btn-warning'
            );

            // Khôi phục
            handleAction(
                '.btn-remove',
                'Khôi phục?',
                'Bạn muốn khôi phục',
                'info',
                '#3b82f6',
                '<i class="fa fa-undo"></i> Khôi phục',
                'btn btn-primary'
            );

            // Xóa cứng
            handleAction(
                '.btn-forcedelete',
                'Xóa vĩnh viễn?',
                'Bạn chắc chắn muốn xóa vĩnh viễn',
                'error',
                '#ef4444',
                '<i class="fa fa-trash-alt"></i> Xóa vĩnh viễn',
                'btn btn-danger'
            );

        });
    </script>
