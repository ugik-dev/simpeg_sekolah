<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="row mt-5">
                    <div class="col-lg-12 mt-2">
                        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('pesan'); ?>"></div>

                        <?php if ($this->session->flashdata('error')) : ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong> <?= $this->session->flashdata('error'); ?></strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>
                        <div class="dropdown mb-3">

                            <button <?= $this->session->userdata('level') != '1' ? 'hidden' : '' ?> class="col-lg-12 btn btn-secondary dropdown-toggle mb-3" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Filters
                            </button>
                            <div class="dropdown-menu col-lg-12 mb-3" style="width: 100%" aria-labelledby="dropdownMenu2">
                                <div class="col-lg-12">
                                    <form method="get">
                                        <div class="form-row">
                                            <div class="form-group col-lg-6">
                                                <label for="inputEmail4">Tanggal Cuti</label>
                                                <div class="row">
                                                    <div class="col">
                                                        <input type="date" name="tgl_start" value="<?= !empty($filter['tgl_start']) ? $filter['tgl_start'] : '' ?>" class="form-control" placeholder="">
                                                    </div>
                                                    <div class="">
                                                        <p>s.d</p>
                                                    </div>
                                                    <div class="col">
                                                        <input type="date" name="tgl_end" value="<?= !empty($filter['tgl_end']) ? $filter['tgl_end'] : '' ?>" class="form-control" placeholder="">
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="inputEmail4">Jenis Cuti</label>
                                                <select class="form-control" name="jenis_cuti">
                                                    <option value="">Semua</option>
                                                    <option value="1" <?= !empty($filter['jenis_cuti']) ? ($filter['jenis_cuti'] == '1' ? 'selected' : '') : '' ?>>Cuti Tahunan</option>
                                                    <option value="2" <?= !empty($filter['jenis_cuti']) ? ($filter['jenis_cuti'] == '2' ? 'selected' : '') : '' ?>>Cuti Besar</option>
                                                    <option value="3" <?= !empty($filter['jenis_cuti']) ? ($filter['jenis_cuti'] == '3' ? 'selected' : '') : '' ?>>Cuti Sakit</option>
                                                    <option value="4" <?= !empty($filter['jenis_cuti']) ? ($filter['jenis_cuti'] == '4' ? 'selected' : '') : '' ?>>Cuti Melahirkan</option>
                                                    <option value="5" <?= !empty($filter['jenis_cuti']) ? ($filter['jenis_cuti'] == '5' ? 'selected' : '') : '' ?>>Cuti Karena Alasan Penting</option>
                                                    <option value="6" <?= !empty($filter['jenis_cuti']) ? ($filter['jenis_cuti'] == '6' ? 'selected' : '') : '' ?>>Cuti di Luar Tangguhan Negara</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="inputEmail4">Status</label>
                                                <select class="form-control" name="status_cuti">
                                                    <option value="">Semua</option>
                                                    <option value="pengajuan" <?= !empty($filter['status_cuti']) ? ($filter['status_cuti'] == 'pengajuan' ? 'selected' : '') : '' ?>>sedang mengajukan</option>
                                                    <option value="acc_adm" <?= !empty($filter['status_cuti']) ? ($filter['status_cuti'] == 'acc_adm' ? 'selected' : '') : '' ?>>Acc Admin</option>
                                                    <option value="tol_adm" <?= !empty($filter['status_cuti']) ? ($filter['status_cuti'] == 'tol_adm' ? 'selected' : '') : '' ?>>Tolak Admin</option>
                                                    <option value="rev_adm" <?= !empty($filter['status_cuti']) ? ($filter['status_cuti'] == 'rev_adm' ? 'selected' : '') : '' ?>>Revisi Admin</option>
                                                    <option value="acc_kepsek" <?= !empty($filter['status_cuti']) ? ($filter['status_cuti'] == 'acc_kepsek' ? 'selected' : '') : '' ?>>Acc Kepala Sekolah</option>
                                                    <option value="tol_kepsek" <?= !empty($filter['status_cuti']) ? ($filter['status_cuti'] == 'tol_kepsek' ? 'selected' : '') : '' ?>>Tolak Kepala Sekolah</option>
                                                    <option value="rev_kepsek" <?= !empty($filter['status_cuti']) ? ($filter['status_cuti'] == 'rev_kepsek' ? 'selected' : '') : '' ?>>Revisi Kepala Sekolah</option>
                                                </select>
                                            </div>

                                            <div class="col-lg-12">

                                                <div class="btn-group mr-2 mb-4" role="group" aria-label="First group">
                                                    <button type="submit" class="btn btn-info"><i class="fa fa-search mr-2"></i>Cari</button>
                                                    <a href="<?= base_url($link_reset) ?>" class="btn btn-secondary">Reset <i class="fa fa-refresh  ml-2"></i></a>
                                                </div>
                                            </div>

                                    </form>
                                </div>


                            </div>
                        </div>

                        <table class="table table-hover table-bordered" id="FDTable" style="margin-top: 10px">
                            <thead>
                                <tr>
                                    <th width="50px">No</th>
                                    <th width="200px">Nama Pegawai</th>
                                    <th width="200px">Status</th>
                                    <th scope="col">Dari Tgl</th>
                                    <th scope="col">Sampai Tgl</th>
                                    <th scope="col">Jenis</th>
                                    <th scope="col">Lama</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;



                                foreach ($cuti as $kt) : ?>
                                    <tr>
                                        <td class="text-capitalize"><?= $no++; ?></td>
                                        <td class="text-capitalize"><?= $kt['nama']; ?></td>
                                        <td class=""><?= statusCuti($kt['status_cuti'], $kt); ?></td>
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
                                                <a href="<?= base_url(); ?>preview_cuti/<?= $kt['id_cuti'] ?>" class="btn btn-sm btn-secondary text-dark"><i class="fas fa-eye"></i></a>
                                                <?php if ($this->session->userdata('id') != $kt['id_pegawai']) { ?>
                                                    <a type="button" data-id="<?= $kt['id_cuti'] ?>" class="action btn btn-sm btn-success text-light"><i class="fas fa-edit"></i></a>
                                                <?php } ?>
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
<?php if ($this->session->userdata('controller') == 'admin') { ?>
    <div class="modal fade bd-example-modal-md" tabindex="-1" id="modal_cuti" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form method="POST" id="form_cuti" action="<?= base_url('admin/action_cuti') ?>">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal_title">
                            Form Persetujuan Cuti </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="preview_body">
                        <input type="hidden" id="id_cuti" name="id_cuti">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="tanggal">Keputusan : </label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status_cuti" id="acc_adm" value="acc_adm">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Terima & Teruskan ke Kepala Sekolah
                                    </label>
                                </div>
                                <div class="form-chec form-check-inline">
                                    <input class="form-check-input" type="radio" name="status_cuti" id="tol_adm" value="tol_adm">
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        Tolak
                                    </label>
                                </div>
                                <div class="form-chec form-check-inline">
                                    <input class="form-check-input" type="radio" name="status_cuti" id="rev_adm" value="rev_adm">
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        Revisi
                                    </label>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">

                                    <label for="tanggal">Catatan : </label>
                                    <textarea id="catatan_adm" name="catatan_adm" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
<?php } ?>
<?php if ($this->session->userdata('controller') == 'kepsek') { ?>
    <div class="modal fade bd-example-modal-md" tabindex="-1" id="modal_cuti" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form method="POST" id="form_cuti" action="<?= base_url('kepsek/action_cuti') ?>">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal_title">
                            Form Persetujuan Cuti </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="preview_body">
                        <input type="hidden" id="id_cuti" name="id_cuti">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="tanggal">Keputusan : </label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status_cuti" id="acc_kepsek" value="acc_kepsek">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Setuju
                                    </label>
                                </div>
                                <div class="form-chec form-check-inline">
                                    <input class="form-check-input" type="radio" name="status_cuti" id="tol_kepsek" value="tol_kepsek">
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        Tolak
                                    </label>
                                </div>
                                <div class="form-chec form-check-inline">
                                    <input class="form-check-input" type="radio" name="status_cuti" id="rev_kepsek" value="rev_kepsek">
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        Revisi
                                    </label>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">

                                    <label for="tanggal">Catatan : </label>
                                    <textarea id="catatan_kepsek" name="catatan_kepsek" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
<?php } ?>

