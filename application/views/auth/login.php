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

    <link rel="stylesheet" href="<?= site_url('assets/css/dashlite.css?ver=3.1.0') ?>">
    <link rel="stylesheet" href="<?= site_url('assets/css/theme.css?ver=3.1.0') ?>">
</head>

<body class="nk-body bg-white npc-general pg-auth">
    <div class="nk-app-root">
        <div class="nk-main ">
            <div class="nk-wrap nk-wrap-nosidebar">
                <div class="nk-content bg-dark">
                    <div class="nk-block nk-block-middle nk-auth-body  wide-xs">
                        <div class="card card-bordered">
                            <div class="card-inner card-inner-lg">
                                <div class="brand-logo pb-4 text-center">
                                    <a href="<?= site_url() ?>" class="logo-link" style="color: #364a63;">
                                        <img class="logo-dark logo-img logo-img-lg" src="<?= site_url('assets/images/logo-bjl-2-removebg-preview.png') ?>" alt="logo-dark">
                                        <span class="fs-3 fw-bold">PT. Berkah Jaya Lestarindo</span>
                                    </a>
                                </div>
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title">Selamat Datang</h4>
                                        <div class="nk-block-des">
                                            <p>Silahkan Login</p>
                                        </div>
                                    </div>
                                </div>
                                <?php if(validation_errors()): ?>
                                    <div class="alert alert-warning alert-dismissible">
                                        <?= validation_errors() ?>
                                        <button class="close" data-bs-dismiss="alert"></button>
                                    </div>
                                <?php endif; ?>
                                <form action="<?= current_url() ?>" method="post">
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="default-01">Username</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control form-control-lg" name="username" placeholder="Enter your Username">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="password">Password</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password">
                                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                            </a>
                                            <input type="password" class="form-control form-control-lg" name="password" placeholder="Enter your passcode">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-lg btn-primary btn-block">Login</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="<?= site_url('assets/js/bundle.js?ver=3.1.0') ?>"></script>
<script src="<?= site_url('assets/js/scripts.js?ver=3.1.0') ?>"></script>
</html>