<!-- Main Content -->
<style>
    .readonly-bg-white {
        background-color: white !important;
    }
</style>
<div class="main-content">
    <section class="section">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class=" form-row">
                            <div class="form-group col-md-2">
                                <label for="gelar_depan">Gelar Depan</label>
                                <input type="text" class="form-control readonly-bg-white" readonly value="<?= !empty($return['gelar_depan']) ? $return['gelar_depan']  : '';  ?>">
                            </div>

                            <div class="form-group col-md-8">
                                <label for="username">Nama</label>
                                <input type="text" class="form-control readonly-bg-white" readonly name="nama" value="<?= !empty($return['nama']) ? $return['nama']  : '';  ?>">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="gelar_belakang">Gelar Belakang</label>
                                <input type="text" class="form-control readonly-bg-white" readonly name="gelar_belakang" value="<?= !empty($return['gelar_belakang']) ? $return['gelar_belakang']  : '';  ?>">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="nip">NIP</label>
                                <input type="text" class="form-control readonly-bg-white" readonly name="nip" value="<?= !empty($return['nip']) ? $return['nip']  : '';  ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                <input type="text" class="form-control readonly-bg-white" readonly value="<?= !empty($return['jenis_kelamin']) ? ($return['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan') : '' ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="status">Status</label>
                                <input type="text" class="form-control readonly-bg-white" readonly value="<?= !empty($return['nama_status']) ? $return['nama_status'] : '' ?>">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="jenis_ptk">Jenis PTK</label>
                                <input type="text" class="form-control readonly-bg-white" readonly value="<?= !empty($return['nama_ptk']) ? $return['nama_ptk'] : '' ?>">

                            </div>
                            <div class="form-group col-md-6">
                                <label for="tempat_lahir">Tempat Lahir</label>
                                <input type="text" class="form-control readonly-bg-white" readonly name="tempat_lahir" value="<?= !empty($return['tempat_lahir']) ? $return['tempat_lahir']  : '';  ?>" disabled>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="tanggal_lahir">Tanggal Lahir</label>
                                <input type="text" class="form-control readonly-bg-white" readonly name="tanggal_lahir" value="<?= !empty($return['tanggal_lahir']) ? $return['tanggal_lahir']  : '';  ?>">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="jenjang">Jenjang</label>
                                <input type="text" class="form-control readonly-bg-white" readonly name="jenjang" value="<?= !empty($return['jenjang']) ? $return['jenjang']  : '';  ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="jurusan">Jurusan</label>
                                <input type="text" class="form-control readonly-bg-white" readonly name="jurusan" value="<?= !empty($return['jurusan']) ? $return['jurusan']  : '';  ?>">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="tmt_kerja">TMT Kerja</label>
                                <input type="text" class="form-control readonly-bg-white" readonly name="tmt_kerja" value="<?= !empty($return['tmt_kerja']) ? $return['tmt_kerja']  : '';  ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="jabatan">Pangkat /Golongan</label>
                                <input type="text" class="form-control readonly-bg-white" readonly name="pangkat_gol" value="<?= !empty($return['pangkat_gol']) ? $return['pangkat_gol']  : '';  ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="jabatan">Jabatan</label>
                                <input type="text" class="form-control readonly-bg-white" readonly name="jabatan" value="<?= !empty($return['jabatan']) ? $return['jabatan']  : '';  ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="jabatan_tmt">Jabatan TMT</label>
                                <input type="text" class="form-control readonly-bg-white" readonly name="jabatan_tmt" value="<?= !empty($return['jabatan_tmt']) ? $return['jabatan_tmt']  : '';  ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="tugas_tambahan">Tugas Tambahan</label>
                                <input type="text" class="form-control readonly-bg-white" readonly name="tugas_tambahan" value="<?= !empty($return['tugas_tambahan']) ? $return['tugas_tambahan']  : '';  ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="mengajar">Mengajar</label>
                                <input type="text" class="form-control readonly-bg-white" readonly name="mengajar" value="<?= !empty($return['mengajar']) ? $return['mengajar']  : '';  ?>">
                            </div>
                            <?php if (!empty($return['status'])) {
                                if ($return['status'] == 1) {
                            ?>
                                    <div class="form-group col-md-6">
                                        <label for="status">Status Sertifikasi</label>
                                        <input type="text" class="form-control readonly-bg-white" readonly name="mengajar" value="<?php if (!empty($return['st_sertifikasi'])) {
                                                                                                                                        if ($return['st_sertifikasi'] == 'N')
                                                                                                                                            echo  'Tidak';
                                                                                                                                        if ($return['st_sertifikasi'] == 'Y')
                                                                                                                                            echo  'Ya';
                                                                                                                                        if ($return['st_sertifikasi'] == 'P')
                                                                                                                                            echo  'Berkah Mengajukan';
                                                                                                                                    } ?>">


                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="tgl_kgb">Tgl Kenaikan Gaji Berkala Trakhir</label>
                                        <input type="text" class="form-control readonly-bg-white" readonly name="tgl_kgb" value="<?= !empty($return['tgl_kgb']) ? $return['tgl_kgb']  : '';  ?>">
                                    </div>
                            <?php }
                            } ?>
                        </div>
                        <div class="form-row">
                            <?php if ($this->session->userdata()['level'] == '1') { ?>
                                <div class="form-group col-md-4">
                                    <label for="cuti_n1">Sisa Cuti 2021</label>
                                    <input type="number" class="form-control readonly-bg-white" readonly name="cuti_n1" value="<?= !empty($return['cuti_n1']) ? $return['cuti_n1']  : '';  ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="cuti_n">Sisa Cuti 2022</label>
                                    <input type="number" class="form-control readonly-bg-white" readonly name="cuti_n" value="<?= !empty($return['cuti_n']) ? $return['cuti_n']  : '';  ?>">
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>