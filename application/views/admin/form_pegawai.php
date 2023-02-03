<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="<?= $form_url ?>">
                            <?php

                            $this_year = date('Y');

                            if ($this_year == '2022') {
                                $sisa_n = $pegawaiDetail['cuti_n'] - $pegawaiDetail['ct_n'];
                                $sisa_n1 = $pegawaiDetail['cuti_n1'] - $pegawaiDetail['ct_n2'];
                            } else if ($this_year >= '2023') {
                                $sisa_n = $ref_cuti['max_cuti'] - $pegawaiDetail['ct_n'];
                                $sisa_n1 = $pegawaiDetail['cuti_n'] - $pegawaiDetail['ct_n2'] - $pegawaiDetail['ct2_n'];
                            }

                            $days = 0;
                            if (!empty($pegawaiDetail['cuti_besar'])) {

                                $start_date           =       date('Y-m-d', strtotime($pegawaiDetail['cuti_besar']));
                                $get_start_date         =       new DateTime($start_date); // New date object
                                $get_end_date           =       date('Y-m-d');
                                $end_date               =       new DateTime($get_end_date); // New date object
                                $days                   =       $end_date->diff($get_start_date);
                                $days                   =       $days->format('%y');
                            }
                            if ($days >= 5) {
                                $ct_besar = "Anda berhak mengambil cuti besar, cuti besar terakhir tanggal " . $pegawaiDetail['cuti_besar'];
                            } else {
                                $ct_besar = "Anda tidak berhak mengambil cuti besar, cuti besar terakhir tanggal " . $pegawaiDetail['cuti_besar'];
                            }
                            if ($this->session->flashdata('error')) : ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong> <?= $this->session->flashdata('error'); ?></strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php endif; ?>
                            <div class=" form-row">
                                <div class="form-group col-md-2">
                                    <span><small style="color: red">Tahun <?= $this_year - 1 ?> Sisa <?= !empty($return['sisa_n1']) ? $return['sisa_n1']  : $sisa_n1; ?> hari</small></span>
                                </div>
                                <div class="form-group col-md-2">
                                    <span><small style="color: red">Tahun <?= $this_year ?> Sisa <?= !empty($return['sisa_n']) ? $return['sisa_n']  : $sisa_n; ?> hari</small></span>
                                </div>
                                <div class="form-group col-md-8">
                                    <span><small style="color: red"><?= $ct_besar ?></small></span>
                                </div>
                            </div>
                            <div class=" form-row">
                                <?php if ($this->session->userdata()['level'] == 'admin') { ?>

                                <?php } ?>
                                <div class="form-group col-md-2">
                                    <label for="gelar_depan">Gelar Depan</label>
                                    <input type="text" class="form-control" name="gelar_depan" value="<?= !empty($return['gelar_depan']) ? $return['gelar_depan']  : '';  ?>">
                                </div>

                                <div class="form-group col-md-8">
                                    <label for="username">Nama</label>
                                    <input type="text" class="form-control" name="nama" value="<?= !empty($return['nama']) ? $return['nama']  : '';  ?>" <?= $this->session->userdata()['level'] == '1'  ? '' : 'disabled' ?>>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="gelar_belakang">Gelar Belakang</label>
                                    <input type="text" class="form-control" name="gelar_belakang" value="<?= !empty($return['gelar_belakang']) ? $return['gelar_belakang']  : '';  ?>">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="nip">NIP</label>
                                    <input type="text" class="form-control" name="nip" value="<?= !empty($return['nip']) ? $return['nip']  : '';  ?>" <?= $this->session->userdata()['level'] == '1'  ? '' : 'disabled' ?>>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                    <select class="form-control" name="jenis_kelamin" <?= $this->session->userdata()['level'] == '1'  ? '' : 'disabled' ?>>
                                        <option disabled selected>-- Pilih --</option>
                                        <option value="L" <?= !empty($return['jenis_kelamin']) ? (($return['jenis_kelamin'] == 'L') ? 'selected'  : '')  : '';  ?>>Laki Laki</option>
                                        <option value="P" <?= !empty($return['jenis_kelamin']) ? (($return['jenis_kelamin'] == 'P') ? 'selected'  : '')  : '';  ?>>Perempuan</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="status">Status</label>
                                    <select class="form-control" name="status" <?= $this->session->userdata()['level'] == '1'  ? '' : 'disabled' ?>>
                                        <option disabled selected>-- Pilih --</option>
                                        <option value="1" <?= !empty($return['status']) ? (($return['status'] == '1') ? 'selected'  : '')  : '';  ?>>PNS</option>
                                        <option value="2" <?= !empty($return['status']) ? (($return['status'] == '2') ? 'selected'  : '')  : '';  ?>>PPPK</option>
                                        <option value="3" <?= !empty($return['status']) ? (($return['status'] == '3') ? 'selected'  : '')  : '';  ?>>GTT</option>
                                        <option value="4" <?= !empty($return['status']) ? (($return['status'] == '4') ? 'selected'  : '')  : '';  ?>>PTT</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="jenis_ptk">Jenis PTK</label>
                                    <select class="form-control" name="jenis_ptk" <?= $this->session->userdata()['level'] == '1'  ? '' : 'disabled' ?>>
                                        <option disabled selected>-- Pilih --</option>
                                        <?php
                                        foreach ($ref_ptk as $ptk) {
                                            echo "<option value='{$ptk['id_ptk']}' " . (!empty($return['jenis_ptk']) ? (($return['jenis_ptk'] == $ptk['id_ptk']) ? 'selected'  : '')  : '') . ">{$ptk['nama_ptk']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="tempat_lahir">Tempat Lahir</label>
                                    <input type="text" class="form-control" name="tempat_lahir" value="<?= !empty($return['tempat_lahir']) ? $return['tempat_lahir']  : '';  ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="tanggal_lahir">Tanggal Lahir</label>
                                    <input type="date" class="form-control" name="tanggal_lahir" value="<?= !empty($return['tanggal_lahir']) ? $return['tanggal_lahir']  : '';  ?>">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="jenjang">Jenjang</label>
                                    <input type="text" class="form-control" name="jenjang" value="<?= !empty($return['jenjang']) ? $return['jenjang']  : '';  ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="jurusan">Jurusan</label>
                                    <input type="text" class="form-control" name="jurusan" value="<?= !empty($return['jurusan']) ? $return['jurusan']  : '';  ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="tmt_kerja">TMT Kerja</label>
                                    <input type="date" class="form-control" name="tmt_kerja" value="<?= !empty($return['tmt_kerja']) ? $return['tmt_kerja']  : '';  ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="jabatan">Pangkat /Golongan</label>
                                    <input type="text" class="form-control" name="pangkat_gol" value="<?= !empty($return['pangkat_gol']) ? $return['pangkat_gol']  : '';  ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="jabatan">Jabatan</label>
                                    <input type="text" class="form-control" name="jabatan" value="<?= !empty($return['jabatan']) ? $return['jabatan']  : '';  ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="jabatan_tmt">Jabatan TMT</label>
                                    <input type="date" class="form-control" name="jabatan_tmt" value="<?= !empty($return['jabatan_tmt']) ? $return['jabatan_tmt']  : '';  ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="tugas_tambahan">Tugas Tambahan</label>
                                    <input type="text" class="form-control" name="tugas_tambahan" value="<?= !empty($return['tugas_tambahan']) ? $return['tugas_tambahan']  : '';  ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="mengajar">Mengajar</label>
                                    <input type="text" class="form-control" name="mengajar" value="<?= !empty($return['mengajar']) ? $return['mengajar']  : '';  ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="status">Status Sertifikasi</label>
                                    <select class="form-control" name="st_sertifikasi" <?= $this->session->userdata()['level'] == '1'  ? '' : 'disabled' ?>>
                                        <!-- <option disabled selected>-- Pilih --</option> -->
                                        <option value="N" <?= !empty($return['st_sertifikasi']) ? (($return['st_sertifikasi'] == 'N') ? 'selected'  : '')  : '';  ?>>Tidak</option>
                                        <option value="Y" <?= !empty($return['st_sertifikasi']) ? (($return['st_sertifikasi'] == 'Y') ? 'selected'  : '')  : '';  ?>>Ya</option>
                                        <option value="P" <?= !empty($return['st_sertifikasi']) ? (($return['st_sertifikasi'] == 'P') ? 'selected'  : '')  : '';  ?>>Berhak Mengajukan</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="tgl_kgb">Tgl Kenaikan Gaji Berkala Trakhir</label>
                                    <input type="date" class="form-control" name="tgl_kgb" value="<?= !empty($return['tgl_kgb']) ? $return['tgl_kgb']  : '';  ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="tgl_kgb">Tgl Cuti Besar Trakhir</label>
                                    <input type="date" class="form-control" name="cuti_besar" value="<?= !empty($return['cuti_besar']) ? $return['cuti_besar']  : '';  ?>">
                                </div>
                            </div>
                            <div class="form-row">
                                <?php if ($this->session->userdata()['level'] == '1') { ?>
                                    <div class="form-group col-md-4" hidden>
                                        <label for="cuti_n1">Sisa Cuti 2021</label>
                                        <input type="number" class="form-control" name="cuti_n1" value="<?= !empty($return['cuti_n1']) ? $return['cuti_n1']  : '';  ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="cuti_n">Sisa Cuti 2022</label>
                                        <input type="number" class="form-control" name="cuti_n" value="<?= !empty($return['cuti_n']) ? $return['cuti_n']  : '';  ?>">
                                    </div>
                                <?php } ?>
                            </div>
                            <!-- </div> -->
                            <button type="submit" class="btn btn-primary float-right">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>