<style>
    a.nostyle {
        text-decoration: inherit;
        color: inherit;
        cursor: auto;
    }
</style>
<link rel="icon" type='img/png' sizes='16x16' href="<?php echo base_url() ?>/assets/img/logo.png">
<!-- Main Content -->
<div class="main-content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('pesan'); ?>"></div>

    <section class="section">
        <div class="section-header">
            <h1>Pengumuman</h1>
        </div>

        <div class="row">

            <?php foreach ($pengumuman as $p) {
            ?>
                <div class="col-lg-12">
                    <a class="nostyle" href="<?= base_url('pengumuman/' . $p['id_pengumuman']) ?>">

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary"><?= $p['judul'] ?>
                                    <br>
                                    <small> <?= tanggal_indonesia($p['tanggal']) ?> </small>
                                </h6>
                            </div>
                            <div class="card-body">
                                <?= substr(strip_tags($p['isi']), 0, 300); ?>
                            </div>
                        </div>
                    </a>
                </div>
            <?php } ?>

            <div class="col-lg-12">
                <a class="nostyle" href="<?= base_url('pengumuman/') ?>">
                    <div class="card shadow mb-4 bg-primary">
                        <div class="card-header py-3">
                            <h5 class="m-0 font-weight-bold">Lainnya .. </h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>



    </section>
</div>