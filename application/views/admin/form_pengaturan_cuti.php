<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="<?= $form_url ?>">
                            <div class=" flash-data" data-flashdata="<?= $this->session->flashdata('pesan'); ?>">
                            </div>
                            <?php if ($this->session->flashdata('error')) : ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong> <?= $this->session->flashdata('error'); ?></strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php endif; ?>
                            <!-- <h6>Total cuti maksimum (hari)/tahun</h6>
                            <hr> -->
                            <div class=" form-row">
                                <div class="form-group col-md-4">
                                    <label for="cuti_n">Sisa Cuti 2022</label>
                                    <input type="number" class="form-control" name="cuti_n" value="<?= !empty($return['cuti_n']) ? $return['cuti_n']  : '';  ?>">
                                </div>
                            </div>

                            <h6>Data Atasan Kepala Sekolah</h6>
                            <hr>
                            <div class=" form-row">
                                <div class="form-group col-md-6">
                                    <label for="username">Nama</label>
                                    <input type="text" class="form-control" name="ak_nama" value="<?= $return['ak_nama']   ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="username">Jabatan </label>
                                    <input type="text" class="form-control" name="ak_jabatan" value="<?= $return['ak_jabatan']   ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="username">Pangkat Golongan</label>
                                    <input type="text" class="form-control" name="ak_pangkat_gol" value="<?= $return['ak_pangkat_gol']   ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="username">NIP </label>
                                    <input type="text" class="form-control" name="ak_nip" value="<?= $return['ak_nip']   ?>" required>
                                </div>

                            </div>
                            <hr>
                            <hr>
                            <h6>Data Pejabat yang berwenang memberikan cuti</h6>
                            <hr>
                            <div class=" form-row">
                                <div class="form-group col-md-6">
                                    <label for="username">Nama</label>
                                    <input type="text" class="form-control" name="pejabat_nama" value="<?= $return['pejabat_nama']   ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="username">jabatan</label>
                                    <input type="text" class="form-control" name="pejabat_jabatan" value="<?= $return['pejabat_jabatan']   ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="username">Pangkat Golongan</label>
                                    <input type="text" class="form-control" name="pejabat_pangkat_gol" value="<?= $return['pejabat_pangkat_gol']   ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="username">NIP</label>
                                    <input type="text" class="form-control" name="pejabat_nip" value="<?= $return['pejabat_nip']   ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="username">Wilayah </label>
                                    <input type="text" class="form-control" name="wilayah" value="<?= $return['wilayah']   ?>" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary float-right">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>