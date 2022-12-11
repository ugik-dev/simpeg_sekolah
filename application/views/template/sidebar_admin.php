<!-- </div>  -->
<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="<?= base_url() ?>dashboard" class="text-primary font-weight-bold" style="font-size: 16px;">S I M P E G</a>
            <p class="text-primary font-weight-bold mt-n3"><span class="badge badge-info"> <i class="fas fa-landmark"></i> SMKN 1 PARITTIGA</span></p>
        </div>
        <ul class="sidebar-menu bg-white">
            <li class="menu-header mt-4">Dashboard</li>
            <li <?= $this->uri->segment(1) == 'dashboard' || $this->uri->segment(1) == '' ? 'class="active"' : "" ?>>
                <a class="nav-link" href="<?= base_url(); ?>dashboard">
                    <i class="fas fa-regular fa-house"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="menu-header mt-4">Menu Pegawai</li>
            <li <?= $this->uri->segment(2) == 'data_diri'  ? 'class="active"' : "" ?>>
                <a class="nav-link" href="<?= base_url(); ?>pegawai/data_diri">
                    <i class="fas fa-regular fa-user"></i>
                    <span>Data Diri</span>
                </a>
            </li>
            <li <?= $this->uri->segment(2) == 'cuti' || $this->uri->segment(2) == 'add_cuti' || $this->uri->segment(2) == 'edit_cuti' ? 'class="active"' : "" ?>>
                <a class="nav-link" href="<?= base_url('pegawai/cuti/') ?>">
                    <i class="fas fa-regular fa-briefcase"></i>
                    </i>
                    <span>Cuti</span>
                </a>
            </li>
            <li class="menu-header mt-4">Management</li>
            <li <?= $this->uri->segment(2) == 'permohonan_cuti'  ? 'class="active"' : "" ?>>
                <a class="nav-link" href="<?= base_url(); ?>admin/permohonan_cuti">
                    <i class="fas fa-regular fa-bookmark"></i>
                    <span>Permohonan Cuti</span>
                </a>
            </li>
            <li <?= $this->uri->segment(2) == 'kepegawaian' || $this->uri->segment(2) == 'tambah_kategori' || $this->uri->segment(2) == 'update_kategori' ? 'class="active"' : "" ?>>
                <a class="nav-link" href="<?= base_url(); ?>admin/kepegawaian">
                    <i class="fas fa-regular fa-id-card"></i>
                    <span>Kepegawaian</span>
                </a>
            </li>
            <li <?= $this->uri->segment(2) == 'user' || $this->uri->segment(2) == 'tambah_user' || $this->uri->segment(2) == 'edit_user' ? 'class="active"' : "" ?>>
                <a class="nav-link" href="<?= base_url(); ?>admin/user">
                    <i class="fas fa-regular fa-users"></i>
                    <span>Manajemen User</span>
                </a>
            </li>
            <li <?= $this->uri->segment(2) == 'pengumuman' ? 'class="active"' : "" ?>>
                <a class="nav-link" href="<?= base_url(); ?>admin/pengumuman">
                    <i class="fas fa-regular fa-envelope"></i>
                    <span>Pengumuman</span>
                </a>
            </li>
            <li <?= $this->uri->segment(2) == 'pengaturan_cuti' ? 'class="active"' : "" ?>>
                <a class="nav-link" href="<?= base_url(); ?>admin/pengaturan_cuti">
                    <i class="fas fa-cog"></i>
                    <span>Pengaturan Cuti</span>
                </a>
            </li>
            <li class="menu-header">Laporan</li>
            <li class="dropdown <?= $this->uri->segment(2) == 'absensi' || $this->uri->segment(2) == 'absensi_bulanan' || $this->uri->segment(2) == 'absensi_harian' ? 'active' : "" ?>">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-calendar"></i> <span>Absensi</span></a>
                <ul class="dropdown-menu">
                    <li class="<?= $this->uri->segment(2) == 'absensi_harian' ? 'active' : "" ?>"><a class="nav-link" href="<?= base_url(); ?>admin/absensi_harian">Harian</a></li>
                    <li class="<?= $this->uri->segment(2) == 'absensi_bulanan' ? 'active' : "" ?>"><a class="nav-link" href="<?= base_url(); ?>admin/absensi_bulanan">Bulanan</a></li>
                </ul>
            </li>

        </ul>

    </aside>
</div>

<!-- Modal -->
<div class="modal fade" id="logout" tabindex="-1" aria-labelledby="exampleModalLabel" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Sistem Manajemen Kepegawaian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-bs-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Anda Yakin Ingin Keluar Dari Halaman Admin ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a class="btn btn-danger" href="<?= base_url() ?>auth/logout">Keluar</a>
            </div>
        </div>
    </div>
</div>