<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="row mt-5">
            <div class="col-lg-12 mt-2">
                <div class="flash-data" data-flashdata="<?= $this->session->flashdata('pesan'); ?>"></div>
                <form class="form-inline" id="toolbar_form" onsubmit="return false;">
                    <div class="col-lg-3">
                        <select class="form-control mr-sm-2" name="jenis" id="jenis"></select>
                    </div>
                    <!-- <button style="" type="button" id="preview_btn" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Large modal</button> -->


                    <button type="button" class="btn btn-success my-1 mr-sm-2" id="new_btn" disabled="disabled"><i class="fal fa-plus"></i> Tambah</button>
                </form>
                <!-- Button trigger modal -->



                <table class="table table-hover table-bordered" id="FDataTable" style="margin-top: 10px">
                    <thead>
                        <tr>
                            <th width="50px">No</th>
                            <th scope="col">Jenis</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Tahun</th>
                            <th scope="col">Keterangan</th>
                            <!-- <th scope="col">Alasan</th> -->
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>

<div class="modal fade bd-example-modal-lg" tabindex="-1" id="preview_doc" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title">
                    Preview </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="preview_body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="bank_modal" tabindex="-3" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form opd="form" id="user_form" onsubmit="return false;" type="multipart" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title">
                        Bank Data
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="" id="id_bank_data" name="id_bank_data">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="nama">Jenis Data</label>
                                <select class="form-control " name="jenis" id="jenis"></select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="tanggal">Tanggal Dokumen</label>
                                <input type="date" placeholder="ex. 1986XX XXXXXX X XXX" class="form-control" id="tanggal" name="tanggal">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="nama">File </label>
                                <input type="file" placeholder="" class="form-control" id="file_data" name="file_data" accept="application/pdf">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary" type="submit" id="add_btn" data-loading-text="Loading..."><strong>Tambah Data</strong></button>
                        <button class="btn btn-primary" type="submit" id="save_edit_btn" data-loading-text="Loading..."><strong>Simpan Perubahan</strong></button>
                    </div>
            </form>
        </div>
    </div>
</div>


