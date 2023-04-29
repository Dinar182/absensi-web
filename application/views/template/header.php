<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="<?= site_url('assets/images/logo-bjl-2-removebg-preview.png') ?>">
    <!-- Page Title  -->
    <title>PT. Berkah Jaya Lestarindo</title>
    <!-- StyleSheets  -->

    <meta name="base_url" content="<?= site_url('/') ?>">

    <link rel="stylesheet" href="<?= site_url('assets/css/dashlite.css?ver=3.1.0') ?>">
    <link rel="stylesheet" href="<?= site_url('assets/css/theme.css?ver=3.1.0') ?>">
    <link rel="stylesheet" href="<?= site_url('assets/css/main.css?_=') . rand() ?>">

    <?php
		if (isset($top_css_pages)) {
			echo $top_css_pages;
		}
	?>
</head>

<body class="nk-body bg-lighter npc-general has-sidebar ">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- sidebar @s -->
            <div class="nk-sidebar nk-sidebar-fixed is-dark " data-content="sidebarMenu">
                <div class="nk-sidebar-element nk-sidebar-head">
                    <div class="nk-menu-trigger">
                        <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
                        <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
                    </div>
                    <div class="nk-sidebar-brand">
                        <a href="<?= site_url() ?>" class="logo-link nk-sidebar-logo text-light">
                            <img class="logo-light logo-img" src="<?= site_url('assets/images/logo-bjl-2-removebg-preview.png') ?>" alt="logo">
                            <span class="fs-3">BJL Group</span>
                        </a>
                    </div>
                </div>
                <div class="nk-sidebar-element nk-sidebar-body">
                    <div class="nk-sidebar-content">
                        <div class="nk-sidebar-menu" data-simplebar>
                            <ul class="nk-menu">
                                <li class="nk-menu-heading">
                                    <h6 class="overline-title text-primary-alt">Home</h6>
                                </li>
                                <li class="nk-menu-item">
                                    <a href="<?= site_url() ?>" class="nk-menu-link">
                                        <span class="nk-menu-icon">
                                            <em class="icon ni ni-dashlite"></em>
                                        </span>
                                        <span class="nk-menu-text">Dashboard</span>
                                    </a>
                                </li>
                                <li class="nk-menu-heading">
                                    <h6 class="overline-title text-primary-alt">Karyawan</h6>
                                </li>
                                <li class="nk-menu-item">
                                    <a href="<?= site_url('karyawan') ?>" class="nk-menu-link">
                                        <span class="nk-menu-icon">
                                            <em class="icon ni ni-users-fill"></em>
                                        </span>
                                        <span class="nk-menu-text">Data Karyawan</span>
                                    </a>
                                </li>
                                <li class="nk-menu-heading">
                                    <h6 class="overline-title text-primary-alt">Persetujuan</h6>
                                </li>
                                <li class="nk-menu-item">
                                    <a href="<?= site_url('approval/ijin') ?>" class="nk-menu-link">
                                        <span class="nk-menu-icon">
                                            <em class="icon ni ni-clock-fill"></em>
                                        </span>
                                        <span class="nk-menu-text">Persetujuan Ijin</span>
                                    </a>
                                </li>
                                <li class="nk-menu-item">
                                    <a href="<?= site_url('approval/cuti') ?>" class="nk-menu-link">
                                        <span class="nk-menu-icon">
                                            <em class="icon ni ni-calendar-fill"></em>
                                        </span>
                                        <span class="nk-menu-text">Persetujuan Cuti</span>
                                    </a>
                                </li>
                                <li class="nk-menu-heading">
                                    <h6 class="overline-title text-primary-alt">Laporan</h6>
                                </li>
                                <li class="nk-menu-item">
                                    <a href="<?= site_url('laporan_absensi') ?>" class="nk-menu-link">
                                        <span class="nk-menu-icon">
                                            <em class="icon ni ni-reports-alt"></em>
                                        </span>
                                        <span class="nk-menu-text">Laporan Absensi</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- sidebar @e -->
            <!-- wrap @s -->
            <div class="nk-wrap ">
                <!-- main header @s -->
                <div class="nk-header nk-header-fixed is-light">
                    <div class="container-fluid">
                        <div class="nk-header-wrap">
                            <div class="nk-menu-trigger d-xl-none ms-n1">
                                <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
                            </div>
                            <div class="nk-header-brand d-xl-none">
                                <a href="html/index.html" class="logo-link">
                                    <img class="logo-light logo-img" src="<?= site_url('assets/images/logo-bjl-2-removebg-preview.png') ?>" alt="logo">
                                </a>
                            </div><!-- .nk-header-brand -->
                            <div class="nk-header-tools">
                                <ul class="nk-quick-nav">
                                    <li class="dropdown user-dropdown">
                                        <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                                            <div class="user-toggle">
                                                <div class="user-avatar sm">
                                                    <em class="icon ni ni-user-alt"></em>
                                                </div>
                                                <div class="user-info d-none d-md-block">
                                                    <div class="user-status">Administrator</div>
                                                    <div class="user-name dropdown-indicator"><?= $this->session->nama ?></div>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-end dropdown-menu-s1">
                                            <div class="dropdown-inner">
                                                <ul class="link-list">
                                                    <li><a href="<?= site_url('auth/logout') ?>"><em class="icon ni ni-signout"></em><span>Sign out</span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>