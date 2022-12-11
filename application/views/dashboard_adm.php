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
      <h1>Dashboard</h1>
    </div>
    <div class="row">

      <div class="col-sm-12 col-md-6 col-lg-6 ">
        <div class="row">

          <div class="col-xl-6 col-md-12 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                      Jumlah Pegawai</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jumlah_pegawai ?></div>
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-user fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-6 col-md-12 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                      Pegawai (Laki-laki)</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jumlah_laki ?></div>
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-mars fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-6 col-md-12 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                      Pegawai (Perempuan)</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jumlah_perempuan ?></div>
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-venus fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-6 col-md-12 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Sertifikasi
                    </div>
                    <div class="row no-gutters align-items-center">
                      <div class="col-auto">
                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= $persentase_sertifikasi ?>%</div>
                      </div>
                      <div class="col">
                        <div class="progress progress-sm mr-2">
                          <div class="progress-bar bg-info" role="progressbar" style="width: <?= $persentase_sertifikasi ?>%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>


        </div>
      </div>
      <div class="col-sm-12 col-md-6 col-lg-6 ">
        <div class="row">
          <div class="col-lg-12">
            <div class="card shadow mb-4 bg-primary">
              <div class="card-header py-3">
                <h5 class="m-0 font-weight-bold">Pengumuman</h5>
              </div>
            </div>
          </div>

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