<?php
// $thn = 2022;
// $bln = 10;
// $date = '2009-10-22';
// $sepparator = '-';
// $parts = explode($sepparator, $date);

// new

$thn = $tahun;
$bln = (int) $bulan;
$dayForDate = date("l", mktime(0, 0, 0, 1, $bln, $thn));

$jlh_hari_kerja = 0;
$td_tgl = '';
$arr_tgl = [];
for ($i = 1; $i < 31; $i++) {
    $hari = date("l", mktime(0, 0, 0, $bln, $i, $thn));
    if ($hari != 'Saturday' &&  $hari != 'Sunday' && $hari != '-') {
        array_push($arr_tgl, $i);
        $jlh_hari_kerja++;
        $td_tgl .=  "<td class='goto' data-tgl='{$i}'> {$i}</td>";
    }
}
?>
<style>
    .absensi,
    td {
        border: 1px solid;
        /* min-width: 30px; */
        /* background-color: yellow; */
    }

    .green {
        background-color: #97f7ad;
    }

    .red {
        background-color: #f2786f;
    }

    .yellow {
        background-color: #f2e96d;
    }
</style>
<div class="main-content">
    <section class="section">
        <div class="row mt-5">
            <div class="col-lg-12 mt-2">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="tanggal" class="col-sm-2 col-form-label">Bulan / Tahun :</label>
                            <div class="col-lg-3">
                                <input class="form-control" name="bulan" id="bulan" type="month" value="<?= $thn . '-' . str_pad($bln, 2, '0', STR_PAD_LEFT)  ?>">
                            </div>
                        </div>
                        <table class="table table-hover table-bordered" style="margin-top: 10px">
                            <thead>
                                <tr>
                                    <th width="50px">Hari</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Pagi</th>
                                    <th scope="col">Sore</th>

                                </tr>
                            </thead>

                            <?php
                            foreach ($absensi as $key => $usr) {
                                $absensi[$key]['h'] = 0;
                                $absensi[$key]['htf'] = 0;
                                $absensi[$key]['i'] = 0;
                                $absensi[$key]['s'] = 0;
                                $absensi[$key]['c'] = 0;
                                $absensi[$key]['dl'] = 0;

                                for ($i = 1; $i < 31; $i++) {
                                    $hari = date("l", mktime(0, 0, 0, $bln, $i, $thn));
                                    if ($hari != 'Saturday' &&  $hari != 'Sunday' && $hari != '-') {
                                        array_push($arr_tgl, $i);
                                        $jlh_hari_kerja++;
                                        $td_tgl .=  "<td class='goto' data-tgl='{$i}'> {$i}</td>";

                                        echo '  <tr>
                                <td> ' . convertDayInd($hari) . '</td>
                                <td> ' . $i . '-' . $bln . '-' . $thn . '</td>
                                ';
                                        if (!empty($usr['child'][$thn][$bln][$i]['s']) && !empty($usr['child'][$thn][$bln][$i]['p'])) {
                                            if ($usr['child'][$thn][$bln][$i]['p']['st_absen'] == 'h' && $usr['child'][$thn][$bln][$i]['s']['st_absen'] == 'h') {
                                                $absensi[$key]['h']++;
                                                echo '<td class="green">Hadir</td><td class="green">Hadir</td>';
                                            } else {
                                                if ($usr['child'][$thn][$bln][$i]['p']['st_absen'] == 'h' || $usr['child'][$thn][$bln][$i]['s']['st_absen'] == 'h') {
                                                    $absensi[$key]['htf']++;
                                                    if ($usr['child'][$thn][$bln][$i]['p'] == 'h')
                                                        echo '<td class="green">Hadir</td>';
                                                    else
                                                        echo '<td class="yellow">' . $usr['child'][$thn][$bln][$i]['p']['st_absen'] . '</td>';

                                                    if ($usr['child'][$thn][$bln][$i]['s'] == 'h')
                                                        echo '<td class="green">Hadir</td>';
                                                    else
                                                        echo '<td class="yellow">' . $usr['child'][$thn][$bln][$i]['p']['st_absen'] . '</td>';
                                                } else {
                                                    if (!empty($usr['child'][$thn][$bln][$i]['p'])) {
                                                        if ($usr['child'][$thn][$bln][$i]['p']['st_absen'] == 'i') {
                                                            $absensi[$key]['i']++;
                                                            echo '<td class="yellow">Izin</td><td class="yellow">Izin</td>';
                                                        } else
                                                    if ($usr['child'][$thn][$bln][$i]['p']['st_absen'] == 's') {
                                                            $absensi[$key]['s']++;
                                                            echo '<td class="yellow">Sakit</td><td class="yellow">Sakit</td>';
                                                        } else
                                                    if ($usr['child'][$thn][$bln][$i]['p']['st_absen'] == 'dl') {
                                                            $absensi[$key]['dl']++;
                                                            echo '<td class="yellow">Dinas Luar</td><td class="yellow">Dinas Luar</td>';
                                                        } else
                                                    if ($usr['child'][$thn][$bln][$i]['p']['st_absen'] == 'c') {
                                                            $absensi[$key]['c']++;
                                                            echo '<td class="yellow">Cuti</td><td class="yellow">Cuti</td>';
                                                        } else {
                                                            echo '<td class="red">' . $usr['child'][$thn][$bln][$i]['p']['st_absen'] . '</td><td class="red">' . $usr['child'][$thn][$bln][$i]['s']['st_absen'] . '</td>';
                                                        }
                                                    }
                                                }
                                            }
                                        } else {
                                            if (!empty($usr['child'][$thn][$bln][$i]['p'])) {
                                                if ($usr['child'][$thn][$bln][$i]['p']['st_absen'] == 'i') {
                                                    $absensi[$key]['i']++;
                                                    echo '<td class="yellow">Izin</td><td class="yellow">Izin</td>';
                                                } else
                                            if ($usr['child'][$thn][$bln][$i]['p']['st_absen'] == 's') {
                                                    $absensi[$key]['s']++;
                                                    echo '<td class="yellow">Sakit</td><td class="yellow">Sakit</td>';
                                                } else
                                            if ($usr['child'][$thn][$bln][$i]['p']['st_absen'] == 'dl') {
                                                    $absensi[$key]['dl']++;
                                                    echo '<td class="yellow">Dinas Luar</td><td class="yellow">Dinas Luar</td>';
                                                } else
                                            if ($usr['child'][$thn][$bln][$i]['p']['st_absen'] == 'c') {
                                                    $absensi[$key]['c']++;
                                                    echo '<td class="yellow">Cuti</td><td class="yellow">Cuti</td>';
                                                } else
                                            if ($usr['child'][$thn][$bln][$i]['p']['st_absen'] == 'h') {
                                                    echo '<td class="green">Hadir</td>';
                                                    $absensi[$key]['htf']++;
                                                    if (!empty($usr['child'][$thn][$bln][$i]['s']['st_absen'])) {
                                                        // $absensi[$key]['h']++;
                                                        echo '<td class="yellow">' . $usr['child'][$thn][$bln][$i]['s']['st_absen'] . '</td>';
                                                    } else {
                                                        echo '<td class="yellow">Tanpa Keterangan</td>';
                                                    }
                                                }
                                            } else {
                                                echo '<td class="red">Tanpa Keterangan</td><td class="red">Tanpa Keterangan</td>';
                                            }
                                        }
                                    }
                                }
                            } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>

<script>
    $(document).ready(function() {
        var bulan = $('#bulan');
        bulan.on('change', function() {
            location.href = "<?= base_url() ?>pegawai/absensi?bulan=" + bulan.val();
        })
    })
</script>