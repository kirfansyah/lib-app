<?php require_once __DIR__ . "/templates/header.php"; ?>
<?php require_once __DIR__ . "/templates/navbar.php"; ?>
<?php require_once __DIR__ . "/templates/sidebar.php"; ?>

<!-- Content -->
<div class="page-wrapper pagehead">
    <div class="content">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Blank Page</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<? $baseUrl ?>"><?= formatUrlLabel($main_page) ?? 'Dashboard' ?></a></li>
                        <li class="breadcrumb-item active"><?= formatUrlLabel($sub_page) ?? '' ?></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                Contents here
            </div>
        </div>
    </div>
</div>
<!-- End Of Content -->

<?php require_once __DIR__ . "/templates/footbar.php"; ?>
<!-- Javascript -->

<!-- End Of Javascript -->
<?php require_once __DIR__ . "/templates/footbarend.php"; ?>