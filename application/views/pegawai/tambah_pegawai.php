<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="<?= base_url(); ?>/pegawai/tambah_user">
                            <div class=" form-row">
                                <div class="form-group col-md-6">
                                    <label for="username">Nama</label>
                                    <input type="text" class="form-control" name="username" required>
                                </div>
                                <div class=" form-group col-md-6">
                                    <label for="password">NUPTK</label>
                                    <input type="text" class="form-control" name="password" required>
                                </div>
                            <div class=" form-group">
                                <label for="level">Jenis Kelamin</label>
                                <select class="form-control" name="level" required>
                                    <option disabled selected>Pilih Jenis Kelamin</option>
                                    <option value="Admin">Pria</option>
                                    <option value="Pegawai">Perempuan</option>
                                </select>
                            </div>
                            <div class=" form-group col-md-6">
                                    <label for="password">Tempat Lahir</label>
                                    <input type="text" class="form-control" name="password" required>
                                </div>
                                <div class=" form-group col-md-6">
                                    <label for="password">NUPTK</label>
                                    <input type="text" class="form-control" name="password" required>
                                </div>
                            <a href="<?= base_url(); ?>admin/user" class="btn btn-danger">Kembali</a>
                            <button type="submit" class="btn btn-primary float-right">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>