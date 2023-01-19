<?php
$thn = explode('-', $tanggal)[0];
$bln = (int)explode('-', $tanggal)[1];
$hari = (int)explode('-', $tanggal)[2];

$dayForDate = date("l", mktime(0, 0, 0, $hari, $bln, $thn));

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

    .red {
        background-color: #f2786f;
    }

    .yellow {
        background-color: #f2e96d;
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



                    <!-- <a type="button" onclick="printDiv('printableArea')" value="print a div!">Print<a> -->
                    <div class="card-body" id="printableArea">
                        <div class="col-lg-5">
                            <div class="form-group row">
                                <label for="tanggal" class="col-sm-6 col-lg-3 col-form-label">Tanggal</label>
                                <div class="col-lg-6">
                                    <input class="form-control" name="tanggal" id="tanggal" type="date" value="<?= $tanggal ?>">
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row">
                            
                        </div> -->
                        <table class="absensi" width="50%" style="margin-top: 10px">
                            <thead>
                                <tr>
                                    <th style="width: 50%" rowspan="">Nama Pegawai</th>
                                    <!-- <th scope="col">Tanggal</th> -->
                                    <th style="width: 25%" rowspan="">Pagi</th>
                                    <th style="width: 25%" rowspan="">Sore</th>
                                </tr>

                            </thead>

                            <?php
                            foreach ($absensi as $usr) {
                                echo "<tr class='edit' data-id='{$usr['id']}'> <td class='nama text-left'> {$usr['nama']} </td>";
                                $tmp_s = false;
                                $tmp_status = false;
                                if (!empty($usr['child'][$thn][$bln][$hari]['p'])) {
                                    $tmp_status = $usr['child'][$thn][$bln][$hari]['p']['st_absen'];
                                    if ($usr['child'][$thn][$bln][$hari]['p']['st_absen'] == 'h')
                                        echo '<td class=" green" >' . explode(' ', $usr['child'][$thn][$bln][$hari]['p']['rec_time'])[1] . '</td>';
                                    else {
                                        // if (!empty($usr['child'][$thn][$bln][$hari]['s']))
                                        $tmp_s = $usr['child'][$thn][$bln][$hari]['p']['st_absen'];
                                        echo '<td class=" yellow" >' .  $usr['child'][$thn][$bln][$hari]['p']['st_absen'] . '</td>';
                                    }
                                } else {
                                    echo '<td class=" red" data-ids="" data-idp="">-</td>';
                                }
                                if (!empty($usr['child'][$thn][$bln][$hari]['s']))
                                    echo '<td class=" green" >' . explode(' ', $usr['child'][$thn][$bln][$hari]['s']['rec_time'])[1] . '</td>';
                                else {
                                    echo '<td class="' . ($tmp_s ? 'yellow' : 'red') . '" >' . ($tmp_status ? $tmp_status : '-') . '</td>';
                                }
                                echo '</td>';
                                // if (!empty($usr['child'][$thn][$bln][$hari]['s']) && !empty($usr['child'][$thn][$bln][$i]['p']))
                                //     echo '<td class="edit green" data-ids="' . $usr['child'][$thn][$bln][$i]['s']['id_absen'] . '" data-idp="' . $usr['child'][$thn][$bln][$i]['p']['id_absen'] . '">.</td>';
                                // // echo (!empty($usr['child'][$thn][$bln][$i]['s']) && !empty($usr['child'][$thn][$bln][$i]['p']) ? '<td class="edit green" data-id="">.' : '<td class="edit red">a') . '</>';
                                // else {
                                //     echo '<td class="edit red" data-ids="" data-idp="">a</td>';
                                // }
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>
<div class="modal fade" id="absen_modal" tabindex="-3" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form opd="form" id="user_form" onsubmit="return false;" type="multipart" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title">
                        Form Absensi
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id_pegawai" name="id_pegawai">
                    <input class="form-control" id="nama_pegawai" name="" readonly>
                    <input type="hidden" id="tanggal" name="tanggal" value="<?= $tanggal ?>">
                    <hr>
                    <h2>Pagi</h2>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="nama">Status</label>
                                <select class="form-control " name="st_absen_p" id="st_absen_p" required>
                                    <option value="">-</option>
                                    <option value="h">Hadir</option>
                                    <option value="s">Sakit</option>
                                    <option value="i">Izin</option>
                                    <option value="dl">Dinas Lunas</option>
                                    <option value="a">Tidak Hadir</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="tanggal">Waktu Absensi</label>
                                <input type="hidden" placeholder="" class="form-control" id="id_p" name="id_p">
                                <input type="time" placeholder="" class="form-control" id="rec_time_p" name="rec_time_p">
                            </div>
                        </div>
                        <div class="col-lg-4" hidden>
                            <div class="form-group">
                                <label for="nama">Lampiran </label>
                                <input type="file" placeholder="" class="form-control" id="file_p" name="file_p" accept="application/pdf">
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h2>Sore</h2>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="nama">Status</label>
                                <select class="form-control " name="st_absen_s" id="st_absen_s">
                                    <option value="">-</option>
                                    <option value="h">Hadir</option>
                                    <option value="s">Sakit</option>
                                    <option value="i">Izin</option>
                                    <option value="dl">Dinas Lunas</option>
                                    <option value="a">Tidak Hadir</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="tanggal">Waktu Absensi</label>
                                <input type="hidden" placeholder="" class="form-control" id="id_s" name="id_s">
                                <input type="time" placeholder="" class="form-control" id="rec_time_s" name="rec_time_s">
                            </div>
                        </div>
                        <div class="col-lg-4" hidden>
                            <div class="form-group">
                                <label for="nama">Lampiran </label>
                                <input type="file" placeholder="" class="form-control" id="file_s" name="file_s" accept="application/pdf">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary" type="submit" id="save_edit_btn" data-loading-text="Loading..."><strong>Simpan </strong></button>
                    </div>
            </form>
        </div>
    </div>
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
        var dataAbsen = JSON.parse(`<?= json_encode($absensi) ?>`);
        var tanggal = $('#tanggal');
        tanggal.on('change', function() {
            location.href = "<?= base_url() ?>admin/absensi_harian?tanggal=" + tanggal.val();
        })

        var AbsenModal = {
            'self': $('#absen_modal'),
            'info': $('#absen_modal').find('.info'),
            'form': $('#absen_modal').find('#user_form'),
            'nama_pegawai': $('#absen_modal').find('#nama_pegawai'),
            'saveEditBtn': $('#absen_modal').find('#save_edit_btn'),
            'id_pegawai': $('#absen_modal').find('#id_pegawai'),
            'rec_time_p': $('#absen_modal').find('#rec_time_p'),
            'st_absen_p': $('#absen_modal').find('#st_absen_p'),
            'id_p': $('#absen_modal').find('#id_p'),
            'rec_time_s': $('#absen_modal').find('#rec_time_s'),
            'st_absen_s': $('#absen_modal').find('#st_absen_s'),
            'id_s': $('#absen_modal').find('#id_s'),
        }

        $('.edit').on('click', function() {
            <?php if ($this->session->userdata()['level'] == 1) { ?>
                var currentData = dataAbsen[$(this).data('id')];
                AbsenModal.self.modal('show')
                AbsenModal.form.trigger('reset');
                console.log(currentData);
                console.log('--1');
                console.log('--2');
                AbsenModal.id_pegawai.val(currentData['id']);
                AbsenModal.nama_pegawai.val(currentData['nama']);

                if ('undefined' !== typeof currentData['child']['<?= $thn ?>']['<?= $bln ?>']['<?= $hari ?>']['p']) {

                    AbsenModal.rec_time_p.val(currentData['child']['<?= $thn ?>']['<?= $bln ?>']['<?= $hari ?>']['p']['rec_time'].substr('11', 5));
                    AbsenModal.st_absen_p.val(currentData['child']['<?= $thn ?>']['<?= $bln ?>']['<?= $hari ?>']['p']['st_absen']);
                    AbsenModal.id_p.val(currentData['child']['<?= $thn ?>']['<?= $bln ?>']['<?= $hari ?>']['p']['id_absen']);
                } else {
                    AbsenModal.rec_time_p.val('');
                    AbsenModal.st_absen_p.val('');
                    AbsenModal.id_p.val('');
                }
                if ('undefined' !== typeof currentData['child']['<?= $thn ?>']['<?= $bln ?>']['<?= $hari ?>']['s']) {
                    AbsenModal.rec_time_s.val(currentData['child']['<?= $thn ?>']['<?= $bln ?>']['<?= $hari ?>']['s']['rec_time'].substr('11', 5));
                    AbsenModal.st_absen_s.val(currentData['child']['<?= $thn ?>']['<?= $bln ?>']['<?= $hari ?>']['s']['st_absen']);
                    AbsenModal.id_s.val(currentData['child']['<?= $thn ?>']['<?= $bln ?>']['<?= $hari ?>']['s']['id_absen']);
                } else {
                    AbsenModal.rec_time_s.val('');
                    AbsenModal.st_absen_s.val('');
                    AbsenModal.id_s.val('');
                }

                console.log(currentData['child']['<?= $thn ?>']['<?= $bln ?>']['<?= $hari ?>']['p']['rec_time'].substr('11'));
            <?php } ?>
        })

        AbsenModal.form.submit(function(event) {
            event.preventDefault();
            var url = "<?= base_url('admin/rec_absen') ?>";
            Swal.fire({
                title: "Apakah anda Yakin?",
                text: "Data Disimpan!",
                icon: "warning",
                allowOutsideClick: false,
                showCancelButton: true,
                buttons: {
                    cancel: 'Batal !!',
                    catch: {
                        text: "Ya, Saya Simpan !!",
                        value: true,
                    },
                },
            }).then((result) => {
                if (!result.isConfirmed) {
                    return;
                }
                $.ajax({
                    url: url,
                    'type': 'POST',
                    // data: AbsenModal.form.serialize(),
                    data: new FormData(AbsenModal.form[0]),
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        // buttonIdle(button);
                        var json = JSON.parse(data);
                        if (json['error']) {
                            Swal.fire("Simpan Gagal", json['message'], "error");
                            return;
                        }
                        Swal.fire("Simpan Berhasil", "", "success");
                        // location.reload();
                    },
                    error: function(e) {}
                });
            });
        });
    })
</script>