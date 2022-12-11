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
                            <?php endif; ?> <div class=" form-row">
                                <div class="form-group col-md-6">
                                    <label for="username">Username</label>
                                    <input type="hidden" class="form-control" name="id" value="<?= !empty($return['id']) ? $return['id']  : '';  ?>">
                                    <input type="text" class="form-control" name="username" value="<?= !empty($return['username']) ? $return['username']  : '';  ?>" required>
                                </div>
                                <div class=" form-group col-md-6">
                                    <label for="level">Level User</label>
                                    <select class="form-control" name="level" required>
                                        <option disabled selected>Pilih Level User</option>
                                        <option value="1" <?= !empty($return['level']) ? (($return['level'] == '1') ? 'selected'  : '')  : '';  ?>>Admin</option>
                                        <option value="2" <?= !empty($return['level']) ? (($return['level'] == '2') ? 'selected'  : '')  : '';  ?>>Pegawai</option>
                                        <option value="3" <?= !empty($return['level']) ? (($return['level'] == '3') ? 'selected'  : '')  : '';  ?>>Kepala Sekolah</option>
                                    </select>
                                </div>

                                <div class=" form-group col-md-6">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password" <?= !empty($return['id']) ? "placeholder='kosongkan jika tidak diganti'"  : 'required' ?>>
                                </div>
                                <div class=" form-group col-md-6">
                                    <label for="repassword">Re Password</label>
                                    <input type="password" class="form-control" name="repassword" <?= !empty($return['id']) ? "placeholder='kosongkan jika tidak diganti'"  : 'required' ?>>
                                </div>
                                <div class=" form-group col-md-6">
                                    <label for="status_user">Status</label>
                                    <select class="form-control" name="status_user" required>
                                        <option value="Y" <?= !empty($return['status_user']) ? (($return['status_user'] == 'Y') ? 'selected'  : '')  : '';  ?>>Aktif</option>
                                        <option value="N" <?= !empty($return['status_user']) ? (($return['status_user'] == 'N') ? 'selected'  : '')  : '';  ?>>Non-Aktif</option>
                                    </select>
                                </div>
                            </div>

                            <a href=" <?= base_url(); ?>admin/user" class="btn btn-danger">Kembali</a>
                            <button type="submit" class="btn btn-primary float-right">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>