<script>
    $(document).on('show.bs.modal', '.modal', function() {
        const zIndex = 1040 + 10 * $('.modal:visible').length;
        $(this).css('z-index', zIndex);
        setTimeout(() => $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack'));
    });

    $(document).ready(function() {
        $('#menu_1').addClass('active');


        // $('#preview_btn').trigger('click');
        // $('#preview_doc').modal('show');
        $('#opmenu_1').show();
        $('#submenu_1').addClass('active');
        var toolbar = {
            'form': $('#toolbar_form'),
            'jenis': $('#toolbar_form').find('#jenis'),
            'newBtn': $('#new_btn'),
        }

        var FDataTable = $('#FDataTable').DataTable({
            'columnDefs': [],
            deferRender: true,
            "order": [
                [0, "desc"]
            ]
        });

        var BankModal = {
            'self': $('#bank_modal'),
            'info': $('#bank_modal').find('.info'),
            'form': $('#bank_modal').find('#user_form'),
            'addBtn': $('#bank_modal').find('#add_btn'),
            'saveEditBtn': $('#bank_modal').find('#save_edit_btn'),
            'id_bank_data': $('#bank_modal').find('#id_bank_data'),
            'jenis': $('#bank_modal').find('#jenis'),
            'tanggal': $('#bank_modal').find('#tanggal'),
            'keterangan': $('#bank_modal').find('#keterangan'),
        }

        var PreviewModal = {
            'self': $('#preview_doc'),
            'title': $('#preview_doc').find('#title'),
            'body': $('#preview_doc').find('#preview_body'),

        }

        var dataRole = {}
        var dataUser = {}

        var swalSaveConfigure = {
            title: "Konfirmasi simpan",
            text: "Yakin akan menyimpan data ini?",
            type: "info",
            showCancelButton: true,
            confirmButtonColor: "#18a689",
            confirmButtonText: "Ya, Simpan!",
        };

        var swalDeleteConfigure = {
            title: "Konfirmasi hapus",
            text: "Yakin akan menghapus data ini?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, Hapus!",
        };

        $.when(getAllJenis(), getAllBankData()).then((e) => {
            toolbar.newBtn.prop('disabled', false);
        }).fail((e) => {
            console.log(e)
        });

        function getAllJenis() {
            return $.ajax({
                url: `<?php echo base_url('General/getAllJenisBankData/') ?>`,
                'type': 'POST',
                data: {},
                success: function(data) {
                    var json = JSON.parse(data);
                    if (json['error']) {
                        return;
                    }
                    dataRole = json['data'];
                    renderJenisFilter(dataRole);
                    // renderRoleSelectionAdd(dataRole);
                },
                error: function(e) {}
            });
        }



        function renderJenisFilter(data) {
            BankModal.jenis.empty();
            BankModal.jenis.append($('<option>', {
                value: "",
                text: "-- Pilih Jenis --"
            }));

            toolbar.jenis.empty();
            toolbar.jenis.append($('<option>', {
                value: "",
                text: "-- Semua  --"
            }));
            Object.values(data).forEach((d) => {
                BankModal.jenis.append($('<option>', {
                    value: d['id_jenis_bank_data'],
                    text: d['nama_jenis_bank_data'],
                }));

                toolbar.jenis.append($('<option>', {
                    value: d['id_jenis_bank_data'],
                    text: d['nama_jenis_bank_data'],
                }));
            });
        }

        toolbar.jenis.on('change', (e) => {
            getAllBankData();
        });

        function getAllBankData() {

            return $.ajax({
                url: `<?= base_url('Pegawai/getAllBankData/') ?>`,
                'type': 'POST',
                data: toolbar.form.serialize(),
                success: function(data) {
                    Swal.close();
                    var json = JSON.parse(data);
                    if (json['error']) {
                        return;
                    }
                    dataUser = json['data'];
                    renderUser(dataUser);
                },
                error: function(e) {}
            });
        }

        function renderUser(data) {
            if (data == null || typeof data != "object") {
                console.log("User::UNKNOWN DATA");
                return;
            }
            var i = 0;

            var renderData = [];
            Object.values(data).forEach((user) => {
                var editButton = `
                    <a class="edit btn btn-primary" data-id='${user['id_bank_data']}'><i class='fa fa-pencil'></i> </a>
                    `;
                var lihatButton = `
                   <a class="lihat btn btn-info" data-id='${user['id_bank_data']}'><i class='fa fa-eye'></i> </a>
                   `;
                var deleteButton = `
                    <a class="delete btn btn-danger" data-id='${user['id_bank_data']}'><i class='fa fa-trash'></i> </a>
                    `;
                var button = `
                                 <div class="btn-group">
                                    ${lihatButton}
                                    ${editButton}
                                    ${deleteButton}
                                    </div>
                   `;

                renderData.push([user['id_bank_data'], user['nama_jenis_bank_data'], user['tanggal'], user['tanggal'].substring(0, 4), user['keterangan'], button]);
            });
            FDataTable.clear().rows.add(renderData).draw('full-hold');
        }

        function resetBankModal() {
            BankModal.form.trigger('reset');
            // BankModal.email.val("");
            // BankModal.no_hp.val("");
            // BankModal.nip.val("");
        }

        toolbar.newBtn.on('click', (e) => {
            resetBankModal();
            BankModal.self.modal('show');
            BankModal.addBtn.show();
            BankModal.saveEditBtn.hide();
        });

        FDataTable.on('click', '.edit', function() {
            resetBankModal();
            BankModal.self.modal('show');
            BankModal.addBtn.hide();
            BankModal.saveEditBtn.show();
            var currentData = dataUser[$(this).data('id')];
            BankModal.id_bank_data.val(currentData['id_bank_data']);
            BankModal.jenis.val(currentData['jenis']);
            BankModal.tanggal.val(currentData['tanggal']);

        });

        FDataTable.on('click', '.lihat', function() {

            console.log('prev')
            PreviewModal.self.modal('show');
            var currentData = dataUser[$(this).data('id')];
            PreviewModal.body.html('')
            PreviewModal.body.html(`<object style="width : 100%; height: 450px" data="<?= base_url('uploads/bank_data/') ?>${currentData['doc_bank_data']}" type="application/pdf">
    <iframe style="width : 100%; height: 450px"  src="<?= base_url('uploads/bank_data/') ?>${currentData['doc_bank_data']}"></iframe>
</object>`)

        });

        BankModal.form.submit(function(event) {
            event.preventDefault();
            var isAdd = BankModal.addBtn.is(':visible');
            var url = "<?= base_url('Pegawai/') ?>";
            url += isAdd ? "addBankData" : "editBankData";
            var button = isAdd ? BankModal.addBtn : BankModal.saveEditBtn;
            console.log('sub')
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
                    // data: BankModal.form.serialize(),
                    data: new FormData(BankModal.form[0]),
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        // buttonIdle(button);
                        var json = JSON.parse(data);
                        if (json['error']) {
                            Swal.fire("Simpan Gagal", json['message'], "error");
                            return;
                        }
                        var user = json['data']
                        dataUser[user['id_bank_data']] = user;
                        Swal.fire("Simpan Berhasil", "", "success");
                        renderUser(dataUser);
                        BankModal.self.modal('hide');
                    },
                    error: function(e) {}
                });
            });
        });

        FDataTable.on('click', '.delete', function() {
            event.preventDefault();
            var id = $(this).data('id');
            Swal.fire({
                title: "Apakah anda Yakin?",
                text: "Hapus data!",
                icon: "warning",
                allowOutsideClick: false,
                showCancelButton: true,
                buttons: {
                    cancel: 'Batal !!',
                    catch: {
                        text: "Ya, Saya Hapus !!",
                        value: true,
                    },
                },
            }).then((result) => {
                if (!result.isConfirmed) {
                    return;
                }
                $.ajax({
                    url: "<?= site_url('Master/deleteUser') ?>",
                    'type': 'get',
                    data: {
                        'id': id
                    },
                    success: function(data) {
                        var json = JSON.parse(data);
                        if (json['error']) {
                            Swal.fire("Delete Gagal", json['message'], "error");
                            return;
                        }
                        delete dataUser[id];
                        Swal.fire("Delete Berhasil", "", "success");
                        renderUser(dataUser);
                    },
                    error: function(e) {}
                });
            });
        });
    });
</script>