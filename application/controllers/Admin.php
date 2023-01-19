<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->db->db_debug = false;
        if (!$this->session->userdata('username')) {
            redirect('auth');
        }
        if ($this->session->userdata('controller') != 'admin' && $this->session->userdata('controller') != 'kepsek') {
            redirect($this->session->userdata('controller'));
        }
        $this->load->model(['UserModel', 'ParameterModel', 'AdminModel', 'PegawaiModel']);
    }

    public function index()
    {

        $data['title'] = 'Dashboard';
        $data['page'] = 'dashboard_adm';
        $data['jumlah_laki'] = count($this->UserModel->getPegawai(['status_user' => 'Y', 'jenis_kelamin' => 'L']));
        $data['jumlah_perempuan'] = count($this->UserModel->getPegawai(['status_user' => 'Y', 'jenis_kelamin' => 'P']));
        $data['sertifikasi'] = count($this->UserModel->getPegawai(['status_user' => 'Y', 'st_sertifikasi' => 'Y']));
        $data['jumlah_pegawai'] = count($this->UserModel->getPegawai(['status_user' => 'Y']));
        $data['pengumuman'] = $this->ParameterModel->getPengumuman(['limit' => 3]);
        $data['persentase_sertifikasi'] = round($data['sertifikasi'] / $data['jumlah_pegawai'] * 100, 0);
        $this->load->view('page', $data);
    }


    public function user()
    {
        $data['user'] = $this->UserModel->get();
        $data['title'] = 'Kelolah User';
        $data['page'] = 'admin/user';
        $this->load->view('page', $data);
    }

    public function permohonan_cuti()
    {
        $data['filter'] =  $filter = $this->input->get();
        // untuk membaca notifikasi dan berubah status menjadi sudah dibaca
        if (!empty($filter['r'])) $this->ParameterModel->readNotif($filter['r']);
        $data['cuti'] = $this->PegawaiModel->getCuti($filter);
        $data['link_reset'] = 'admin/permohonan_cuti';
        $data['user'] = $this->UserModel->get();
        $data['title'] = 'Permohonan Cuti';
        $data['page'] = 'admin/permohonan_cuti';
        $this->load->view('page', $data);
    }
    public function pengumuman()
    {
        $data['filter'] =  $filter = $this->input->get();
        // untuk membaca notifikasi dan berubah status menjadi sudah dibaca
        if (!empty($filter['r'])) $this->ParameterModel->readNotif($filter['r']);
        $data['pengumuman'] = $this->ParameterModel->getPengumuman($filter);
        $data['link_reset'] = 'admin/pengumuman';
        $data['user'] = $this->UserModel->get();
        $data['title'] = 'Pengumuman';
        $data['page'] = 'admin/pengumuman';
        $this->load->view('page', $data);
    }

    public function kepegawaian()
    {
        $data['filter'] =  $filter =    $this->input->get();
        $data['user'] = $this->UserModel->getPegawaiDetail($filter);
        // echo json_encode($data['user']);
        // die();
        $data['title'] = 'Kepegawaian';
        $data['link_reset'] = 'admin/kepegawaian';
        $data['page'] = 'admin/kepegawaian';
        $this->load->view('page', $data);
    }

    public function absensi_harian()
    {
        $filter = $this->input->get();

        // $filter['tanggal'] = '2022-10-08';
        // echo date('Y-m-d');
        // die();
        if (empty($filter['tanggal'])) $filter['tanggal'] = date('Y-m-d');

        $tmp = date_create($filter['tanggal']);
        $filter['tanggal'] =  date_format($tmp, "Y-m-d");
        // die();
        $data = [
            'title' => 'Absensi',
            'page' => 'admin/absensi_harian',
            'absensi' => $this->AdminModel->getAbsensi($filter, false),
            'tanggal' => $filter['tanggal']
        ];
        // echo json_encode($data);
        // die();
        $this->load->view('page', $data);
    }

    public function push_mesin()
    {
        $data = $this->input->post();
        $data = json_decode(stripslashes($data['data']));
        $res = $this->AdminModel->push_mesin($data);
        if ($res)
            echo json_encode(['error' => false, 'message' => 'Data berhasil di Sinkronkan']);
        else
            echo json_encode(['error' => true, 'message' => 'Data gagal Sinkronkan']);
    }

    public function absensi_bulanan()
    {
        $filter = $this->input->get();
        // inisialisasi jika tidak ada filter bulan
        if (empty($filter['bulan'])) $filter['bulan'] = date('Y-m');
        $tmp = date_create($filter['bulan']);
        $filter['bulan'] =  date_format($tmp, "Y-m");

        $filter['tahun'] = explode('-', $filter['bulan'])[0];
        $filter['bulan'] = explode('-', $filter['bulan'])[1];
        $data = [
            'title' => 'Absensi',
            'page' => 'admin/absensi',
            'absensi' => $this->AdminModel->getAbsensi($filter),
            'last_mesin' => $this->AdminModel->last_mesin(),
            'bulan' => $filter['bulan'],
            'tahun' => $filter['tahun']
        ];
        // echo json_encode($data['absensi']);
        // die();
        $this->load->view('page', $data);
    }


    public function rec_absen()
    {
        try {
            $data = $this->input->post();
            if (!empty($_FILES['file_p']['name'])) {
                $config['upload_path']          = './uploads/doc_absen';
                $config['allowed_types']        = 'pdf';
                $config['encrypt_name']            = true;
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('file_p')) {
                    throw new UserException($this->upload->display_errors(), UNAUTHORIZED_CODE);
                    // $this->load->view('upload_form', $error);
                } else {
                    $data['doc_absen_p'] =  $this->upload->data()['file_p'];
                }
            }
            // input data absen pagi dari admin
            // if (!empty($data['st_absen_p'])) {
            $data_p = [
                'id_pegawai' => $data['id_pegawai'],
                'id_absen' => $data['id_p'],
                'st_absen' => $data['st_absen_p'],
                'jenis' => 'p',
                'rec_time' => $data['tanggal'] . ' ' . $data['rec_time_p'],
            ];
            $this->AdminModel->rec_absen($data_p);
            // echo json_encode($data_p);
            // die();
            // }
            // input data absen sore dari admin
            if (!empty($data['st_absen_s'])) {
                $data_s = [
                    'id_pegawai' => $data['id_pegawai'],
                    'id_absen' => $data['id_s'],
                    'st_absen' => $data['st_absen_s'],
                    'jenis' => 's',
                    'rec_time' => $data['tanggal'] . ' ' . $data['rec_time_s'],
                ];
                $this->AdminModel->rec_absen($data_s);
            }
            // response aksi
            echo json_encode(['error' => false, 'data' => $data]);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
    public function action_pengumuman()
    {
        try {
            $data = $this->input->post();

            $this->AdminModel->rec_pengumuman($data);

            $this->session->set_flashdata('pesan', ' disimpan', '');
            redirect(base_url('admin/pengumuman'));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function delete_pengumuman($id)
    {
        try {
            $this->AdminModel->delete_pengumuman($id);
            $this->session->set_flashdata('pesan', 'dihapus', '');
            redirect(base_url('admin/pengumuman'));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function action_cuti()
    {
        try {
            $data = $this->input->post();
            $dc = $this->PegawaiModel->getCuti(['id_cuti' => $data['id_cuti']])[$data['id_cuti']];
            $this->PegawaiModel->edit_cuti($data);
            // echo $data['status_cuti'];
            $notif['id_user'] =  $dc['id_pegawai'];
            $notif['link'] = 'pegawai/cuti/?id' . $data['id_cuti'];
            // pengiriman notifikasi ke user
            if ($data['status_cuti'] == 'acc_adm') {
                // echo $dc['level'] == 3;
                // echo json_encode($dc);
                // die();
                if ($dc['level'] == '3') {

                    $notif['icon'] = 'fas fa-check';
                    $notif['text'] =  'Pengajuan cuti anda telah diterima admin';
                    $data['status_cuti'] = 'acc_kepsek';
                    $this->PegawaiModel->edit_cuti($data);
                } else {
                    $notif['icon'] = 'fas fa-check';
                    $notif['text'] =  'Pengajuan cuti anda telah diterima oleh admin dan diteruskan ke Kepela Sekolah.';
                    $notif2['id_user'] =  $this->UserModel->get(['status_user' => 'Y', 'level' => 3], true)['id'];
                    $notif2['link'] = 'kepsek/permohonan_cuti/?id=' . $data['id_cuti'];
                    $notif2['icon'] = 'far fa-user';
                    $notif2['text'] = $this->session->userdata()['nama'] . ' telah mengajuan cuti baru kepada anda.';
                    $this->ParameterModel->pushNotif($notif2);
                }
            }
            if ($data['status_cuti'] == 'tol_adm') {
                $notif['icon'] = 'fas fa-exclamation-triangle';
                $notif['text'] =  'Pengajuan cuti anda telah ditolak oleh admin.';
            } else if ($data['status_cuti'] == 'rev_adm') {
                $notif['icon'] = 'fas fa-exclamation-triangle';
                $notif['text'] =  'Pengajuan cuti anda revisi';
            }

            $this->ParameterModel->pushNotif($notif);

            $this->session->set_flashdata('pesan', 'aksi telah disimpan', '');
            redirect(base_url('admin/permohonan_cuti'));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function tambah_user()
    {
        $data['form_url'] = base_url('admin/tambah_user');
        if ($this->input->post('username') != null) {
            $data_post = $this->input->post();
            if ($data_post['password'] != $data_post['repassword']) {
                $data['title'] = 'Tambah User';
                $data['return'] = $data_post;
                $this->session->set_flashdata('error', 'Password Tidak Sama');
                $data['page'] = 'admin/form_user';
                $this->load->view('page', $data);
                return;
            }
            $this->UserModel->add($data_post);
            $this->session->set_flashdata('pesan', 'Tambah Data User');
            redirect('admin/user');
        } else {
            $data['user'] = $this->db->from('user')->get()->result();
            $data['title'] = 'Tambah User';
            // var_dump($data);
            $data['page'] = 'admin/form_user';
            $this->load->view('page', $data);
        }
    }

    public function edit_user($id)
    {
        $data['form_url'] = base_url('admin/edit_user/' . $id);
        if ($this->input->post('id') != null) {
            $data_post = $this->input->post();
            if ($data_post['password'] != $data_post['repassword']) {
                $data['title'] = 'Edit User';
                $data['return'] = $data_post;
                $this->session->set_flashdata('error', 'Password Tidak Sama');
                $data['page'] = 'admin/form_user';
                $this->load->view('page', $data);
                return;
            }
            $this->UserModel->edit($data_post);
            $this->session->set_flashdata('pesan', 'Tambah Data User');
            redirect('admin/user');
        }

        $data['return'] = $this->UserModel->get(['id' => $id])[$id];
        $data['title'] = 'Edit User';
        $data['page'] = 'admin/form_user';
        $this->load->view('page', $data);
    }

    public function form_pegawai($id)
    {
        $data['form_url'] = base_url('admin/form_pegawai/' . $id);
        $pegawai = $this->UserModel->getPegawai(['id' => $id]);
        $data['ref_ptk'] = $this->ParameterModel->ref_ptk();
        // $data['ref_jabatan'] = $this->ParameterModel->ref_jabatan();

        if (!empty($this->input->post())) {
            $data_post = $this->input->post();
            if (empty($pegawai[$id]['id_pegawai'])) {
                $add = true;
                if ($data_post['st_sertifikasi'] == 'P') {
                    $notif['id_user'] =  $id;
                    $notif['link'] = 'pegawai/data_diri/?';
                    $notif['icon'] = 'fa fa-bell';
                    $notif['text'] = 'Anda berkah mengajukan Sertifikasi';
                    $this->ParameterModel->pushNotif($notif);
                }
            } else {
                $add = false;
                if ($pegawai[$id]['st_sertifikasi'] != $data_post['st_sertifikasi']) {
                    if ($data_post['st_sertifikasi'] == 'P') {
                        $notif['id_user'] =  $id;
                        $notif['link'] = 'pegawai/data_diri/?';
                        $notif['icon'] = 'fa fa-bell';
                        $notif['text'] = 'Anda berkah mengajukan Sertifikasi';
                        $this->ParameterModel->pushNotif($notif);
                    }
                    if ($data_post['st_sertifikasi'] == 'Y') {
                        $notif['id_user'] =  $id;
                        $notif['link'] = 'pegawai/data_diri/?';
                        $notif['icon'] = 'fas fa-check';
                        $notif['text'] = 'Anda telah sertifikasi';
                        $this->ParameterModel->pushNotif($notif);
                    }
                }
            }
            $data_post['id'] = $id;
            if ($add) {
                $this->UserModel->add_pegawai($data_post);
            } else {
                $this->UserModel->edit_pegawai($data_post);
            }


            $this->session->set_flashdata('pesan', 'Berhasil simpan data kepegawaian');
            redirect('admin/kepegawaian');
            return;
        }

        // $data[]
        $data['return'] = $this->UserModel->getPegawai(['id' => $id])[$id];
        $data['title'] = 'Edit Pegawai';

        $data['page'] = 'admin/form_pegawai';
        $data['pegawaiDetail'] = $this->UserModel->getPegawaiDetail(['id' => $id])[$id];;

        $this->load->view('page', $data);
    }

    public function pengaturan_cuti()
    {

        if (!empty($this->input->post())) {


            $this->AdminModel->update_pengaturan_cuti($this->input->post());
            $this->session->set_flashdata('pesan', 'Berhasil simpan data pengaturan cuti');
            redirect('admin/pengaturan_cuti');
            return;
        }

        $data['form_url'] = base_url('admin/pengaturan_cuti/');
        $data['return'] = $this->ParameterModel->ref_cuti();
        $data['title'] = 'Pengaturan Cuti';
        $data['page'] = 'admin/form_pengaturan_cuti';
        $this->load->view('page', $data);
    }
    public function show_pegawai($id)
    {
        $pegawai = $this->UserModel->getPegawai(['id' => $id]);
        // echo json_encode($pegawai);
        // die();
        $data['ref_ptk'] = $this->ParameterModel->ref_ptk();
        $data['return'] = $this->UserModel->getPegawai(['id' => $id])[$id];
        $data['title'] = 'Pegawai';
        $data['page'] = 'admin/show_pegawai';
        $this->load->view('page', $data);
    }

    public function hapus_user($id)
    {
        try {
            $this->AdminModel->delete_user($id);
            $this->session->set_flashdata('pesan', 'Hapus Data User');

            redirect('admin/user');
        } catch (Exception $e) {
            // ExceptionHandler::handle($e);
            // echo json_encode($e->getMessage());
            $this->session->set_flashdata('error', $e->getMessage());
            redirect('admin/user');
        }
    }
    public function export_lap_cuti()
    {
        $data['filter'] =  $filter = $this->input->get();
        $filter['status_cuti'] = 'acc_kepsek';
        // untuk membaca notifikasi dan berubah status menjadi sudah dibaca
        $data = $this->PegawaiModel->getCuti($filter);

        $filter = $this->input->get();
        if (empty($filter['tahun'])) $filter['tahun'] = date('Y');
        // var_dump($filter);
        // echo json_encode($data);
        // die();
        $tahun = $filter['tahun'];

        require('assets/fpdf/mc_table.php');

        $pdf = new PDF_MC_Table('L', 'mm', array(220, 360));


        $pdf->SetTitle('Rekap Laporan Cuti ' . $tahun);
        $pdf->SetMargins(10, 10, 10, 10, 'C');
        $pdf->AddPage();
        // $pdf->Image(base_url('assets/img/tutwurihandayani.jpg'), 20, 2, 20, 20);
        $pdf->SetFont('Arial', '', 11);
        // $pdf->Cell(25, 6, '', 0, 0, 'C');
        // $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(50, 10, 'Format : PEG-9', 1, 0, 'C');
        $pdf->Cell(200, 5, ' ', 0, 0, 'C');
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(84, 5, 'Nomor Statistik Sekolah', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(250, 5, ' ', 0, 0, 'C');
        for ($i = 0; $i < 12; $i++) {
            $pdf->Cell(7, 5, '', 1, 0, 'C');
        }
        $pdf->Cell(7, 5, '', 0, 1, 'C');
        $pdf->Cell(7, 5, '', 0, 1, 'C');
        // $pdf->Cell(80, 5, 'Nomor Statistik Sekolah', 1, 1, 'C');
        // $pdf->SetX()
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(335, 5, 'BUKU CUTI PEGAWAI/GURU', 0, 1, 'C');
        $pdf->Cell(335, 5, 'SMK NEGERI 1 PARITTIGA', 0, 1, 'C');
        $pdf->Cell(335, 5, 'TAHUN : ' . $tahun, 0, 1, 'C');
        $pdf->SetFont('Arial', '', 11);
        // $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(25, 4, '', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(10, 12, 'NO.', 1, 0, 'C');
        $pdf->Cell(55, 12, 'Nama Pegawai.', 1, 0, 'C');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(110, 6, 'Cuti yang telah Diambil Dalam Tahun Kalender yang Lampau', 1, 0, 'C');
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(110, 6, 'Cuti yang telah Diambil Dalam Tahun Ini ', 1, 0, 'C');
        $pdf->Cell(50, 12, 'Keteragan ', 1, 1, 'C');
        $pdf->SetY($pdf->GetY() - 6);
        $pdf->Cell(65, 6, '', 0, 0, 'C');
        $pdf->Cell(30, 6, 'Jumlah Cuti', 1, 0, 'C');
        $pdf->Cell(50, 6, 'Dari tanggal s.d tanggal', 1, 0, 'C');
        $pdf->Cell(30, 6, 'Berapa Hari', 1, 0, 'C');
        $pdf->Cell(30, 6, 'Jumlah Cuti', 1, 0, 'C');
        $pdf->Cell(50, 6, 'Dari tanggal s.d tanggal', 1, 0, 'C');
        $pdf->Cell(30, 6, 'Berapa Hari', 1, 1, 'C');
        $pdf->Cell(10, 6, '1', 1, 0, 'C');
        $pdf->Cell(55, 6, '2', 1, 0, 'C');
        $pdf->Cell(30, 6, '3', 1, 0, 'C');
        $pdf->Cell(50, 6, '4', 1, 0, 'C');
        $pdf->Cell(30, 6, '5', 1, 0, 'C');
        $pdf->Cell(30, 6, '6', 1, 0, 'C');
        $pdf->Cell(50, 6, '7', 1, 0, 'C');
        $pdf->Cell(30, 6, '8', 1, 0, 'C');
        $pdf->Cell(50, 6, '9', 1, 1, 'C');
        $pdf->SetFont('Arial', '', 11);

        $i = 1;
        foreach ($data as $d) {

            $pdf->Cell(10, 6, $i, 1, 0, 'C');
            $pdf->Cell(55, 6, $d['nama'], 1, 0, 'L');
            if ($d['id_jenis_cuti'] == '1') {
                if (!empty($d['n1'])) {
                    $pdf->Cell(30, 6, $d['n1'], 1, 0, 'C');
                    $pdf->Cell(50, 6, $d['dari'] . ' s.d ' . $d['sampai'], 1, 0, 'C');
                    $pdf->Cell(30, 6, $d['n1'] . ' hari', 1, 0, 'C');
                } else {
                    $pdf->Cell(30, 6, ' ', 1, 0, 'C');
                    $pdf->Cell(50, 6, ' ', 1, 0, 'C');
                    $pdf->Cell(30, 6, ' ', 1, 0, 'C');
                }
                if (!empty($d['n'])) {
                    $pdf->Cell(30, 6, $d['n'], 1, 0, 'C');
                    $pdf->Cell(50, 6, $d['dari'] . ' s.d ' . $d['sampai'], 1, 0, 'C');
                    $pdf->Cell(30, 6, $d['n'] . ' hari', 1, 0, 'C');
                } else {
                    $pdf->Cell(30, 6, ' ', 1, 0, 'C');
                    $pdf->Cell(50, 6, ' ', 1, 0, 'C');
                    $pdf->Cell(30, 6, ' ', 1, 0, 'C');
                }
            } else {
                $pdf->Cell(30, 6, ' ', 1, 0, 'C');
                $pdf->Cell(50, 6, ' ', 1, 0, 'C');
                $pdf->Cell(30, 6, ' ', 1, 0, 'C');
                $pdf->Cell(30, 6, ' ', 1, 0, 'C');
                $pdf->Cell(50, 6, $d['dari'] . ' s.d ' . $d['sampai'], 1, 0, 'C');
                $pdf->Cell(30, 6, $d['lama'] . ' ' . $d['satuan'], 1, 0, 'C');
            }
            $pdf->Cell(50, 6, $d['nama_jenis_cuti'], 1, 1, 'L');
            // echo json_encode($d);
            // die();
            $i++;
        }
        $kepsek =  $this->UserModel->getPegawai(['status_user' => 'Y', 'level' => 3], true);
        $pdf->CheckPageBreak(65);
        $pdf->Cell(100, 5, '', 0, 1, 'C', 0);
        $pdf->Cell(250, 5, '', 0, 0, 'C', 0);
        $pdf->Cell(70, 5, 'Parittiga, ' . tanggal_indonesia(date('Y-m-d')), 0, 1, 'C', 0);
        $pdf->Cell(250, 5, '', 0, 0, 'C', 0);
        $pdf->Cell(70, 5, $kepsek['jabatan'], 0, 1, 'C', 0);
        $pdf->Cell(1, 30, '', 0, 1, 'C', 0);
        $pdf->Cell(250, 5, '', 0, 0, 'C', 0);
        $pdf->Cell(70, 5, $kepsek['nama'], 0, 1, 'C', 0);
        $pdf->Cell(250, 5, '', 0, 0, 'C', 0);
        $pdf->Cell(70, 5, 'NIP ' . $kepsek['nip'], 0, 1, 'C', 0);
        $filename = 'Rekap Laporan Cuti ' . $tahun . ".pdf";

        $pdf->Output('', $filename, false);
    }
    public function print_absensi_bulanan()
    {
        $filter = $this->input->get();
        if (empty($filter['bulan'])) $filter['bulan'] = date('Y-m');
        $tmp = date_create($filter['bulan']);
        $filter['bulan'] =  date_format($tmp, "Y-m");

        $absensi = $this->AdminModel->getAbsensi($filter);
        $kepsek =  $this->UserModel->getPegawai(['status_user' => 'Y', 'level' => 3], true);
        // echo json_encode($kepsek);
        // die();
        $bulan = $filter['bulan'];

        require('assets/fpdf/mc_table.php');

        $pdf = new PDF_MC_Table('P', 'mm', array(220, 360));


        $pdf->SetTitle('Rekap Absensi ' . $bulan);
        $pdf->SetMargins(5, 3, 15, 10, 'C');
        $pdf->AddPage();
        $pdf->Image(base_url('assets/img/tutwurihandayani.jpg'), 20, 2, 20, 20);
        $pdf->SetFont('Arial', '', 13);
        $pdf->Cell(25, 6, '', 0, 0, 'C');
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(185, 7, 'SMK NEGERI 1 PARITTIGA', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(25, 4, '', 0, 0, 'C');
        $pdf->Cell(185, 4, 'Jl. Rambat Desa Sekar Biru, Kec. Parittiga Kab. Bangka Barat', 0, 1, 'C');
        $pdf->Cell(25, 4, '', 0, 0, 'C');
        $pdf->Cell(185, 4, 'Kode Pos 33363', 0, 1, 'C');
        $pdf->Cell(25, 4, '', 0, 0, 'C');
        $pdf->Cell(185, 4, 'Kecamatan Parittiga Kabupaten Bangka Barat Provinsi Kep. Bangka Belitung', 0, 1, 'C');
        $pdf->Line($pdf->GetX(), $pdf->GetY() + 3, $pdf->GetX() + 209, $pdf->GetY() + 3);
        $pdf->Line($pdf->GetX(), $pdf->GetY() + 4, $pdf->GetX() + 209, $pdf->GetY() + 4);
        $pdf->SetFont('Arial', '', 9.5);

        // $pdf->Cell(190, 5, 'Tanggal : ' . tanggal_indonesia($data['tanggal_pengajuan']), 0, 1, 'R');
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetFillColor(230, 230, 230);
        $pdf->Cell(190, 7, ' ', 0, 1, 'L', 0);
        $pdf->Cell(210, 5, 'SURAT PERNYATAAN TANGGUNG JAWAB MUTLAK', 0, 1, 'C', 0);
        $pdf->Cell(210, 5, 'BULAN ' . strtoupper(bulan_indo(explode('-', $bulan)[1])) . ' ' . explode('-', $bulan)[0], 0, 1, 'C', 0);

        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(210, 5, 'Yang bertandatangan di bawah ini : ', 0, 1, 'L', 0);
        $pdf->Cell(50, 5, 'Nama', 0, 0, 'L', 0);
        $pdf->Cell(3, 5, ':', 0, 0, 'L', 0);
        $pdf->Cell(160, 5, $kepsek['nama'], 0, 1, 'L', 0);

        $pdf->Cell(50, 5, 'Tempat, Tanggal Lahir ', 0, 0, 'L', 0);
        $pdf->Cell(3, 5, ':', 0, 0, 'L', 0);
        $pdf->Cell(160, 5, $kepsek['tempat_lahir'] . ', ' . tanggal_indonesia($kepsek['tanggal_lahir']), 0, 1, 'L', 0);

        $pdf->Cell(50, 5, 'NIP', 0, 0, 'L', 0);
        $pdf->Cell(3, 5, ':', 0, 0, 'L', 0);
        $pdf->Cell(160, 5, $kepsek['nip'], 0, 1, 'L', 0);

        $pdf->Cell(50, 5, 'Jabatan', 0, 0, 'L', 0);
        $pdf->Cell(3, 5, ':', 0, 0, 'L', 0);
        $pdf->Cell(160, 5, $kepsek['jabatan'], 0, 1, 'L', 0);

        $pdf->Cell(50, 5, 'Tempat Tugas', 0, 0, 'L', 0);
        $pdf->Cell(3, 5, ':', 0, 0, 'L', 0);
        $pdf->Cell(160, 5, 'SMK NEGERI 1 PARITTIGA', 0, 1, 'L', 0);

        $pdf->Cell(50, 5, 'Alamat Kantor', 0, 0, 'L', 0);
        $pdf->Cell(3, 5, ':', 0, 0, 'L', 0);
        $pdf->MultiCell(160, 4, "JL. DUSUN RAMBAT DESA SEKAR BIRU KECAMATAN PARITTIGA \nKABUPATEN BANGKA BARAT PROVINSI KEP. BANGKA BELITUNG");
        $pdf->Cell(3, 5, "", 0, 1, 'L', 0);
        $pdf->MultiCell(205, 4, "Menyatakan dengan ini bertanggung jawab sepenuhnya terhadap kebenaran data absensi guru yang tertera pada daftar di bawah. Apabila di kemudian hari terbukti bahwa data yang saya berikan tidak sesuai dengan data sebenarnya sehingga dapat menyebabkan kerugian Negara dan kerugian pihak-pihak lain, saya bersedia di kenakan sanksi sesuai dengan ketentuan peraturan Perundang-undangan.");
        $pdf->Cell(3, 5, "", 0, 1, 'L', 0);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(210, 5, 'DAFTAR ABSENSI KEHADIRAN GURU PEGAWAI BULAN ' . strtoupper(bulan_indo(explode('-', $bulan)[1])) . ' ' . explode('-', $bulan)[0], 0, 1, 'C', 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(3, 5, "", 0, 1, 'L', 0);
        $cur_x = $pdf->getX();
        $cur_y = $pdf->GetY();
        $pdf->Cell(7, 10, "No", 1, 0, 'C', 0);
        $pdf->Cell(56, 10, "Nama", 1, 0, 'C', 0);
        $pdf->Cell(26, 10, "Jabatan", 1, 0, 'C', 0);
        $pdf->MultiCell(14, 5, "Jlh Hari\n Kerja", 1, 'C');
        $pdf->SetXY($cur_x + 103, $cur_y);
        $pdf->Cell(11, 10, "Hadir", 1, 0, 'C', 0);
        $pdf->MultiCell(21, 5, "Hadir Tidak\n Full", 1, 'C');
        $pdf->SetXY($cur_x + 135, $cur_y);
        $pdf->Cell(11, 10, "Izin", 1, 0, 'C', 0);
        $pdf->Cell(11, 10, "Sakit", 1, 0, 'C', 0);
        $pdf->Cell(11, 10, "Cuti", 1, 0, 'C', 0);
        $pdf->MultiCell(13, 5, "Dinas\nLuar", 1, 'C');
        $pdf->SetXY($cur_x + 181, $cur_y);
        $pdf->MultiCell(26, 5, "Tidak Hadir\n(Termasuk DL)", 1, 'C');
        $thn = explode('-', $bulan)[0];
        $bln = explode('-', $bulan)[1];



        $jlh_hari_kerja = 0;
        $td_tgl = '';
        $arr_tgl = [];
        for ($i = 1; $i < 31; $i++) {
            $hari = date("l", mktime(0, 0, 0, $bln, $i, $thn));
            // deteksi hari kerja
            // $hari != 'Saturday' && :untuk hari sabtu 
            if ($hari != 'Saturday' &&  $hari != 'Sunday' && $hari != '-') {
                array_push($arr_tgl, $i);
                $jlh_hari_kerja++;
            }
        }
        foreach ($absensi as $key => $usr) {
            $absensi[$key]['h'] = 0;
            $absensi[$key]['htf'] = 0;
            $absensi[$key]['i'] = 0;
            $absensi[$key]['s'] = 0;
            $absensi[$key]['c'] = 0;
            $absensi[$key]['dl'] = 0;
            foreach ($arr_tgl as $i) {
                if (!empty($usr['child'][$thn][$bln][$i]['s']) && !empty($usr['child'][$thn][$bln][$i]['p'])) {

                    $absensi[$key]['h']++;
                } else if (!empty($usr['child'][$thn][$bln][$i]['p'])) {
                    if ($usr['child'][$thn][$bln][$i]['p']['st_absen'] == 'i')
                        $absensi[$key]['i']++;
                    if ($usr['child'][$thn][$bln][$i]['p']['st_absen'] == 's')
                        $absensi[$key]['s']++;
                    if ($usr['child'][$thn][$bln][$i]['p']['st_absen'] == 'dl')
                        $absensi[$key]['dl']++;
                    if ($usr['child'][$thn][$bln][$i]['p']['st_absen'] == 'c')
                        $absensi[$key]['c']++;
                    if ($usr['child'][$thn][$bln][$i]['p']['st_absen'] == 'h')
                        $absensi[$key]['htf']++;
                } else {
                }
            }
        }

        $i = 1;
        $total_th = 0;
        foreach ($absensi as $key => $usr) {
            $ttl = $usr['dl'] + $usr['i'] + $usr['s'] + $usr['c'];
            $total_th = $total_th + $ttl;
            // $pdf->Cell(3, 5, $i, 0, 1, 'C', 0);
            $pdf->row_absensi($i, $ttl, $jlh_hari_kerja, $usr);
            // endforeach;
            // $pdf->Cell(7, 10, $i, 1, 0, 'C', 0);
            // $pdf->Cell(56, 10, $usr['nama'], 1, 0, 'L', 0);
            // $pdf->Cell(26, 10, $usr['nama_ptk'], 1, 0, 'C', 0);
            // $pdf->Cell(14, 10, $jlh_hari_kerja, 1, 0, 'C', 0);
            // $pdf->Cell(11, 10, $usr['h'], 1, 0, 'C', 0);
            // $pdf->Cell(21, 10, $usr['htf'], 1, 0, 'C', 0);
            // // $pdf->MultiCell(21, 5, $usr['htf'], 1, 'C');
            // $pdf->Cell(11, 10, $usr['i'], 1, 0, 'C', 0);
            // $pdf->Cell(11, 10, $usr['s'], 1, 0, 'C', 0);
            // $pdf->Cell(11, 10, $usr['c'], 1, 0, 'C', 0);
            // $pdf->Cell(13, 10, $usr['dl'], 1, 0, 'C', 0);
            // $pdf->Cell(26, 10, $ttl, 1, 1, 'C', 0);


            $i++;
        }
        $pdf->Cell(181, 5, "", 0, 0, 'C', 0);
        $pdf->Cell(26, 5, $total_th, 1, 1, 'C', 0);
        $pdf->Cell(26, 5, '', 0, 1, 'C', 0);
        $pdf->CheckPageBreak(65);
        $pdf->Cell(26, 5, 'Demikian Surat Pernyataan ini saya buat dengan sadar dan tanpa ada paksaan dari pihak manapun.', 0, 1, 'l', 0);
        $pdf->Cell(26, 5, '', 0, 1, 'C', 0);
        $pdf->Cell(130, 5, '', 0, 0, 'C', 0);
        $pdf->Cell(70, 5, 'Parittiga, ' . tanggal_indonesia(date('Y-m-d')), 0, 1, 'C', 0);
        $pdf->Cell(130, 5, '', 0, 0, 'C', 0);
        $pdf->Cell(70, 5, $kepsek['jabatan'], 0, 1, 'C', 0);
        $pdf->Cell(1, 30, '', 0, 1, 'C', 0);
        $pdf->Cell(130, 5, '', 0, 0, 'C', 0);
        $pdf->Cell(70, 5, $kepsek['nama'], 0, 1, 'C', 0);
        $pdf->Cell(130, 5, '', 0, 0, 'C', 0);
        $pdf->Cell(70, 5, $kepsek['pangkat_gol'], 0, 1, 'C', 0);
        $pdf->Cell(130, 5, '', 0, 0, 'C', 0);
        $pdf->Cell(70, 5, 'NIP ' . $kepsek['nip'], 0, 1, 'C', 0);
        $filename = 'Rekap Absensi ' . $bulan;

        $pdf->Output('', $filename, false);
    }
}
