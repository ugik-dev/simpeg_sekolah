<?php
$thn = explode('-', $bulan)[0];
$bln = explode('-', $bulan)[1];

$jlh_hari_kerja = 0;
$td_tgl = '';
$arr_tgl = [];
for ($i = 1; $i < 31; $i++) {
    $hari = date("l", mktime(0, 0, 0, $bln, $i, $thn));
    // deteksi hari kerja
    // $hari != 'Saturday' && :untuk hari sabtu 
    if ($hari != 'Saturday' &&  $hari != 'Sunday' && $hari != '-') {
        array_push($arr_tgl, $i);
        $jlh_hari_kerja++;
        $td_tgl .=  "<td class='goto' data-tgl='{$i}'> {$i}</td>";
    }
}
?>

<style>
    .absensi,
    th {
        border: 1px solid;
        width: 100%;
        text-align: center;
    }

    .absensi,
    td {
        border: 1px solid;
        min-width: 30px;
        /* background-color: yellow; */
    }

    .green {
        background-color: #97f7ad;
    }

    .yellow {
        background-color: #f2e96d;
    }

    .red {
        background-color: #f2786f;
    }

    .absensi .nama {
        /* border: 1; */
        width: 100px;
        /* background-color: yellow; */
    }
</style>
<div class="main-content">
    <section class="section">
        <div class="row mt-5">
            <div class="col-lg-12 mt-2">
                <div class="card">
                    <button <?= $this->session->userdata()['level'] == 1 ? '' : 'hidden' ?> id="sync_btn" class="btn btn-primary mb-3">
                        Singkronkan dengan mesin
                    </button>

                    <div class="card-body" id="printableArea">
                        <div class="col-lg-12">
                            <div class="form-group row">
                                <label for="tanggal" class="col-sm-2 col-form-label">Bulan / Tahun :</label>
                                <div class="col-lg-3">
                                    <input class="form-control" name="bulan" id="bulan" type="month" value="<?= $thn . '-' . $bln ?>">
                                </div>
                            </div>
                            <div class="form-group row" <?= $this->session->userdata('level') != '1' ? 'hidden' : '' ?>>
                                <a class="btn btn-primary active" href=<?= base_url('admin/print_absensi_bulanan?bulan=' . $bulan) ?>><i class="fa fa-print mr-2"></i>Export PDF</a>
                            </div>
                        </div>
                        <hr>
                        Tahun : <?= $thn ?><br>
                        Bulan : <?= $bln ?>

                        <table class="absensi" style="margin-top: 10px">
                            <thead>
                                <tr>
                                    <th width="50px" rowspan="2">Nama Pegawai</th>
                                    <!-- <th scope="col">Tanggal</th> -->
                                    <!-- <th scope="col" rowspan="2">Pagi / Sore</th> -->
                                    <!-- <th scope="col" rowspan="2">Sore</th> -->
                                    <th scope="col" class="goto" colspan="<?= $jlh_hari_kerja ?>">Tanggal</th>
                                </tr>
                                <tr>
                                    <?= $td_tgl ?>
                                </tr>

                            </thead>

                            <?php
                            foreach ($absensi as $key => $usr) {
                                echo "<tr> <td class='nama text-left'> {$usr['nama']} </td>";
                                $absensi[$key]['h'] = 0;
                                $absensi[$key]['htf'] = 0;
                                $absensi[$key]['i'] = 0;
                                $absensi[$key]['s'] = 0;
                                $absensi[$key]['c'] = 0;
                                $absensi[$key]['dl'] = 0;
                                foreach ($arr_tgl as $i) {
                                    if (!empty($usr['child'][$thn][$bln][$i]['s']) && !empty($usr['child'][$thn][$bln][$i]['p'])) {

                                        $absensi[$key]['h']++;
                                        echo '<td class="edit green" data-ids="' . $usr['child'][$thn][$bln][$i]['s']['id_absen'] . '" data-idp="' . $usr['child'][$thn][$bln][$i]['p']['id_absen'] . '">.</td>';
                                    }
                                    // echo (!empty($usr['child'][$thn][$bln][$i]['s']) && !empty($usr['child'][$thn][$bln][$i]['p']) ? '<td class="edit green" data-id="">.' : '<td class="edit red">a') . '</>';
                                    else if (!empty($usr['child'][$thn][$bln][$i]['p'])) {
                                        if ($usr['child'][$thn][$bln][$i]['p']['st_absen'] == 'i')
                                            $absensi[$key]['i']++;
                                        if ($usr['child'][$thn][$bln][$i]['p']['st_absen'] == 's')
                                            $absensi[$key]['s']++;
                                        if ($usr['child'][$thn][$bln][$i]['p']['st_absen'] == 'dl')
                                            $absensi[$key]['dl']++;
                                        if ($usr['child'][$thn][$bln][$i]['p']['st_absen'] == 'c')
                                            $absensi[$key]['c']++;
                                        if ($usr['child'][$thn][$bln][$i]['p']['st_absen'] == 'h')
                                            $absensi[$key]['htf']++;
                                        echo '<td class="yellow">' . $usr['child'][$thn][$bln][$i]['p']['st_absen'] . '</td>';
                                    } else {
                                        echo '<td class="edit red" data-ids="" data-idp="">a</td>';
                                    }
                                }
                                echo '</tr>';
                            }
                            ?>
                        </table>

                        <table class="absensi" style="margin-top: 10px">
                            <thead>
                                <tr>
                                    <th style="width: 10px">No</th>
                                    <th style="width: 500px !important">Nama Pegawai</th>
                                    <th style="width: 200px">Jabatan</th>
                                    <th style="width: 90px">Jumlah Hari Kerja</th>
                                    <th style="width: 90px">Hadir</th>
                                    <th style="width: 90px">Hadir Tidak Full</th>
                                    <th style="width: 90px">Izin</th>
                                    <th style="width: 90px">Sakit</th>
                                    <th style="width: 90px">Cuti</th>
                                    <th style="width: 90px">Dinas Luar</th>
                                    <th style="width: 90px">Tidak Hadir Termasuk DL</th>
                                    <!-- <th scope="col" class="goto" colspan="<?= $jlh_hari_kerja ?>">Tanggal</th> -->
                                </tr>
                                <!-- <tr>

                                </tr> -->

                            </thead>

                            <?php
                            $i = 1;
                            foreach ($absensi as $key => $usr) {
                                $ttl = $usr['dl'] + $usr['i'] + $usr['s'] + $usr['c'];
                                echo " <tr>
                                <td class='text-left'> {$i} </td>
                                <td class=' text-left'> {$usr['nama']} </td> 
                                <td class=' text-left'> {$usr['nama_ptk']} </td>
                                <td class=' text-center'> {$jlh_hari_kerja} </td>
                                <td class=' text-center'> {$usr['h']} </td>
                                <td class=' text-center'> {$usr['htf']} </td>
                                <td class=' text-center'> {$usr['i']} </td>
                                <td class=' text-center'> {$usr['s']} </td>
                                <td class=' text-center'> {$usr['c']} </td>
                                <td class=' text-center'> {$usr['dl']} </td>
                                <td class=' text-center'> {$ttl} </td></td>";
                                $i++;
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>

<script>
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        console.log(printContents)
        window.print();

        document.body.innerHTML = originalContents;
    }
    $(document).ready(function() {
        $('.goto').on('click', function() {
            location.href = "<?= base_url() ?>admin/absensi_harian?tanggal=<?= $thn . '-' . $bln ?>-" + $(this).data('tgl');
        })

        var bulan = $('#bulan');
        bulan.on('change', function() {
            location.href = "<?= base_url() ?>admin/absensi_bulanan?bulan=" + bulan.val();
        })

        $('#sync_btn').on('click', function() {
            Swal.fire({
                title: 'Loading.!',
                html: 'Sedang singkronisasi dengan data mesin.',
            })
            Swal.showLoading()
            $.ajax({
                url: "<?= base_url('two/soap.php') ?>",
                // 'type': 'POST',
                // data: BankModal.form.serialize(),
                data: {},
                success: function(data) {
                    Swal.close();
                    var json = JSON.parse(data);
                    if (json['error']) {
                        Swal.fire("Singkroninasi Gagal", json['message'], "error");
                        return;
                    }
                    Swal.fire("Singkronisasi Berhasil", "", "success");
                },
                error: function(e) {}
            });
        })

    })
</script>