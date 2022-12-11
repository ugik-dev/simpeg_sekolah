<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="row mt-5">
            <div class="col-lg-12 mt-2">
                <div class="flash-data" data-flashdata="<?= $this->session->flashdata('pesan'); ?>"></div>
                <a href="<?= base_url(); ?>pegawai/tambah_pegawai" class="btn btn-primary mb-3">
                    Tambah Data Pegawai
                </a>

                <form>

                </form>
                <table class="table table-hover table-bordered" style="margin-top: 10px">
                    <thead>
                        <tr>
                            <th width="50px">No</th>
                            <th scope="col">Nama </th>
                            <th scope="col">NUPTK</th>
                            <th scope="col">Jenis Kelamin</th>
                            <th scope="col">Tempat Lahir</th>
                            <th scope="col">Tanggal Lahir</th>
                            <th scope="col">NIP</th>
                            <th scope="col">Status</th>
                            <th scope="col">Tanggal Lahir</th>
                            <th scope="col">Jenis PTK</th>
                            <th scope="col">Gelar</th>
                            <th scope="col">Jenjang Jurusan</th>
                            <th scope="col">Sertifikasi</th>
                            <th scope="col">TMT Kerja</th>
                            <th scope="col">Masa Kerja Golongan</th>
                            <th scope="col">Masa Kerja Keseluruhan</th>
                            <th scope="col">Jabatan</th>
                            <th scope="col">Tugas Tambahan</th>
                            <th scope="col">Mengajar</th>
                            <th scope="col">Jam Tugas</th>
                            <th scope="col">Jumlah Jam Mengajar</th>
                            <th scope="col">Total Jumlah Jam Mengajar </th>
                            <th scope="col">Siswa</th>
                            <th scope="col">Kompeten</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($pegawai as $k) : ?>
                            <tr>
                                <td class="text-capitalize"><?= $no++; ?></td>
                                <td class="text-capitalize"><?= $k->nama; ?></td>
                                <td class="text-capitalize"><?= $k->nuptk; ?></td>
                                <td class="text-capitalize"><?= $k->jenis_kelamin; ?></td>
                                <td class="text-capitalize"><?= $k->tempat_lahir; ?></td>
                                <td class="text-capitalize"><?= $k->tanggal_lahir; ?></td>
                                <td class="text-capitalize"><?= $k->nip; ?></td>
                                <td class="text-capitalize"><?= $k->status; ?></td>
                                <td class="text-capitalize"><?= $k->jenis_ptk; ?></td>
                                <td class="text-capitalize"><?= $k->gelar; ?></td>
                                <td class="text-capitalize"><?= $k->jenjang; ?></td>
                                <td class="text-capitalize"><?= $k->jurusan; ?></td>
                                <td class="text-capitalize"><?= $k->sertifikasi; ?></td>
                                <td class="text-capitalize"><?= $k->tmt_kerja; ?></td>
                                <td class="text-capitalize"><?= $k->masa_kerja_golongan; ?></td>
                                <td class="text-capitalize"><?= $k->masa_kerja_seluruhan; ?></td>
                                <td class="text-capitalize"><?= $k->jabatan; ?></td>
                                <td class="text-capitalize"><?= $k->tugas_tambahan; ?></td>
                                <td class="text-capitalize"><?= $k->mengajar; ?></td>
                                <td class="text-capitalize"><?= $k->jam_tugas; ?></td>
                                <td class="text-capitalize"><?= $k->jjm; ?></td>
                                <td class="text-capitalize"><?= $k->total_jjm; ?></td>
                                <td class="text-capitalize"><?= $k->siswa; ?></td>
                                <td class="text-capitalize"><?= $k->kompeten; ?></td>

                                <td class="text-center">
                                    <!-- Button Update -->
                                    <a href="<?= base_url(); ?>/pegawai/edit_pegawai/<?= $k->id ?>" class="btn btn-sm btn-success text-light"><i class="fas fa-edit"></i></a>
                                    <!-- Button Hapus -->
                                    <a href="<?= base_url(); ?>/pegawai/hapus_pegawai/<?= $k->id ?>" class="btn btn-sm btn-danger text-light tombol-hapus"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>