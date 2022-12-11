<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="row mt-5">
            <div class="col-lg-12 mt-2">
                <div class="flash-data" data-flashdata="<?= $this->session->flashdata('pesan'); ?>"></div>
                <!-- <a href="<?= base_url(); ?>pegawai/add_pengumuman" class="btn btn-primary mb-3">
                    Tambah
                </a> -->
                <?php if ($this->session->flashdata('error')) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong> <?= $this->session->flashdata('error'); ?></strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
                <div class="dropdown mb-3">
                    <button class="btn btn-primary  mb-3" id="add_btn">
                        <i class='fa fa-plus'></i> Tambah
                    </button>
                </div>

                <table class="table table-hover table-bordered" id="FDTable" style="margin-top: 10px">
                    <thead>
                        <tr>
                            <th width="50px">No</th>
                            <th width="200px">Tanggal</th>
                            <th width="200px">Judul</th>
                            <th width="200px">Isi</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;



                        foreach ($pengumuman as $kt) : ?>
                            <tr>
                                <td class="text-capitalize"><?= $no++; ?></td>
                                <td class="text-capitalize"><?= $kt['tanggal']; ?></td>
                                <td class="text-capitalize"><?= $kt['judul']; ?></td>
                                <td class=""><?= substr(strip_tags($kt['isi']), 0, 100); ?> ..
                                </td>
                                <td class="text-center">
                                    <!-- <div class="row"> -->
                                    <div class="btn-group mr-2" role="group" aria-label="Aksi">
                                        <a href="<?= base_url(); ?>pengumuman/<?= $kt['id_pengumuman'] ?>" class="btn btn-sm btn-secondary text-dark"><i class="fas fa-eye"></i></a>
                                        <a type="button" data-id="<?= $kt['id_pengumuman'] ?>" class="action btn btn-sm btn-success text-light"><i class="fas fa-edit"></i></a>
                                        <a href="<?= base_url(); ?>admin/delete_pengumuman/<?= $kt['id_pengumuman'] ?>" class="btn btn-sm btn-danger text-light"><i class="fas fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<div class="modal fade bd-example-modal-lg" tabindex="-1" id="modal_pengumuman" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="POST" id="form_pengumuman" action="<?= base_url('admin/action_pengumuman') ?>">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title">
                        Pengumuman</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="preview_body">
                    <input type="" id="id_pengumuman" name="id_pengumuman">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="tanggal">Tanggal : </label>
                            <input type="date" id="tanggal" name="tanggal" value="" class="form-control" required>
                        </div>
                        <div class="col-lg-12">
                            <label for="tanggal">Judul : </label>
                            <input type="text" id="judul" name="judul" value="" class="form-control" required>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="tanggal">Isi : </label>
                                <script src="https://cdn.ckeditor.com/ckeditor5/35.2.1/classic/ckeditor.js"></script>
                                <textarea id="isi" name="isi" class="form-control" rows="5"></textarea>

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


<script>
    $(document).ready(function() {
        var table = $('#FDTable').DataTable({
            // dom: "Bfrtip",
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel', {
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
                    // exportOptions: {
                    //     columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17]
                    // },

                },

            ],

            responsive: true,
            select: true,

        });
        var dataCuti = JSON.parse(`<?= json_encode($pengumuman) ?>`);
        ClassicEditor.defaultConfig = {
            toolbar: {
                items: [
                    'heading',
                    '|',
                    'bold',
                    'italic',
                    '|',
                    'bulletedList',
                    'numberedList',
                    '|',
                    'insertTable',
                    'undo',
                    'redo'
                ]
            },

            table: {
                contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
            },
            language: 'en'
        };
        var PreviewModal = {
            'self': $('#modal_pengumuman'),
            'form': $('#modal_pengumuman').find('#form_pengumuman'),
            'title': $('#modal_pengumuman').find('#title'),
            'id_pengumuman': $('#modal_pengumuman').find('#id_pengumuman'),
            'isi': $('#modal_pengumuman').find('#isi'),
            'judul': $('#modal_pengumuman').find('#judul'),
            'tanggal': $('#modal_pengumuman').find('#tanggal'),
        }
        $('#add_btn').on('click', function() {
            PreviewModal.form.trigger('reset');
            PreviewModal.self.modal('show');
            $('.ck-reset').remove();
            $('#isi').html('')
            ClassicEditor
                .create(document.querySelector('#isi'))
                .catch(error => {
                    console.error(error);
                });
        })



        $('.action').on('click', function() {
            PreviewModal.form.trigger('reset');
            cur = dataCuti[$(this).data('id')];
            PreviewModal.self.modal('show');
            PreviewModal.id_pengumuman.val(cur['id_pengumuman']);
            PreviewModal.judul.val(cur['judul']);

            // PreviewModal.isi.val(cur['isi']);
            // PreviewModal.isi.val(cur['isi']);
            $('.ck-reset').remove();

            $('#isi').html(cur['isi'])
            ClassicEditor
                .create(document.querySelector('#isi'))
                .catch(error => {
                    console.error(error);
                });
            PreviewModal.tanggal.val(cur['tanggal']);
        })

    })
</script>