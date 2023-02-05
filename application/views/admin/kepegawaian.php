<!-- Main Content -->
<div class="main-content">
    <div class="card">
        <div class="card-body">
            <section class="section">
                <div class="row mt-5">
                    <div class="col-lg-12 mt-2">

                        <div class="dropdown mb-3" <?= $this->session->userdata('level') != '1' ? 'hidden' : '' ?>>
                            <button class="col-lg-12 btn btn-secondary dropdown-toggle mb-3" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Filters
                            </button>
                            <div class="dropdown-menu col-lg-12 mb-3" style="width: 100%" aria-labelledby="dropdownMenu2">
                                <div class="col-lg-12">
                                    <form method="get">
                                        <div class="form-row">
                                            <div class="form-group col-lg-6">
                                                <!-- <div class="form-group col-md-12"> -->
                                                <label for="inputEmail4">TMT Kerja</label>
                                                <div class="row">
                                                    <div class="col">
                                                        <input type="date" name="tmt_start" value="<?= !empty($filter['tmt_start']) ? $filter['tmt_start'] : '' ?>" class="form-control" placeholder="">
                                                    </div>
                                                    <div class="">
                                                        <p>s.d</p>
                                                    </div>
                                                    <div class="col">
                                                        <input type="date" name="tmt_end" value="<?= !empty($filter['tmt_end']) ? $filter['tmt_end'] : '' ?>" class="form-control" placeholder="">
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="inputEmail4">Jenis Kelamin</label>
                                                <select class="form-control" name="jenis_kelamin">
                                                    <option value="">Semua</option>
                                                    <option value="L" <?= !empty($filter['jenis_kelamin']) ? ($filter['jenis_kelamin'] == 'L' ? 'selected' : '') : '' ?>>Laki Laki</option>
                                                    <option value="P" <?= !empty($filter['jenis_kelamin']) ? ($filter['jenis_kelamin'] == 'P' ? 'selected' : '') : '' ?>>Perempuan</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="inputEmail4">Status</label>
                                                <select class="form-control" name="status">
                                                    <option value="">Semua</option>
                                                    <option value="1" <?= !empty($filter['status']) ? ($filter['status'] == '1' ? 'selected' : '') : '' ?>>PNS</option>
                                                    <option value="2" <?= !empty($filter['status']) ? ($filter['status'] == '2' ? 'selected' : '') : '' ?>>PPPK</option>
                                                    <option value="3" <?= !empty($filter['status']) ? ($filter['status'] == '3' ? 'selected' : '') : '' ?>>GTT</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <!-- <div class="form-group col-md-12"> -->
                                                <label for="inputEmail4">Tanggal Lahir</label>
                                                <div class="row">
                                                    <div class="col">
                                                        <input type="date" name="tl_start" class="form-control" value="<?= !empty($filter['tl_start']) ? $filter['tl_start'] : '' ?>" placeholder="">
                                                    </div>
                                                    <div class="">
                                                        <p>s.d</p>
                                                    </div>
                                                    <div class="col">
                                                        <input type="date" name="tl_end" class="form-control" value="<?= !empty($filter['tl_end']) ? $filter['tl_end'] : '' ?>" placeholder="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="inputEmail4">Sertifikasi</label>
                                                <select class="form-control" name="st_sertifikasi">
                                                    <option value="">Semua</option>
                                                    <option value="Y" <?= !empty($filter['st_sertifikasi']) ? ($filter['st_sertifikasi'] == 'Y' ? 'selected' : '') : '' ?>>Sudah Sertifikasi</option>
                                                    <option value="N" <?= !empty($filter['st_sertifikasi']) ? ($filter['st_sertifikasi'] == 'N' ? 'selected' : '') : '' ?>>Belum Sertifikasi</option>
                                                    <option value="P" <?= !empty($filter['st_sertifikasi']) ? ($filter['st_sertifikasi'] == 'P' ? 'selected' : '') : '' ?>>Berkah Mengajukan</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="inputEmail4">Kenaikan Gaji Berkala</label>
                                                <select class="form-control" name="kgb">
                                                    <option value="">Semua</option>
                                                    <option value="Y" <?= !empty($filter['kgb']) ? ($filter['kgb'] == 'Y' ? 'selected' : '') : '' ?>>Yang Berkah Mengajukan</option>
                                                    <option value="N" <?= !empty($filter['kgb']) ? ($filter['kgb'] == 'N' ? 'selected' : '') : '' ?>>Tidak Berkah Mengajukan</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="inputEmail4">Status User</label>
                                                <select class="form-control" name="status_user">
                                                    <option value="">Semua</option>
                                                    <option value="Y" <?= !empty($filter['status_user']) ? ($filter['status_user'] == 'Y' ? 'selected' : '') : '' ?>>Aktif</option>
                                                    <option value="N" <?= !empty($filter['status_user']) ? ($filter['status_user'] == 'N' ? 'selected' : '') : '' ?>>Non Aktif</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="inputEmail4">Pesiun</label>
                                                <select class="form-control" name="pensiun">
                                                    <option value="">Semua</option>
                                                    <option value="1" <?= !empty($filter['pensiun']) ? ($filter['pensiun'] == '1' ? 'selected' : '') : '' ?>>Sudah Pensiun</option>
                                                    <option value="2" <?= !empty($filter['pensiun']) ? ($filter['pensiun'] == '2' ? 'selected' : '') : '' ?>>1 Bulan lagi pensiun</option>
                                                    <option value="3" <?= !empty($filter['pensiun']) ? ($filter['pensiun'] == '3' ? 'selected' : '') : '' ?>>Belum Pensiun</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="btn-group mr-2 mb-4" role="group" aria-label="First group">
                                                    <button type="submit" class="btn btn-info"><i class="fa fa-search mr-2"></i>Cari</button>
                                                    <a href="<?= base_url($link_reset) ?>" class="btn btn-secondary">Reset <i class="fa fa-refresh  ml-2"></i></a>
                                                </div>
                                            </div>
                                            <!-- <button class="btn btn-primary" type="submit">Cari</button> -->
                                    </form>
                                </div>


                            </div>
                        </div>
                    </div>

                    <table class="table table-hover table-bordered mt-3" id="FDTable">
                        <thead>
                            <tr>
                                <th scope="col">Aksi</th>
                                <th width="1px">No</th>
                                <th scope="col">Username</th>
                                <th scope="col">Sisa Cuti</th>
                                <th scope="col">Status User</th>
                                <th scope="col">Nama</th>
                                <th scope="col">NIP</th>
                                <th scope="col">Jabatan</th>
                                <th scope="col">Jenis Kelamin</th>
                                <th scope="col">Templat Lahir</th>
                                <th scope="col">Tanggal Lahir</th>
                                <th scope="col">Status</th>
                                <th scope="col">Jenis PTK</th>
                                <th scope="col">Jenjang</th>
                                <th scope="col">Jurusan</th>
                                <th scope="col">Sertifikasi</th>
                                <th scope="col">TMT Kerja</th>
                                <th scope="col">Tugas Tambahan</th>
                                <th scope="col">Mengajar</th>
                                <th scope="col">KGB Trakhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            $this_year = date('Y');
                            $admin = $this->session->userdata('level') == 1 ? true : false;
                            foreach ($user as $kt) {

                                if ($this_year == '2023') {
                                    $sisa_n = 12 -
                                        $kt['ct_n'];
                                    $sisa_n1 = $kt['cuti_n'] -
                                        $kt['ct_n2'] - $kt['ct2_n'];
                                }
                            ?>
                                <tr>
                                    <td class="text-center">
                                        <a href="<?= base_url(); ?>detail-pegawai/<?= $kt['id_user'] ?>" class="btn btn-sm btn-success text-light"><i class="fas fa-eye"></i></a>
                                        <?= $admin ? "<a href='" . base_url() . "admin/form_pegawai/" . $kt['id_user'] . "' class='btn btn-sm btn-success text-light'><i class='fas fa-edit'></i></a>" : '' ?>
                                    </td>
                                    <td class="text-capitalize"><?= $kt['id_user'];; ?></td>
                                    <td class=""><?= $kt['username']; ?></td>
                                    <td class=""><?= "Tahun {$this_year} =" . $sisa_n . "<br>Tahun " . ($this_year - 1) . "=" . $sisa_n1 ?></td>
                                    <td class="text-capitalize"><?= $kt['status_user'] == 'Y' ? 'Aktif' : 'Non Aktif'; ?></td>
                                    <td class="text-capitalize"><?= $kt['nama']; ?></td>
                                    <td class="text-capitalize"><?= $kt['nip']; ?></td>
                                    <td class="text-capitalize"><?= $kt['jabatan'] . '<br>' . $kt['jabatan_tmt'];; ?></td>
                                    <td class="text-capitalize"><?= $kt['jenis_kelamin']; ?></td>
                                    <td class="text-capitalize"><?= $kt['tempat_lahir']; ?></td>
                                    <td class="text-capitalize"><?= $kt['tanggal_lahir']; ?></td>
                                    <td class="text-capitalize"><?= $kt['nama_status']; ?></td>
                                    <td class="text-capitalize"><?= $kt['nama_ptk']; ?></td>
                                    <td class="text-capitalize"><?= $kt['jenjang']  ?></td>
                                    <td class="text-capitalize"><?= $kt['jurusan']; ?></td>
                                    <td class="text-capitalize"><?= $kt['st_sertifikasi'] == 'Y' ? 'Sudah Sertifikasi' : ($kt['st_sertifikasi'] == 'P' ? ' Berkah Mengajukan' : 'Belum Sertifikasi'); ?></td>
                                    <td class="text-capitalize"><?= $kt['tmt_kerja']; ?></td>
                                    <td class="text-capitalize"><?= $kt['tugas_tambahan']; ?></td>
                                    <td class="text-capitalize"><?= $kt['mengajar']; ?></td>
                                    <td class="text-capitalize"><?= $kt['tgl_kgb']; ?></td>

                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
        </div>

        </section>

    </div>
</div>
<!-- </div> -->

<script>
    $(document).ready(function() {

        var table = $('#FDTable').DataTable({
            // dom: "Bfrtip",
            dom: '<?= $this->session->userdata('level') != '1' ? 'frtip' : 'Bfrtip' ?>',
            buttons: [
                'copy', 'excel'
                <?php if ($this->session->userdata('level') == '1') { ?>, {
                        extend: 'pdfHtml5',
                        text: 'PDF',
                        title: 'Data Kepegawaian\nSMK N 1 Parit Tiga',
                        pageSize: 'LEGAL',
                        orientation: 'landscape',
                        customize: function(doc) {
                            doc.defaultStyle.fontSize = 8;
                            doc.styles.tableHeader.fontSize = 8;
                            var objLayout = {};
                            objLayout['hLineWidth'] = function(i) {
                                return .8;
                            };
                            objLayout['vLineWidth'] = function(i) {
                                return .5;
                            };
                            objLayout['hLineColor'] = function(i) {
                                return '#aaa';
                            };
                            objLayout['vLineColor'] = function(i) {
                                return '#aaa';
                            };
                            objLayout['paddingLeft'] = function(i) {
                                return 8;
                            };
                            objLayout['paddingRight'] = function(i) {
                                return 8;
                            };
                            doc.content[0].layout = objLayout;
                        },
                        exportOptions: {
                            columns: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18]
                        },

                    },
                <?php } ?>

            ],

            responsive: true,
            select: true,

        });

    });
</script>