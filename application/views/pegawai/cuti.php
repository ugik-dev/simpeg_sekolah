<div class="main-content">
    <section class="section">
        <div class="card">
            <div class="card-body">

                <div class="row mt-5">
                    <div class="col-lg-12 mt-2">
                        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('pesan'); ?>"></div>
                        <a href="<?= base_url(); ?>pegawai/add_cuti" class="btn btn-primary mb-3">
                            Tambah
                        </a>
                        <?php if ($this->session->flashdata('error')) : ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong> <?= $this->session->flashdata('error'); ?></strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>
                        <table class="table table-hover table-bordered" style="margin-top: 10px">
                            <thead>
                                <tr>
                                    <th width="50px">No</th>
                                    <th width="300px">Nama Pegawai</th>
                                    <th width="300px">Status</th>
                                    <th scope="col">Dari Tgl</th>
                                    <th scope="col">Sampai Tgl</th>
                                    <th scope="col">Jenis</th>
                                    <th scope="col">Lama</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($user as $kt) : ?>
                                    <tr>
                                        <td class="text-capitalize"><?= $no++; ?></td>
                                        <td class="text-capitalize"><?= $kt['nama']; ?></td>
                                        <td class="text-capitalize"><?= statusCuti($kt['status_cuti'], $kt); ?></td>
                                        <td class="text-capitalize"><?= $kt['dari']; ?></td>
                                        <td class="text-capitalize"><?= $kt['sampai']; ?></td>
                                        <td class="text-capitalize"><?= $kt['nama_jenis_cuti']; ?>
                                            <?php if ($kt['jenis'] == 1) {
                                                echo '<br>N-2 : ' . $kt['n2'];
                                                echo ', N-1 : ' . $kt['n1'];
                                                echo ', N : ' . $kt['n'];
                                            } ?></td>
                                        <td class="text-capitalize"><?= $kt['lama'] . ' ' . $kt['satuan']; ?></td>
                                        <td class="text-center">
                                            <div class="btn-group mr-2" role="group" aria-label="Aksi">
                                                <a href="<?= base_url(); ?>pegawai/print_cuti/<?= $kt['id_cuti'] ?>" class="btn btn-sm btn-secondary text-dark"><i class="fas fa-print"></i></a>
                                                <a href="<?= base_url(); ?>pegawai/edit_cuti/<?= $kt['id_cuti'] ?>" class="btn btn-sm btn-success text-light"><i class="fas fa-edit"></i></a>
                                                <a href="<?= base_url(); ?>pegawai/hapus_cuti/<?= $kt['id_cuti'] ?>" class="btn btn-sm btn-danger text-light tombol-hapus"><i class="fas fa-trash-alt"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>