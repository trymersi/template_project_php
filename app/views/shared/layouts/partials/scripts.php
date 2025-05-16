<!-- Vendor JS -->
<script src="<?= BASE_URL ?>template/main/js/vendors.min.js"></script>
<script src="<?= BASE_URL ?>template/assets/icons/feather-icons/feather.min.js"></script>

<!-- jQuery (diperlukan untuk DataTables dan plugin lainnya) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- jQuery SlimScroll -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.8/jquery.slimscroll.min.js"></script>

<!-- jQuery Sparkline -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-sparklines/2.1.2/jquery.sparkline.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Toastr JS dan CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- SweetAlert2 JS dan CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<!-- Template JS -->
<script src="<?= BASE_URL ?>template/main/js/template.js"></script>

<!-- Custom JS -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto close alert after 5 seconds
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove();
            });
        }, 5000);
        
        // Initialize DataTables
        if (typeof $.fn.DataTable !== 'undefined' && $('.dataTable').length > 0) {
            $('.dataTable').DataTable();
        }
        
        // Konfigurasi Toastr
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
        
        // Fungsi untuk membersihkan modal
        window.cleanupModal = function(modalId) {
            $(modalId).modal('hide');
            $(modalId).removeClass('show');
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open');
            $('body').css('padding-right', '');
            console.log('Cleanup modal ' + modalId + ' dijalankan');
        }
        
        // Perbaikan tutup modal ketika tombol close atau batal diklik
        $('.btn-close, .modal .btn-default').on('click', function() {
            var modalId = '#' + $(this).closest('.modal').attr('id');
            cleanupModal(modalId);
        });
    });
</script> 