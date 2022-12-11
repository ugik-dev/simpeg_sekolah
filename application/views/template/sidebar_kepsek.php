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
            <li <?= $this->uri->segment(2) == 'data_diri'  ? 'class="active"' : "" ?>>
                <a class="nav-link" href="<?= base_url(); ?>profile">
                    <i class="fas fa-regular fa-user"></i>
                    <span>Profile</span>
                </a>
            </li>
            <li <?= $this->uri->segment(2) == 'cuti' ? 'class="active"' : "" ?>>
                <a class="nav-link" href="<?= base_url(); ?>pegawai/cuti">
                    <i class="fas fa-regular fa-calendar"></i>
                    <span>Pengajuan Cuti Kepsek</span>
                </a>
            </li>
            <li class="menu-header mt-4">Permohonan</li>
            <li <?= $this->uri->segment(1) == 'kepsek/permohonan_cuti' ? 'class="active"' : "" ?>>
                <a class="nav-link" href="<?= base_url(); ?>kepsek/permohonan_cuti">
                    <i class="fas fa-regular fa-bookmark"></i>
                    <span>Cuti</span>
                </a>
            </li>

            <li class="menu-header mt-4">Management</li>
            <li class="dropdown <?= $this->uri->segment(2) == 'absensi' || $this->uri->segment(2) == 'absensi_bulanan' || $this->uri->segment(2) == 'absensi_harian' ? 'active' : "" ?>">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-regular fa-address-card"></i> <span>Absensi</span></a>
                <ul class="dropdown-menu">
                    <li class="<?= $this->uri->segment(2) == 'absensi_harian' ? 'active' : "" ?>"><a class="nav-link" href="<?= base_url(); ?>kepsek/absensi_harian">Harian</a></li>
                    <li class="<?= $this->uri->segment(2) == 'absensi_bulanan' ? 'active' : "" ?>"><a class="nav-link" href="<?= base_url(); ?>kepsek/absensi_bulanan">Bulanan</a></li>
                </ul>
            </li>
            <li <?= $this->uri->segment(2) == 'kepegawaian' || $this->uri->segment(2) == 'tambah_kategori' || $this->uri->segment(2) == 'update_kategori' ? 'class="active"' : "" ?>>
                <a class="nav-link" href="<?= base_url(); ?>kepsek/kepegawaian">
                    <i class="fas fa-regular fa-briefcase"></i>
                    <span>Kepegawaian</span>
                </a>
            </li>


        </ul>

    </aside>
</div>