<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="<?= base_url(); ?>/admin/edit_user/<?= $user->id ?>">
                            <div class=" form-row">
                                <div class="form-group col-md-6">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" name="username" value="<?= $user->username ?>" required>
                                </div>
                                <div class=" form-group col-md-6">
                                    <label for="password">Password</label>
                                    <input type="text" class="form-control" name="password" value="<?= $user->password ?>" required>
                                </div>
                            </div>
                            <div class=" form-group">
                                <label for="level">Level User</label>
                                <select class="form-control" name="level" required>
                                    <option value="1" <?php if ($user->level == '1') {
                                                            echo 'selected';
                                                        } ?>>Admin</option>
                                    <option value="2" <?php if ($user->level == '2') {
                                                            echo 'selected';
                                                        } ?>>Pegawai</option>
                                    <option value="3" <?php if ($user->level == '3') {
                                                            echo 'selected';
                                                        } ?>>Kepala Sekolah</option>
                                </select>
                            </div>
                            <a href="<?= base_url(); ?>admin/user" class="btn btn-danger">Kembali</a>
                            <button type="submit" name="submit" value="edit" class="btn btn-primary float-right">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>