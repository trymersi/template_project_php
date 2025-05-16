<!-- Flash Messages -->
<?php if ($this->session->hasFlash('success')): ?>
    <div class="alert alert-success-light alert-dismissible fade show" role="alert">
        <div class="d-flex align-items-center">
            <div class="alert-icon">
                <span class="icon-Approved-window"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span>
            </div>
            <div class="ms-10">
                <?= $this->session->getFlash('success') ?>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if ($this->session->hasFlash('error')): ?>
    <div class="alert alert-danger-light alert-dismissible fade show" role="alert">
        <div class="d-flex align-items-center">
            <div class="alert-icon">
                <span class="icon-Caution-sign"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span>
            </div>
            <div class="ms-10">
                <?= $this->session->getFlash('error') ?>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?> 