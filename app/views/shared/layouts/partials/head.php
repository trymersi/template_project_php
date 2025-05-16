<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="<?= APP_NAME ?> - Dashboard">
<meta name="author" content="<?= APP_NAME ?>">
<link rel="icon" href="<?= BASE_URL ?>assets/images/favicon.ico">

<title><?= $title ?? APP_NAME ?> - <?= ucfirst($this->session->get('user_role')) ?></title>

<!-- Vendors Style-->
<link rel="stylesheet" href="<?= BASE_URL ?>template/main/css/vendors_css.css">
  
<!-- Style-->  
<link rel="stylesheet" href="<?= BASE_URL ?>template/main/css/style.css">
<link rel="stylesheet" href="<?= BASE_URL ?>template/main/css/skin_color.css">

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

<!-- Custom CSS -->
<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/custom.css">

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 