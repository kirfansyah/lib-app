<?php
session_start()
?>

<body>

    <div class="main-wrapper">

        <div class="header">

            <div class="header-left active">
                <a href="<?= $baseUrl ?>" class="logo">
                    <i class="fa fa-university" style="font-size: 24px; font-weight: bold;"></i>&nbsp;&nbsp;&nbsp
                    <span style="font-size: 24px; font-weight: bold;">BookVault</span>
                </a>
                <a href="<? $baseUrl ?>" class="logo-small">
                    <i class="fa fa-university" style="font-size: 24px; font-weight: bold;"></i>
                </a>
                <a id="toggle_btn" href="javascript:void(0);">
                </a>
            </div>

            <a id="mobile_btn" class="mobile_btn" href="#sidebar">
                <span class="bar-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>

            <ul class="nav user-menu">
                <li class="nav-item dropdown has-arrow main-drop">
                    <a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
                        <span class="user-img"><img src="<?= $baseUrl ?>assets/img/profiles/avator1.jpg" alt="">
                            <span class="status online"></span></span>
                    </a>
                    <div class="dropdown-menu menu-drop-user">
                        <div class="profilename">
                            <div class="profileset">
                                <span class="user-img"><img src="<?= $baseUrl ?>assets/img/profiles/avator1.jpg" alt="">
                                    <span class="status online"></span></span>
                                <div class="profilesets">
                                    <h6><?= $_SESSION['full_name'] ?></h6>
                                    <h5><?= $_SESSION['leveluser'] ?></h5>
                                </div>
                            </div>
                            <hr class="m-0">
                            <a class="dropdown-item logout pb-0" href="<?= $baseUrl . 'logout' ?>"><img src="<?= $baseUrl ?>assets/img/icons/log-out.svg" class="me-2" alt="img">Logout</a>
                        </div>
                    </div>
                </li>
            </ul>


            <div class="dropdown mobile-user-menu">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="<?= $baseUrl . 'logout' ?>">Logout</a>
                </div>
            </div>

        </div>