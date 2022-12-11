<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">

    <link rel="icon" type='img/png' sizes='16x16' href="<?php echo base_url() ?>/assets/img/logo.png">
    <title><?= $title; ?></title>

    <!-- General CSS Files -->
    <!-- <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- DATA TABLES -->
    <!--  Datatables  -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.12.1/af-2.4.0/b-2.2.3/r-2.3.0/rr-1.2.8/sc-2.0.7/sb-1.3.4/datatables.min.css" />
    <link rel="stylesheet" type="text/css" href=" https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css" />

    <script src="https://kit.fontawesome.com/f92d93199b.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <!-- Template CSS -->
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/components.css">


    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="<?= base_url(); ?>assets/custom.js"></script>

</head>
<style>
    .fa-bell[data-count]:after {
        position: absolute;
        right: 0%;
        top: 10%;
        content: attr(data-count);
        font-size: 50%;
        padding: .6em;
        border-radius: 999px;
        line-height: .75em;
        color: white;
        background: rgba(255, 0, 0, .85);
        text-align: center;
        min-width: 2em;
        font-weight: bold;
    }
</style>

<body>
    <div id="app">
        <div class="main-wrapper">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <form class="form-inline mr-auto">
                    <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i>
                        <h5 class="mt-2 text-light d-inline ml-3"><?= $title; ?></h5>
                    </a>
                </form>
                <ul class="navbar-nav navbar-right">
                    <?php
                    $data = getNotification();
                    $now = new DateTime();
                    $bell = false;
                    $html_notif = '';
                    $i = 0;
                    foreach ($data as $notif) {
                        $since_start = $now->diff(new DateTime($notif['notif_time']));
                        $r = '';
                        if ($notif['status'] == 0) {
                            $bell = true;
                            $r = '&r=' . $notif['id_notif'];
                            $i++;
                        }
                        if ($since_start->m > 0)
                            $text = $since_start->m . ' bulan yang lalu';
                        else if ($since_start->d > 0)
                            $text = $since_start->d . ' hari yang lalu';
                        else if ($since_start->h > 0)
                            $text = $since_start->h . ' jam yang lalu';
                        else if ($since_start->i > 0)
                            $text = $since_start->i . ' menit yang lalu';
                        else
                            $text = 'Baru saja';
                        $html_notif .= '
                                            <a href="' . base_url() . $notif['link'] . $r . '"  class="dropdown-item ' . ($notif['status']  == 0 ? 'dropdown-item-unread' : '') . '">
                                                <div class="dropdown-item-icon bg-primary text-white">
                                                    <i class="' .  $notif['icon'] . '"></i>
                                                </div>
                                                <div class="dropdown-item-desc">
                                                    ' .   ($notif['status']  == 0 ? '<b>' . $notif['text'] . '</b>' : $notif['text'])  . '
                                                    <div class="time text-primary">' . $text . '</div>
                                                </div>
                                            </a>';
                    }
                    ?>
                    <li class="dropdown dropdown-list-toggle">
                        <a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg  <?= ($bell ? 'beep' : '') ?>">
                            <i class="far fa-bell" <?= $i > 0 ?  'data-count="' . $i . '"' : '' ?>>
                            </i>
                        </a>
                        <div class="dropdown-menu dropdown-list dropdown-menu-right">
                            <div class="dropdown-header">Notifications
                                <span class="badge badge-light"><?= $i ?></span>
                            </div>
                            <div class="dropdown-list-content dropdown-list-icons">
                                <?= $html_notif ?>


                            </div>
                            <div class="dropdown-footer text-center">
                                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <i class="far fa-user"></i>
                            <div class="d-sm-none d-lg-inline-block">Hi, <?= $this->session->userdata('username') ?></div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="<?= base_url('profile') ?>" class="dropdown-item has-icon">
                                <i class="far fa-user"></i> Profile
                            </a>
                            <a type="button" data-toggle="modal" id="ganti_password_btn" class="dropdown-item has-icon">
                                <i class="fas fa-key"></i> Ganti Password
                            </a>
                            <div class="dropdown-divider"></div>
                            <a type="button" data-toggle="modal" id="logoutbtn" class="dropdown-item has-icon text-danger">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>

                    </li>
                </ul>
            </nav>

            <div class="modal fade" id="ganti_password_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Ganti Password</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="<?= base_url() ?>auth/ganti_password" method="post">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="nama">Password Lama</label>
                                    <input type="password" class="form-control " name="old_password" id="old_password">
                                </div>
                                <div class="form-group">
                                    <label for="nama">Password Baru</label>
                                    <input type="password" class="form-control " name="new_password" id="new_password">
                                </div>
                                <div class="form-group">
                                    <label for="nama">Ulangi Password Baru</label>
                                    <input type="password" class="form-control " name="new_repassword" id="new_repassword">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Ganti</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="logout_modal" tabindex="-1" aria-labelledby="exampleModalLabel" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Sistem Manajemen Kepegawian</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-bs-dismiss="modal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Anda Yakin Ingin Keluar?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <a class="btn btn-danger" href="<?= base_url() ?>auth/logout">Keluar</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flash-data" data-flashdata="<?= $this->session->flashdata('pesan'); ?>"></div>