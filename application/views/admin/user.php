<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="row mt-5">
            <div class="col-lg-12 mt-2">
                <?php if ($this->session->flashdata('error')) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong> <?= $this->session->flashdata('error'); ?></strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
                <div class="flash-data" data-flashdata="<?= $this->session->flashdata('pesan'); ?>"></div>
                <a href="<?= base_url(); ?>admin/tambah_user" class="btn btn-primary mb-3">
                    Tambah User
                </a>

                <table class="table table-hover table-bordered" style="margin-top: 10px">
                    <thead>
                        <tr>
                            <th width="50px">No</th>
                            <th scope="col">Username</th>
                            <!-- <th scope="col">Passsword</th> -->
                            <th scope="col">Level</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($user as $kt) : ?>
                            <tr>
                                <td class="text-capitalize"><?= $no++; ?></td>
                                <td class="text-capitalize"><?= $kt['username']; ?></td>
                                <!-- <td class="text-capitalize"><?= $kt['password']; ?></td> -->
                                <td class="text-capitalize"><?= $kt['nama_level']; ?></td>
                                <td class="text-capitalize"><?= $kt['status_user'] == 'Y' ? 'Aktif' : 'Non-Aktif'; ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url(); ?>admin/edit_user/<?= $kt['id'] ?>" class="btn btn-sm btn-success text-light"><i class="fas fa-edit"></i></a>
                                    <a href="<?= base_url(); ?>admin/hapus_user/<?= $kt['id'] ?>" class="btn btn-sm btn-danger text-light tombol-hapus"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>