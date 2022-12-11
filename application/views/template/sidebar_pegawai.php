<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="<?= base_url() ?>pegawai/user_pegawai" class="text-primary font-weight-bold" style="font-size: 16px;">S I M P E G</a>
            <p class="text-primary font-weight-bold mt-n3"><span class="badge badge-info"> <i class="fas fa-landmark"></i> SMKN 1 PARITTIGA</span></p>
        </div>
        <ul class="sidebar-menu bg-white">
            <li class="menu-header mt-4">Dashboard</li>
            <li <?= $this->uri->segment(1) == 'pegawai' && $this->uri->segment(2) == '' ? 'class="active"' : "" ?>>
                <a class="nav-link" href="<?= base_url(); ?>pegawai/">
                    <i class="fas fa-regular fa-house"></i>
                    <span>Dashboard</span>
            </li>
            </a>
            <li class="menu-header mt-4">Interface</li>
            <li <?= $this->uri->segment(2) == 'data_diri' || $this->uri->segment(2) == '' || $this->uri->segment(2) == '' ? 'class="active"' : "" ?>>
                <a class="nav-link" href="<?= base_url() ?>pegawai/data_diri">
                    <i class="fas fa-regular fa-users"></i>
                    <span>Data Diri</span>
                </a>
            </li>

            <li <?= $this->uri->segment(2) == 'absensi' || $this->uri->segment(2) == 'absensi_record' ? 'class="active"' : "" ?>>
                <a class="nav-link" href="<?= base_url('pegawai/absensi/') ?>">
                    <i class="fas fa-regular fa-address-card"></i>
                    </i>
                    <span>Absensi</span>
                </a>
            </li>
            <li <?= $this->uri->segment(2) == 'cuti' || $this->uri->segment(2) == 'add_cuti' || $this->uri->segment(2) == 'edit_cuti' ? 'class="active"' : "" ?>>
                <a class="nav-link" href="<?= base_url('pegawai/cuti/') ?>">
                    <i class="fas fa-solid fa-briefcase"></i>
                    </i>
                    <span>Cuti</span>
                </a>
            </li>

    </aside>
</div>