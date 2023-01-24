<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pegawai extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('username')) {
            redirect('auth');
        }
        // if ($_SESSION['level'] != "Pegawai") {
        // }
        $this->load->model(['UserModel', 'PegawaiModel', 'ParameterModel']);
    }
    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['page'] = 'dashboard_pegawai';
        $data['jumlah_laki'] = count($this->UserModel->getPegawai(['status_user' => 'Y', 'jenis_kelamin' => 'L']));
        $data['jumlah_perempuan'] = count($this->UserModel->getPegawai(['status_user' => 'Y', 'jenis_kelamin' => 'P']));
        $data['sertifikasi'] = count($this->UserModel->getPegawai(['status_user' => 'Y', 'st_sertifikasi' => 'Y']));
        $data['jumlah_pegawai'] = count($this->UserModel->getPegawai(['status_user' => 'Y']));
        $data['pengumuman'] = $this->ParameterModel->getPengumuman(['limit' => 5]);
        $data['persentase_sertifikasi'] = round($data['sertifikasi'] / $data['jumlah_pegawai'] * 100, 0);
        $this->load->view('page', $data);
    }

    public function getAllBankData()
    {
        try {
            $filter = $this->input->post();
            $filter['id_pegawai'] = $this->session->userdata()['id_user'];
            $data = $this->PegawaiModel->getAllBankData($filter);
            echo json_encode(['error' => false, 'data' => $data]);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function data_diri()
    {
        $filter = $this->input->get();
        if (!empty($filter['r'])) $this->ParameterModel->readNotif($filter['r']);

        $id = $this->session->userdata('id_user');
        $data['form_url'] = base_url('pegawai/data_diri/');
        $pegawai = $this->UserModel->getPegawai(['id' => $id]);
        $pegawaiDetail = $this->UserModel->getPegawaiDetail(['id' => $this->session->userdata()['id_user']])[$this->session->userdata()['id_user']];
        $data['ref_ptk'] = $this->ParameterModel->ref_ptk();
        if (empty($pegawai[$id]['id_pegawai'])) {
            $add = true;
        } else {
            $add = false;
        }
        if (!empty($this->input->post())) {
            $data_post = $this->input->post();
            $data_post['id'] = $id;
            if ($add) {
                $this->UserModel->add_pegawai($data_post);
            } else {
                $this->UserModel->edit_pegawai($data_post);
            }
            $this->session->set_flashdata('pesan', 'Berhasil simpan data kepegawaian');
            redirect('pegawai/data_diri');
            return;
        }

        $data['return'] = $this->UserModel->getPegawai(['id' => $id])[$id];
        // $data['title'] = 'Update Data Diri';
        $data = [
            'title' => 'Data Diri',
            'page' => 'admin/form_pegawai',
            'return' =>  $this->UserModel->getPegawai(['id' => $id])[$id],
            'pegawaiDetail' => $pegawaiDetail,
            'ref_ptk' =>  $this->ParameterModel->ref_ptk(),
            'form_url' => base_url('pegawai/data_diri/')

        ];

        $this->load->view('page', $data);
    }

    public function cuti()
    {
        $filter = $this->input->get();

        if (!empty($filter['r'])) $this->ParameterModel->readNotif($filter['r']);

        $filter['id_pegawai'] = $this->session->userdata('id');
        $data['user'] = $this->PegawaiModel->getCuti($filter);
        $data['title'] = 'Data Cuti';
        $data['page'] = 'pegawai/cuti';
        $this->load->view('page', $data);
    }

    public function absensi()
    {
        $filter = $this->input->get();
        // inisialisasi jika tidak ada filter bulan
        if (empty($filter['bulan'])) $filter['bulan'] = date('Y-m');
        $tmp = date_create($filter['bulan']);
        $filter['bulan'] =  date_format($tmp, "Y-m");

        $filter['tahun'] = explode('-', $filter['bulan'])[0];
        $filter['bulan'] = explode('-', $filter['bulan'])[1];

        $filter['id_pegawai'] = $this->session->userdata('id');
        // $data['absensi'] = $this->PegawaiModel->getAbsensi($filter);
        $this->load->model('AdminModel');
        $data['absensi'] = $this->AdminModel->getAbsensi($filter);
        // echo json_encode($data['absensi']);
        // die();
        $data['title'] = 'Absensi Bulanan';
        $data['page'] = 'pegawai/absensi_bulanan';
        $data['bulan'] = $filter['bulan'];
        $data['tahun'] = $filter['tahun'];
        $this->load->view('page', $data);
    }

    public function add_cuti()
    {
        $data['form_url'] = base_url('pegawai/add_cuti/');
        $data['pegawai'] = $this->UserModel->getPegawaiDetail(['id' => $this->session->userdata()['id_user']])[$this->session->userdata()['id_user']];
        if (!empty($this->input->post())) {
            $data_post = $this->input->post();
            $data_post['id_pegawai'] = $this->session->userdata()['id_user'];
            $data_post['id_kepsek'] =  $this->UserModel->get(['status_user' => 'Y', 'level' => 3], true)['id'];

            if ($this->session->userdata('level') == 1) {
                $data_post['status_cuti'] = 'acc_adm';
                $id_cuti =  $this->PegawaiModel->add_cuti($data_post);
                $notif['id_user'] =  $data_post['id_kepsek'];
                $notif['link'] = 'admin/permohonan_cuti/?id=' . $id_cuti;
                $notif['icon'] = 'far fa-user';
                $notif['text'] = $this->session->userdata()['nama'] . ' telah mengajuan cuti baru kepada anda.';
            } else {
                $id_cuti =  $this->PegawaiModel->add_cuti($data_post);
                $notif['id_user'] =  $this->UserModel->get(['status_user' => 'Y', 'level' => 1], true)['id'];
                $notif['link'] = 'admin/permohonan_cuti/?id=' . $id_cuti;
                $notif['icon'] = 'far fa-user';
                $notif['text'] = $this->session->userdata()['nama'] . ' telah mengajuan cuti baru kepada anda.';
                $this->ParameterModel->pushNotif($notif);
            }

            $this->session->set_flashdata('pesan', 'Cuti berhasil ditambahkan');
            redirect('pegawai/cuti');
            return;
        }

        $data['title'] = 'Tambah Cuti';
        $data['page'] = 'pegawai/form_cuti';
        $this->load->view('page', $data);
    }
    public function edit_cuti($id)
    {
        $data['form_url'] = base_url('pegawai/edit_cuti/' . $id);
        // $data['pegawai'] = $this->UserModel->getPegawai(['id' => $this->session->userdata()['id_user']])[$this->session->userdata()['id_user']];
        $data['pegawai'] = $this->UserModel->getPegawaiDetail(['id' => $this->session->userdata()['id_user']])[$this->session->userdata()['id_user']];
        $data['return'] = $this->PegawaiModel->getCuti(['id_pegawai' => $this->session->userdata()['id_user'], 'id_cuti' => $id])[$id];
        if ($this->session->userdata('level') == 2) {
            if ($data['return']['status_cuti'] == 'tol_adm') {
                $this->session->set_flashdata('error', 'Cuti tidak dapat diedit, karna ditolak admin');
                redirect('pegawai/cuti');
                return;
            }
            if ($data['return']['status_cuti'] == 'tol_kepsek') {
                $this->session->set_flashdata('error', 'Cuti tidak dapat diedit, karna ditolak kepsek');
                redirect('pegawai/cuti');
                return;
            }
            if ($data['return']['status_cuti'] == 'acc_kepsek') {
                $this->session->set_flashdata('error', 'Cuti tidak dapat diedit, karna di acc kepsek');
                redirect('pegawai/cuti');
                return;
            }
            $data_post['status_cuti'] = 'Pengajuan';
        } else  if ($this->session->userdata('level') == 1) {
            if ($data['return']['status_cuti'] == 'acc_kepsek') {
                $this->session->set_flashdata('error', 'Cuti tidak dapat diedit, karna di acc kepsek');
                redirect('pegawai/cuti');
                return;
            }
        } else  if ($this->session->userdata('level') == 3) {
            if ($data['return']['status_cuti'] == 'acc_kepsek') {
                $this->session->set_flashdata('error', 'Cuti tidak dapat diedit, karna di acc kepsek');
                redirect('pegawai/cuti');
                return;
            }
        }


        if (!empty($this->input->post())) {
            $data_post = $this->input->post();
            $data_post['id_pegawai'] = $this->session->userdata()['id_user'];
            $this->PegawaiModel->edit_cuti($data_post);
            $this->session->set_flashdata('pesan', 'Cuti berhasil ditambahkan');
            redirect('pegawai/cuti');
            return;
        }

        $data['title'] = 'Edit Cuti';
        $data['page'] = 'pegawai/form_cuti';
        $this->load->view('page', $data);
    }
    public function hapus_cuti($id)
    {
        $data = $this->PegawaiModel->getCuti(['id_pegawai' => $this->session->userdata()['id_user'], 'id_cuti' => $id])[$id];


        if ($data['status_cuti'] == 'acc_adm') {
            $this->session->set_flashdata('error', 'Cuti tidak dapat dihapus, karna di acc admin');
            redirect('pegawai/cuti');
            return;
        }

        if ($data['status_cuti'] == 'acc_kepsek') {
            $this->session->set_flashdata('error', 'Cuti tidak dapat dihapus, karna di acc kepsek');
            redirect('pegawai/cuti');
            return;
        }

        if (!empty($data))
            $this->PegawaiModel->hapus_cuti($id);
        $this->session->set_flashdata('pesan', 'dihapus');

        redirect('pegawai/cuti');
    }
    public function print_cuti($id)
    {
        try {
            $filter['id_cuti'] = $id;
            if ($this->session->userdata()['controller'] == 'pegawai') {
                $filter['id_pegawai'] = $this->session->userdata()['id_user'];
            }
            $data = $this->PegawaiModel->getCuti($filter)[$id];
            $ref = $this->ParameterModel->ref_cuti();
            require('assets/fpdf/mc_table.php');

            $pdf = new PDF_MC_Table('P', 'mm', array(220, 360));

            $pdf->SetTitle('Permohonan Cuti ' . $data['nama'] . ' ' . $data['nip'] . ' ' . $data['dari'] . ' s.d. ' . $data['sampai']);
            $pdf->SetMargins(15, 3, 15, 10, 'C');
            $pdf->AddPage();
            $pdf->SetFont('Arial', '', 13);
            $pdf->Cell(190, 6, 'FORMULIR PERMINTAAN DAN PEMBERIAN CUTI', 0, 1, 'C');
            $pdf->Cell(190, 3, 'Nomor:       /     /               /2022', 0, 1, 'C');
            $pdf->Cell(190, 2, '', 0, 1, 'C');
            $pdf->SetFont('Arial', '', 9.5);

            $pdf->Cell(190, 5, 'Tanggal : ' . tanggal_indonesia($data['tanggal_pengajuan']), 0, 1, 'R');
            $pdf->SetFont('Arial', 'B');
            $pdf->SetFillColor(230, 230, 230);
            $pdf->Cell(190, 7, ' I. DATA PEGAWAI', 1, 1, 'L', 0);
            $row_1 = 30;
            $row_2 = 20;
            $row_3 = 20;
            $row_4 = 35;
            $row_a1 = 70;
            $row_a2 =  46;
            $row_a3 = 35;
            $row_a4 =  42;
            $pdf->SetFont('Arial', '');

            $pdf->row_skp_head('Nama', $data['nama'], 'NIP', $data['nip']);
            $datetime1 = date_create($data['tmt_kerja']);
            $datetime2 = date_create($data['tanggal_pengajuan']);

            // Calculates the difference between DateTime objects
            $interval = date_diff($datetime1, $datetime2);
            $pdf->row_skp_head('Jabatan', $data['jabatan'], 'Masa Kerja', $interval->format('%y Tahun %m Bulan'));
            $pdf->row_skp_head('Unit Kerja', 'SMK NEGERI 1 BAKAM', 'Pangkat/Gol', $data['pangkat_gol']);
            $pdf->Cell(50, 5, '', 0, 1, 'C');
            $pdf->SetFont('Arial', 'B');
            $pdf->Cell(190, 7, ' II. JENIS CUTI YANG DIAMBIL', 1, 1, 'L', 0);
            $pdf->SetFont('Arial', '');
            $pdf->Cell(80, 7, ' 1. Cuti Tahunan', 1, 0, 'L');
            $p1x = $pdf->getX();
            $p1y = $pdf->getY();
            $pdf->Cell(15, 7, '', 1, 0, 'L');
            $pdf->Cell(80, 7, ' 2. Cuti Besar', 1, 0, 'L');
            $p2x = $pdf->getX();
            $p2y = $pdf->getY();
            $pdf->Cell(15, 7, '', 1, 1, 'L');

            $pdf->Cell(80, 7, ' 3. Cuti Sakit ', 1, 0, 'L');
            $p3x = $pdf->getX();
            $p3y = $pdf->getY();
            $pdf->Cell(15, 7, '', 1, 0, 'L');
            $pdf->Cell(80, 7, ' 4. Cuti Melahirkan', 1, 0, 'L');
            $p4x = $pdf->getX();
            $p4y = $pdf->getY();
            $pdf->Cell(15, 7, '', 1, 1, 'L');
            $pdf->Cell(80, 7, ' 5. Cuti Karena Alasan Penting', 1, 0, 'L');
            $p5x = $pdf->getX();
            $p5y = $pdf->getY();
            $pdf->Cell(15, 7, '', 1, 0, 'L');
            $pdf->Cell(80, 7, ' 6. Cuti di Luar Tanggungan Negara', 1, 0, 'L');
            $p6x = $pdf->getX();
            $p6y = $pdf->getY();
            $pdf->Cell(15, 7, '', 1, 1, 'L');

            $centang = base_url('assets/img/centang.png');
            if ($data['jenis'] == 1)
                $pdf->Image($centang, $p1x + 5, $p1y + 1, 5);
            else if ($data['jenis'] == 2)
                $pdf->Image($centang, $p2x + 5, $p2y + 1, 5);
            else if ($data['jenis'] == 3)
                $pdf->Image($centang, $p3x + 5, $p3y + 1, 5);
            else if ($data['jenis'] == 4)
                $pdf->Image($centang, $p4x + 5, $p4y + 1, 5);
            else if ($data['jenis'] == 5)
                $pdf->Image($centang, $p5x + 5, $p5y + 1, 5);
            else if ($data['jenis'] == 6)
                $pdf->Image($centang, $p6x + 5, $p6y + 1, 5);

            // $pdf->SetXY($c1x, $c1y);
            $pdf->Cell(15, 5, '', 0, 1, 'L');

            // $pdf->Cell(1, 5, '', 0, 1, 'C');
            $pdf->SetFont('Arial', 'B');
            $pdf->Cell(190, 7, ' III. ALASAN CUTI', 1, 1, 'L', 0);
            $pdf->SetFont('Arial', '');
            $pdf->MultiCell(190, 7, $data['alasan'], 1, 'C', 0);
            $pdf->Cell(15, 5, '', 0, 1, 'L');
            $pdf->SetFont('Arial', 'B');
            $pdf->Cell(190, 7, ' IV. LAMANYA CUTI', 1, 1, 'L', 0);
            $pdf->SetFont('Arial', '');
            $pdf->Cell(28, 7, 'Selama', 1, 0, 'L');
            $pdf->Cell(40, 7, $data['lama'] . '  ' . $data['satuan'], 1, 0, 'C');
            $pdf->Cell(30, 7, 'Mulai Tanggal', 1, 0, 'L');
            $pdf->Cell(40, 7, tanggal_indonesia($data['dari']), 1, 0, 'C');
            $pdf->Cell(12, 7, 's/d', 1, 0, 'C');
            $pdf->Cell(40, 7, tanggal_indonesia($data['sampai']), 1, 1, 'C');
            $pdf->Cell(15, 5, '', 0, 1, 'L');

            $pdf->SetFont('Arial', 'B');
            $pdf->Cell(190, 7, ' V. CATATAN CUTI ***', 1, 1, 'L', 0);
            $pdf->SetFont('Arial', '');

            $pdf->Cell(7, 7, '1.', 1, 0, 'C');
            $pdf->Cell(88, 7, 'Cuti Tahunan', 1, 0, 'L');
            $pdf->Cell(7, 7, '2.', 1, 0, 'C');
            $pdf->Cell(51, 7, 'Cuti Besar', 1, 0, 'L');
            $pdf->Cell(37, 7, '', 1, 1, 'L');

            $pdf->Cell(7, 7, '', 1, 0, 'C');
            $pdf->Cell(20, 7, 'Tahun', 1, 0, 'C');
            $pdf->Cell(15, 7, 'Sisa', 1, 0, 'C');
            $pdf->Cell(53, 7, 'Keterangan', 1, 0, 'C');
            $pdf->Cell(7, 7, '3.', 1, 0, 'C');
            $pdf->Cell(51, 7, 'Cuti Sakit', 1, 0, 'L');
            $pdf->Cell(37, 7, '', 1, 1, 'L');
            $this_year = date('Y');

            // if ($this_year == '2022') {
            //     $sisa_n = $data['cuti_n'] -
            //         $data['ct_n'];
            //     $sisa_n1 = $data['cuti_n1'] -
            //         $data['ct_n2'];
            // } else
            //                     if ($this_year == '2023') {
            //     $sisa_n = 12 -
            //         $data['ct_n'];
            //     $sisa_n1 = $data['cuti_n'] -
            //         $kt['ct_n2'] - $data['ct2_n'];
            // }
            $pdf->Cell(7, 7, '', 1, 0, 'C');
            $pdf->Cell(20, 7, explode('-', $data['sampai'])[0], 1, 0, 'C');
            $pdf->Cell(15, 7, $data['sisa_n'], 1, 0, 'C');
            $pdf->Cell(53, 7, $data['n'], 1, 0, 'C');
            $pdf->Cell(7, 7, '4.', 1, 0, 'C');
            $pdf->Cell(51, 7, 'Cuti Melahirkan', 1, 0, 'L');
            $pdf->Cell(37, 7, '', 1, 1, 'L');
            $pdf->Cell(7, 7, '', 1, 0, 'C');
            $pdf->Cell(20, 7, explode('-', $data['sampai'])[0] - 1, 1, 0, 'C');
            $pdf->Cell(15, 7, $data['sisa_n1'], 1, 0, 'C');
            $pdf->Cell(53, 7, $data['n1'], 1, 0, 'C');
            $pdf->Cell(7, 7, '5.', 1, 0, 'C');
            $pdf->Cell(51, 7, 'Cuti Karena Alasan Penting', 1, 0, 'L');
            $pdf->Cell(37, 7, '', 1, 1, 'L');

            $pdf->Cell(7, 7, '', 1, 0, 'C');
            $pdf->Cell(20, 7, '', 1, 0, 'C');
            $pdf->Cell(15, 7, "", 1, 0, 'C');
            $pdf->Cell(53, 7, '', 1, 0, 'C');
            $pdf->Cell(7, 7, '6.', 1, 0, 'C');
            $pdf->Cell(51, 7, 'Cuti di Luar Tanggungan Negara', 1, 0, 'L');
            $pdf->Cell(37, 7, '', 1, 1, 'L');

            $pdf->Cell(15, 5, '', 0, 1, 'L');
            // $pdf->Cell(15, 5, '', 0, 1, 'L');
            $pdf->SetFont('Arial', 'B');
            $pdf->Cell(190, 7, ' V. ALAMAT SELAMA MENJALANKAN CUTI', 1, 1, 'L', 0);
            $pdf->SetFont('Arial', '');
            $c1x = $pdf->getX();
            $c1y = $pdf->getY();

            $pdf->CELL(120, 44, '', 1, 0, 'L');
            $pdf->CELL(20, 7, 'Telpon', 1, 0, 'C');
            $pdf->CELL(50, 7, $data['telpon'], 1, 1, 'C');
            $pdf->SetXY($c1x + 120, $c1y + 7);
            $pdf->Cell(70, 37, "", 1, 1);
            $pdf->SetXY($c1x, $c1y + 7);
            $pdf->Cell(120, 7);
            $pdf->Cell(70, 7, 'Hormat saya,', 0, 1, 'C');



            $pdf->Cell(120, 20, '', 0, 1);
            $pdf->Cell(120, 5);
            $pdf->Cell(70, 5, $data['nama'], 0, 1, 'C');

            $pdf->Cell(120, 5);
            $pdf->Cell(70, 5, $data['nip'], 0, 1, 'C');
            $c2x = $pdf->getX();
            $c2y = $pdf->getY();
            $pdf->SetXY($c1x + 6, $c1y + 6);
            $pdf->MultiCell(110, 7, $data['alamat_cuti'], 0, 'L', 0);
            $pdf->SetXY($c2x, $c2y);

            $pdf->Cell(15, 5, '', 0, 1, 'L');
            $pdf->SetFont('Arial', 'B');
            $pdf->Cell(190, 7, ' VI. PERTIMBANGAN ATASAN LANGSUNG **', 1, 1, 'L', 0);
            $pdf->SetFont('Arial', '');
            $c1x = $pdf->getX();
            $c1y = $pdf->getY();

            $pdf->CELL(120, 44, '', 1, 0, 'L');
            $pdf->SetXY($c1x + 120, $c1y);
            $pdf->Cell(70, 44, "", 1, 1);
            $pdf->SetXY($c1x, $c1y);
            $pdf->Cell(120, 6);
            if ($data['level'] != 3) {
                $pdf->Cell(70, 6, $data['jabatan_kepsek'], 0, 1, 'C');
                $pdf->Cell(120, 2);
                $pdf->Cell(70, 2, 'SMK NEGERI 1 PARITTIGA', 0, 1, 'C');
                $pdf->Cell(120, 27, '', 0, 1);
                $pdf->Cell(120, 5);
                $pdf->Cell(70, 5, $data['nama_kepsek'], 0, 1, 'C');
                $pdf->Cell(120, 2);
                $pdf->Cell(70, 2, 'NIP. ' . $data['nip_kepsek'], 0, 1, 'C');
            } else {
                $pdf->Cell(70, 6, $ref['ak_jabatan'], 0, 1, 'C');
                // $pdf->Cell(120, 2);
                // $pdf->Cell(70, 2, '', 0, 1, 'C');
                $pdf->Cell(120, 25, '', 0, 1);
                $pdf->Cell(120, 4);
                $pdf->Cell(70, 4, $ref['ak_nama'], 0, 1, 'C');
                $pdf->Cell(120, 4);
                $pdf->Cell(70, 4, $ref['ak_pangkat_gol'], 0, 1, 'C');
                $pdf->Cell(120, 4);
                $pdf->Cell(70, 4, 'NIP. ' . $ref['ak_nip'], 0, 1, 'C');
            }

            $pdf->SetXY($c1x, $c1y);
            $pdf->Cell(25, 11, "", 1, 0, 'L');
            $pdf->Cell(29, 11, "", 1, 0, 'L');
            $pdf->Cell(34, 11, "", 1, 0, 'L');
            $pdf->Cell(32, 11, "", 1, 1, 'L');
            $pdf->Cell(30, 7, "Catatan : ", 0, 1, 'L');
            $pdf->SetXY($c1x, $c1y + 2);

            $pdf->Cell(2, 7, "", 0, 0, 'L');
            $pdf->Cell(7, 7, "", 1, 0, 'L');
            $pdf->Cell(16, 7, "Disetujui", 0, 0, 'L');
            $pdf->Cell(2, 7, "", 0, 0, 'L');
            $pdf->Cell(7, 7, "", 1, 0, 'L');
            $pdf->Cell(19, 7, "Perubahan", 0, 0, 'L');
            $pdf->Cell(3, 7, "", 0, 0, 'L');
            $pdf->Cell(7, 7, "", 1, 0, 'L');
            $pdf->Cell(24, 7, "Ditangguhkan", 0, 0, 'L');
            $pdf->Cell(3, 7, "", 0, 0, 'L');
            $pdf->Cell(7, 7, "", 1, 0, 'L');
            $pdf->Cell(20, 7, "Tidak disetujui", 0, 0, 'L');
            $pdf->SetXY($c1x + 6, $c1y + 20);
            $pdf->MultiCell(114, 6, $data['catatan_kepsek'], 0, 'L', 0);

            if ($data['level'] != 3)
                if ($data['status_cuti'] == 'acc_kepsek')
                    $pdf->Image($centang, $c1x + 3, $c1y + 3, 5);

            // $pdf->SetXY($c1x + 6, $c1y + 20);
            // $pdf->MultiCell(114, 6, '________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________', 0, 'L', 0);

            //    
            $pdf->SetXY($c1x + 190, $c1y + 43);

            $pdf->Cell(15, 5, '', 0, 1, 'L');
            $pdf->SetFont('Arial', 'B');
            $pdf->Cell(190, 7, ' VII. KEPUTUSAN PEJABAT YANG BERWENANG MEMBERIKAN CUTI **', 1, 1, 'L', 0);
            $pdf->SetFont('Arial', '');
            $c1x = $pdf->getX();
            $c1y = $pdf->getY();

            $pdf->CELL(120, 44, '', 1, 0, 'L');
            $pdf->SetXY($c1x + 120, $c1y);
            $pdf->Cell(70, 44, "", 1, 1);
            $pdf->SetXY($c1x, $c1y);
            $pdf->Cell(120, 6);
            // $pdf->Cell(70, 6, 'Kepala CabangDinas Pendidikan', 0, 1, 'C');
            $pdf->Cell(70, 6, $ref['pejabat_jabatan'], 0, 1, 'C');
            $pdf->Cell(120, 2);
            $pdf->Cell(70, 2, 'Wilayah ' . $ref['wilayah'], 0, 1, 'C');
            $pdf->Cell(120, 23, '', 0, 1);
            $pdf->Cell(120, 5);
            $pdf->Cell(70, 5, $ref['pejabat_nama'], 0, 1, 'C');
            $pdf->Cell(120, 3);
            $pdf->Cell(70, 3, $ref['pejabat_pangkat_gol'], 0, 1, 'C');
            $pdf->Cell(120, 5);
            $pdf->Cell(70, 5, "NIP. " . $ref['pejabat_nip'], 0, 1, 'C');

            $pdf->SetXY($c1x, $c1y);
            $pdf->Cell(25, 11, "", 1, 0, 'L');
            $pdf->Cell(29, 11, "", 1, 0, 'L');
            $pdf->Cell(34, 11, "", 1, 0, 'L');
            $pdf->Cell(32, 11, "", 1, 1, 'L');
            $pdf->Cell(30, 7, "Catatan : ", 0, 1, 'L');
            $pdf->SetXY($c1x, $c1y + 2);

            $pdf->Cell(2, 7, "", 0, 0, 'L');
            $pdf->Cell(7, 7, "", 1, 0, 'L');
            $pdf->Cell(16, 7, "Disetujui", 0, 0, 'L');
            $pdf->Cell(2, 7, "", 0, 0, 'L');
            $pdf->Cell(7, 7, "", 1, 0, 'L');
            $pdf->Cell(19, 7, "Perubahan", 0, 0, 'L');
            $pdf->Cell(3, 7, "", 0, 0, 'L');
            $pdf->Cell(7, 7, "", 1, 0, 'L');
            $pdf->Cell(24, 7, "Ditangguhkan", 0, 0, 'L');
            $pdf->Cell(3, 7, "", 0, 0, 'L');
            $pdf->Cell(7, 7, "", 1, 0, 'L');
            $pdf->Cell(20, 7, "Tidak disetujui", 0, 0, 'L');
            $pdf->SetXY($c1x + 6, $c1y + 20);
            $pdf->MultiCell(114, 6, '________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________', 0, 'L', 0);

            $pdf->addPage();
            $pdf->SetFont('Arial', '', 11);
            $pdf->Cell(7, 30, "", 0, 1, 'L');
            $pdf->Cell(190, 7, "Parittiga, " . tanggal_indonesia($data['tanggal_pengajuan']), 0, 1, 'R');
            $pdf->Cell(128, 7, "", 0, 0, 'L');
            $pdf->Cell(30, 7, "Kepada", 0, 1, 'L');
            $pdf->Cell(18, 7, "No", 0, 0, 'L');
            $pdf->Cell(110, 7, ": -", 0, 0, 'L');
            $pdf->Cell(50, 7, "Yth. Kepala Sekolah", 0, 1, 'L');

            $pdf->Cell(18, 7, "Sifat", 0, 0, 'L');
            $pdf->Cell(110, 7, ": -", 0, 0, 'L');
            $pdf->Cell(50, 7, "SMK Negeri 1 Parittiga ", 0, 1, 'L');

            $pdf->Cell(18, 7, "Hal", 0, 0, 'L');
            $pdf->Cell(110, 7, ": Usulan " . $data['nama_jenis_cuti'], 0, 0, 'L');
            $pdf->MultiCell(50, 4, "di - \n       Tempat");

            $pdf->Cell(190, 7, " ", 0, 1, 'L');
            $pdf->Cell(20, 7, "", 0, 0, 'L');
            $pdf->Cell(190, 7, "Dengan Hormat, ", 0, 1, 'L');
            $pdf->Cell(20, 7, "", 0, 0, 'L');
            $pdf->Cell(190, 7, "Saya yang bertanda tangan dibawah ini : ", 0, 1, 'L');
            $pdf->Cell(190, 7, " ", 0, 1, 'L');

            $pdf->Cell(30, 7, "", 0, 0, 'L');
            $pdf->Cell(25, 7, "Nama", 0, 0, 'L');
            $pdf->Cell(5, 7, ":", 0, 0, 'L');
            $pdf->Cell(95, 7, $data['nama'], 0, 1, 'L');


            $pdf->Cell(30, 7, "", 0, 0, 'L');
            $pdf->Cell(25, 7, "NIP", 0, 0, 'L');
            $pdf->Cell(5, 7, ":", 0, 0, 'L');
            $pdf->Cell(95, 7, $data['nip'], 0, 1, 'L');

            $pdf->Cell(30, 7, "", 0, 0, 'L');
            $pdf->Cell(25, 7, "Pangkat / Gol", 0, 0, 'L');
            $pdf->Cell(5, 7, ":", 0, 0, 'L');
            $pdf->Cell(95, 7, $data['pangkat_gol'], 0, 1, 'L');

            $pdf->Cell(30, 7, "", 0, 0, 'L');
            $pdf->Cell(25, 7, "Jabatan", 0, 0, 'L');
            $pdf->Cell(5, 7, ":", 0, 0, 'L');
            $pdf->Cell(95, 7, $data['jabatan'], 0, 1, 'L');

            $pdf->Cell(20, 7, "", 0, 1, 'L');
            $pdf->Cell(20, 7, "", 0, 0, 'L');
            $pdf->MultiCell(170, 7, "Dengan ini, Mengajukan {$data['nama_jenis_cuti']} dari tanggal " . tanggal_indonesia($data['dari']) . " s.d " . tanggal_indonesia($data['sampai']) . ", dengan alasan {$data['alasan']}", 0);
            $pdf->Cell(20, 3, "", 0, 1, 'L');
            $pdf->Cell(20, 7, "", 0, 0, 'L');
            $pdf->MultiCell(170, 7, "Demikian surat permohonan ini dibuat atas persetujuan dan kerjasamanya, diucapkan terima kasih.", 0);
            $pdf->Cell(20, 7, "", 0, 1, 'L');
            $pdf->Cell(120, 7, "", 0, 0, 'L');
            $pdf->Cell(170, 7, "Hormat Saya,", 0);
            $pdf->Cell(20, 25, "", 0, 1, 'L');
            $pdf->Cell(20, 7, "", 0, 1, 'L');
            $pdf->Cell(120, 7, "", 0, 0, 'L');
            $pdf->Cell(170, 7, $data['nama'], 0);
            $pdf->Cell(20, 6, "", 0, 1, 'L');
            $pdf->Cell(120, 6, "", 0, 0, 'L');
            $pdf->Cell(170, 6, 'NIP. ' . $data['nip'], 0);
            $filename = 'Permohonan Cuti ' . $id;

            $pdf->Output('', $filename, false);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
}
