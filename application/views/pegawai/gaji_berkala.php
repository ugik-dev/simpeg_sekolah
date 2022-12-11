<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="row mt-5">
            <div class="col-lg-12 mt-2">
                <div class="flash-data" data-flashdata="<?= $this->session->flashdata('pesan'); ?>"></div>
                <a href="<?= base_url(); ?>pegawai/add_gaji_berkala" class="btn btn-primary mb-3">
                    Tambah
                </a>

                <table class="table table-hover table-bordered" style="margin-top: 10px">
                    <thead>
                        <tr>
                            <th width="50px">No</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Nominal</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($user as $kt) : ?>
                            <tr>
                                <td class="text-capitalize"><?= $no++; ?></td>
                                <td class="text-capitalize"><?= $kt['tanggal_pengajiuan']; ?></td>
                                <td class="text-capitalize"><?= $kt['nominal']; ?></td>

                                <td class="text-capitalize"><?= $kt['status']; ?></td>
                                <td class="text-center">
                                    <div class="btn-group mr-2" role="group" aria-label="Aksi">
                                        <a href="<?= base_url(); ?>pegawai/print_gaji_berkala/<?= $kt['id_gaji_berkala'] ?>" class="btn btn-sm btn-secondary text-dark"><i class="fas fa-print"></i></a>
                                        <a href="<?= base_url(); ?>pegawai/edit_gaji_berkala/<?= $kt['id_gaji_berkala'] ?>" class="btn btn-sm btn-success text-light"><i class="fas fa-edit"></i></a>
                                        <a href="<?= base_url(); ?>pegawai/hapus_gaji_berkala/<?= $kt['id_gaji_berkala'] ?>" class="btn btn-sm btn-danger text-light tombol-hapus"><i class="fas fa-trash-alt"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>