<div class="main-content">
    <section class="section">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">

                            <li class="nav-item">
                                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">SK Gaji</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <form method="POST" id="step_one" action="<?= $form_url ?>">
                                    <div class=" flash-data" data-flashdata="<?= $this->session->flashdata('pesan'); ?>">
                                    </div>
                                    <?php if ($this->session->flashdata('error')) : ?>
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong> <?= $this->session->flashdata('error'); ?></strong>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    <?php endif; ?> <div class=" form-row">
                                        <input type="hidden" class="form-control" name="id_gaji_berkala" value="<?= !empty($return['id_gaji_berkala']) ? $return['id_gaji_berkala']  : '';  ?>">


                                        <div class="col-lg-6">
                                            <label for="tanggal_pengajuan">Tanggal</label>
                                            <input type="date" class="form-control" name="tanggal_pengajuan" value="<?= !empty($return['tanggal_pengajuan']) ? $return['tanggal_pengajuan']  : '';  ?>" required>
                                        </div>

                                        <div class="col-lg-6">
                                            <label for="nominal">Nominal</label>
                                            <input type="number" class="form-control" name="nominal" value="<?= !empty($return['nominal']) ? $return['nominal']  : '';  ?>" required>
                                        </div>

                                        <div class="col-lg-6">
                                            <label for="file_sk_pns">SK CPNS / PNS</label>
                                            <input type="file" class="form-control" name="file_sk_pns">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary float-right">Simpan</button>
                                    <a id="profile-tab" data-toggle="tab" href="#profile" role="tab" class="btn btn-primary float-right"> Next </a>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="step_2" role="tabpanel" aria-labelledby="profile-tab">...</div>
                            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
                        </div>

                        <script>
                            $(document).ready(function() {

                                var StepOne = {
                                    'form': $('#step_one'),
                                }

                                function swalLoading() {
                                    Swal.fire({
                                        title: 'Loading ..',
                                        html: 'Harap Tunggu !!',
                                        allowOutsideClick: false,
                                        buttons: false,
                                        didOpen: () => {
                                            Swal.showLoading()
                                        }
                                    })
                                }
                                StepOne.form.submit(function(event) {
                                    event.preventDefault();
                                    var url = "<?= $form_url ?>";

                                    Swal.fire({
                                        title: "Konfirmasi",
                                        text: "Data akan disimpan!",
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
                                        swalLoading()
                                        $.ajax({
                                            url: url,
                                            'type': 'POST',
                                            data: StepOne.form.serialize(),
                                            success: function(data) {
                                                var json = JSON.parse(data);
                                                if (json['error']) {
                                                    Swal.fire("Simpan Gagal", json['message'], "error");
                                                    return;
                                                }
                                                Swal.close();
                                            }
                                        });
                                    });
                                });

                            })
                        </script>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>