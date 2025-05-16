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
    
    <!-- Control Sidebar -->
    <aside class="control-sidebar">
        <div class="rpanel-title"><span class="pull-right btn btn-circle btn-danger"><i class="ion ion-close text-white" data-toggle="control-sidebar"></i></span> </div>  
        <!-- Create the tabs -->
        <ul class="nav nav-tabs control-sidebar-tabs">
            <li class="nav-item"><a href="#control-sidebar-home-tab" data-bs-toggle="tab" class="active"><i class="mdi mdi-message-text"></i></a></li>
            <li class="nav-item"><a href="#control-sidebar-settings-tab" data-bs-toggle="tab"><i class="mdi mdi-playlist-check"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <!-- Home tab content -->
            <div class="tab-pane active" id="control-sidebar-home-tab">
                <div class="flexbox">
                    <a href="javascript:void(0)" class="text-grey">
                        <i class="ti-more"></i>
                    </a>	
                    <p>Pengaturan Aplikasi</p>
                    <a href="javascript:void(0)" class="text-end text-grey"><i class="ti-plus"></i></a>
                </div>
                <div class="lookup lookup-sm lookup-right d-none d-lg-block">
                    <input type="text" name="s" placeholder="Cari..." class="w-p100">
                </div>
                <div class="media-list media-list-hover mt-20">
                    <div class="media py-10 px-0">
                        <a class="avatar avatar-lg status-success" href="#">
                            <img src="<?= BASE_URL ?>template/images/avatar/1.jpg" alt="...">
                        </a>
                        <div class="media-body">
                            <p class="fs-16">
                                <a class="hover-primary" href="#"><strong>Administrator</strong></a>
                            </p>
                            <p>Selamat datang di panel admin!</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.tab-pane -->
            <!-- Settings tab content -->
            <div class="tab-pane" id="control-sidebar-settings-tab">
                <div class="flexbox">
                    <a href="javascript:void(0)" class="text-grey">
                        <i class="ti-more"></i>
                    </a>	
                    <p>Pengaturan Sistem</p>
                    <a href="javascript:void(0)" class="text-end text-grey"><i class="ti-plus"></i></a>
                </div>
                <div class="list-group">
                    <div class="list-group-item py-1">
                        <span>Backup Database</span>
                    </div>
                    <div class="list-group-item py-1">
                        <span>Pemeliharaan Sistem</span>
                    </div>
                    <div class="list-group-item py-1">
                        <span>Log Aktivitas</span>
                    </div>
                </div>
            </div>
            <!-- /.tab-pane -->
        </div>
    </aside>
    <!-- /.control-sidebar -->
    
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