<script>
    $(document).ready(function() {
        var table = $('#FDTable').DataTable({
            // dom: "Bfrtip",
            dom: '<?= $this->session->userdata('level') != '1' ? 'frtip' : 'Bfrtip' ?>',
            buttons: [
                'copy', 'excel',
                <?php if ($this->session->userdata('level') == '1') { ?>, {
                        extend: 'pdfHtml5',
                        text: 'PDF',
                        title: 'Data Cuti\nSMK N 1 Parit Tiga',
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
                    },
                <?php } ?>

            ],

            responsive: true,
            select: true,
            searching: true,

        });
        var dataCuti = JSON.parse(`<?= json_encode($cuti) ?>`);
        //digunakan untuk menampilkan form cuti pada admin
        <?php if ($this->session->userdata('controller') == 'admin') { ?>
            var PreviewModal = {
                'self': $('#modal_cuti'),
                'form': $('#modal_cuti').find('#form_cuti'),
                'title': $('#modal_cuti').find('#title'),
                'id_cuti': $('#modal_cuti').find('#id_cuti'),
                'catatan_adm': $('#modal_cuti').find('#catatan_adm'),
            }
            $('.action').on('click', function() {
                PreviewModal.form.trigger('reset');
                cur = dataCuti[$(this).data('id')];
                console.log(id_cuti);
                PreviewModal.self.modal('show');
                PreviewModal.id_cuti.val(cur['id_cuti']);
                if (cur['id_cuti'] == 'acc_adm') {
                    $('#acc_adm').trigger('click');
                } else if (cur['id_cuti'] == 'tol_adm') {
                    $('#tol_adm').trigger('click');
                } else if (cur['id_cuti'] == 'rev_adm') {
                    $('#rev_adm').trigger('click');
                }
                PreviewModal.catatan_adm.val(cur['catatan_adm']);
            })

        <?php } ?>
        //digunakan untuk menampilkan form cuti pada kepsek
        <?php if ($this->session->userdata('controller') == 'kepsek') { ?>
            var PreviewModal = {
                'self': $('#modal_cuti'),
                'form': $('#modal_cuti').find('#form_cuti'),
                'title': $('#modal_cuti').find('#title'),
                'id_cuti': $('#modal_cuti').find('#id_cuti'),
                'catatan_kepsek': $('#modal_cuti').find('#catatan_kepsek'),
            }
            $('.action').on('click', function() {
                PreviewModal.form.trigger('reset');
                cur = dataCuti[$(this).data('id')];
                console.log(id_cuti);
                PreviewModal.self.modal('show');
                PreviewModal.id_cuti.val(cur['id_cuti']);
                if (cur['id_cuti'] == 'acc_kepsek') {
                    $('#acc_kepsek').trigger('click');
                } else if (cur['id_cuti'] == 'tol_kepsek') {
                    $('#tol_kepsek').trigger('click');
                } else if (cur['id_cuti'] == 'rev_kepsek') {
                    $('#rev_kepsek').trigger('click');
                }
                PreviewModal.catatan_kepsek.val(cur['catatan_kepsek']);
            })

        <?php } ?>
    })
</script>