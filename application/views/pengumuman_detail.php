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
            <h1><?= $pengumuman['judul'] ?>
                <br>
                <small><?= tanggal_indonesia($pengumuman['tanggal']) ?></small>
            </h1>
            <br>
        </div>
        <div class="row">


            <div class="col-sm-12 col-md-12 col-lg-12 ">

                <div class="card shadow mb-4">
                    <!-- <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary"><?= $p['judul'] ?></h6>
                    </div> -->
                    <div class="card-body">
                        <?= $pengumuman['isi'] ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="col-sm-12 col-md-6 col-lg-6 ">
      <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
              <i class="far fa-user"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total User</h4>
              </div>
              <div class="card-body">
                10
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> -->



    </section>
</div>