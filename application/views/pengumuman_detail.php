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
          <div class="card-body">
            <?= $pengumuman['isi'] ?>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>