<div class="main-content">
    <section class="section">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="<?= $form_url ?>">
                            <div class=" flash-data" data-flashdata="<?= $this->session->flashdata('pesan'); ?>">
                            </div>
                            <?php
                            $this_year = date('Y');
                            if ($this_year == '2022') {
                                $sisa_n = $pegawai['cuti_n'] -
                                    $pegawai['ct_n'];
                                $sisa_n1 = $pegawai['cuti_n1'] -
                                    $pegawai['ct_n2'];
                            } else
                                if ($this_year == '2023') {
                                $sisa_n = 12 -
                                    $pegawai['ct_n'];
                                $sisa_n1 = $pegawai['cuti_n'] -
                                    $pegawai['ct_n2'] - $pegawai['ct2_n'];
                            }


                            if ($this->session->flashdata('error')) : ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong> <?= $this->session->flashdata('error'); ?></strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php endif; ?> <div class=" form-row">
                                <input type="hidden" class="form-control" name="id_cuti" value="<?= !empty($return['id_cuti']) ? $return['id_cuti']  : '';  ?>">

                                <div class=" form-group col-md-12">
                                    <label for="jenis">Jenis Cuti</label>
                                    <select class="form-control" id="jenis" name="jenis" required>
                                        <option disabled selected>Pilih Jenis Cuti</option>
                                        <option value="1" <?= !empty($return['jenis']) ? (($return['jenis'] == '1') ? 'selected'  : '')  : '';  ?>>Cuti Tahunan</option>
                                        <option value="2" <?= !empty($return['jenis']) ? (($return['jenis'] == '2') ? 'selected'  : '')  : '';  ?>>Cuti Besar</option>
                                        <option value="3" <?= !empty($return['jenis']) ? (($return['jenis'] == '3') ? 'selected'  : '')  : '';  ?>>Cuti Sakit </option>
                                        <option value="4" <?= !empty($return['jenis']) ? (($return['jenis'] == '4') ? 'selected'  : '')  : '';  ?>>Cuti Melahirkan</option>
                                        <option value="5" <?= !empty($return['jenis']) ? (($return['jenis'] == '5') ? 'selected'  : '')  : '';  ?>>Cuti Karena Alasan Penting,</option>
                                        <option value="6" <?= !empty($return['jenis']) ? (($return['jenis'] == '6') ? 'selected'  : '')  : '';  ?>>Cuti di Luar Tanggungan Negara</option>
                                    </select>
                                </div>


                                <div class="col-lg-12" id="layout_sisa_cuti">
                                    <label for="lama">Sisa Cuti yang digunakan</label>
                                    <div class="row">
                                        <?php
                                        $this_year = date('Y');
                                        $sisa_n = 12 - $pegawai['ct_n'];
                                        $sisa_n1 = $pegawai['cuti_n'] - $pegawai['ct_n2'] - $pegawai['ct2_n'];

                                        ?>
                                        <div class="form-group col-md-6">
                                            <span><small style="color: red">Tahun <?= $this_year - 1 ?> Sisa <?= !empty($return['sisa_n1']) ? $return['sisa_n1']  : $sisa_n1; ?> hari</small></span>
                                            <input type="number" class="form-control" id="n1" name="n1" value="<?= !empty($return['n1']) ? $return['n1']  : '0';  ?>" required>
                                            <input type="hidden" class="form-control" id="sisa_n1" name="sisa_n1" value="<?= !empty($return['sisa_n1']) ? $return['sisa_n1']  : $sisa_n1;  ?>" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <span><small style="color: red">Tahun <?= $this_year ?> Sisa <?= !empty($return['sisa_n']) ? $return['sisa_n']  : $sisa_n; ?> hari</small></span>
                                            <input type="number" class="form-control" id="n" name="n" value="<?= !empty($return['n']) ? $return['n']  : '0';  ?>" required>
                                            <input type="hidden" class="form-control" id="sisa_n" name="sisa_n" value="<?= !empty($return['sisa_n']) ? $return['sisa_n']  : $sisa_n;  ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label for="lama">Lama Cuti</label>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <input type="number" class="form-control" name="lama" value="<?= !empty($return['lama']) ? $return['lama']  : '';  ?>" required>
                                        </div>
                                        <div class=" form-group col-md-6">
                                            <select class="form-control" name="satuan" required>
                                                <option value="hari" <?= !empty($return['satuan']) ? (($return['satuan'] == 'hari') ? 'selected'  : '')  : '';  ?>>hari</option>
                                                <option value="bulan" <?= !empty($return['satuan']) ? (($return['satuan'] == 'bulan') ? 'selected'  : '')  : '';  ?>>bulan</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label for="lama">Tanggal</label>
                                    <div class="row">
                                        <div class="form-group col-md-5">
                                            <input type="date" class="form-control" name="dari" value="<?= !empty($return['dari']) ? $return['dari']  : '';  ?>" required>
                                        </div>

                                        <div class="form-group col align-middle">
                                            <span><b>sampai</b></span>
                                        </div>
                                        <div class="form-group col-md-5">
                                            <input type="date" class="form-control" name="sampai" value="<?= !empty($return['sampai']) ? $return['sampai']  : '';  ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        var jenis = $('#jenis')
                                        jenis.on('change', function() {
                                            if (jenis.val() == 1) {
                                                $('#layout_sisa_cuti').show();
                                                $('#n').val('<?= !empty($return['n']) ? $return['n']  : '0';  ?>')
                                                $('#n1').val('<?= !empty($return['n1']) ? $return['n1']  : '0';  ?>')
                                                $('#n2').val('<?= !empty($return['n2']) ? $return['n2']  : '0';  ?>')
                                            } else {
                                                $('#layout_sisa_cuti').hide();
                                                $('#n').val('0')
                                                $('#n1').val('0')
                                                $('#n2').val('0')
                                            }

                                            <?php

                                            if (!empty($pegawai['cuti_besar'])) {

                                                $start_date           =       date('Y-m-d', strtotime($pegawai['cuti_besar']));
                                                $get_start_date         =       new DateTime($start_date); // New date object
                                                $get_end_date           =       date('Y-m-d');
                                                $end_date               =       new DateTime($get_end_date); // New date object
                                                $days                   =       $end_date->diff($get_start_date);
                                                $days                   =       $days->format('%y');
                                            } else {
                                                $days = 0;
                                            }

                                            if ($days < 5 || empty($pegawai['cuti_besar'])) {
                                            ?>
                                                if (jenis.val() == 2) {
                                                    console.log('tidak berhak cuti besar')
                                                    jenis.val('');
                                                    Swal.fire("Gagal", 'anda tidak berhak mengambil cuti besar, cuti besar terakhir tanggal <?= $pegawai['cuti_besar'] ?>', "error");

                                                }
                                            <?php
                                            }
                                            ?>
                                        })

                                        jenis.trigger('change');
                                    });
                                </script>
                                <div class="form-group col-md-12">
                                    <label for="alasan">Alasan</label>
                                    <input type="text" class="form-control" name="alasan" value="<?= !empty($return['alasan']) ? $return['alasan']  : '';  ?>">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="alamat_cuti">Alamat Selama Menjalankan Cuti</label>
                                    <input type="text" class="form-control" name="alamat_cuti" value="<?= !empty($return['alamat_cuti']) ? $return['alamat_cuti']  : '';  ?>" required>
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

<script></script>