<link rel="icon" type='img/png' sizes='16x16' href="<?php echo base_url() ?>/assets/img/logo.png">
<div class="main-content">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('pesan'); ?>"></div>

    <section class="section">
        <div class="section-header">
            <h1>DASHBOARD PEGAWAI</h1>
        </div>
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
    </section>
</div>