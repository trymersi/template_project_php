            </section>
            <!-- /.content -->
        </div>
        <!-- /.container-full -->
    </div>
    <!-- /.content-wrapper -->
    
    <footer class="main-footer">
        <div class="pull-right d-none d-sm-inline-block">
            <ul class="nav nav-primary nav-dotted nav-dot-separated justify-content-center justify-content-md-end">
                <li class="nav-item">
                    <a class="nav-link" href="javascript:void(0)"><?= APP_VERSION ?></a>
                </li>
            </ul>
        </div>
        &copy; <?= date('Y') ?> <a href="<?= BASE_URL ?>"><?= APP_NAME ?></a>. All Rights Reserved.
    </footer>
    
    <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
    
</div>
<!-- ./wrapper -->

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
    });
</script>
</body>
</html> 