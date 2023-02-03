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
        if (empty($filter['tanggal'])) $filter['tanggal'] = date('Y-m-d');

        $tmp = date_create($filter['tanggal']);
        if ($filter['tanggal'] == date('Y-m-d')) {
            $edit = true;
        } else {
            $edit = false;
        }
        $filter['tanggal'] =  date_format($tmp, "Y-m-d");
        // if($filter['tanggal'])
        // var_dump($filter['tanggal']);
        if ($filter['tanggal'] > date('Y-m-d')) {
            $data = [
                'title' => 'Absensi',
                'page' => 'errorpage',
                'message' => 'Maaf, tanggal ini belum tersedia!!'
            ];
            $this->load->view('page', $data);
            return;
        }
        // die();
        $data = [
            'title' => 'Absensi',
            'page' => 'admin/absensi_harian',
            'absensi' => $this->AdminModel->getAbsensi($filter, false),
            'tanggal' => $filter['tanggal'],
            'edit' => $edit
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
                } else {
                    $data['doc_absen_p'] =  $this->upload->data()['file_p'];
                }
            }
            // input data absen pagi dari admin
            $data_p = [
                'id_pegawai' => $data['id_pegawai'],
                'id_absen' => $data['id_p'],
                'st_absen' => $data['st_absen_p'],
                'jenis' => 'p',
                // 'rec_time' => $data['tanggal'] . ' ' . $data['rec_time_p'],
            ];
            $this->AdminModel->rec_absen($data_p);
            // input data absen sore dari admin
            if (!empty($data['st_absen_s'])) {
                $data_s = [
                    'id_pegawai' => $data['id_pegawai'],
                    'id_absen' => $data['id_s'],
                    'st_absen' => $data['st_absen_s'],
                    'jenis' => 's',
                    // 'rec_time' => $data['tanggal'] . ' ' . $data['rec_time_s'],
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
            $notif['id_user'] =  $dc['id_pegawai'];
            $notif['link'] = 'pegawai/cuti/?id' . $data['id_cuti'];
            // pengiriman notifikasi ke user
            if ($data['status_cuti'] == 'acc_adm') {
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
        $data['ref_cuti'] = $this->ParameterModel->ref_cuti();

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
            $this->session->set_flashdata('error', $e->getMessage());
            redirect('admin/user');
        }
    }

    public function print_absensi_bulanan()
    {
        $filter = $this->input->get();
        // inisialisasi jika tidak ada filter bulan
        if (empty($filter['bulan'])) $filter['bulan'] = date('Y-m');
        $tmp = date_create($filter['bulan']);
        $filter['bulan'] =  date_format($tmp, "Y-m");

        $filter['tahun'] = explode('-', $filter['bulan'])[0];
        $filter['bulan'] = explode('-', $filter['bulan'])[1];

        $absensi = $this->AdminModel->getAbsensi($filter);
        $kepsek =  $this->UserModel->getPegawai(['status_user' => 'Y', 'level' => 3], true);

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


        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetFillColor(230, 230, 230);
        $pdf->Cell(190, 7, ' ', 0, 1, 'L', 0);
        $pdf->Cell(210, 5, 'SURAT PERNYATAAN TANGGUNG JAWAB MUTLAK', 0, 1, 'C', 0);
        $pdf->Cell(210, 5, 'BULAN ' . strtoupper(bulan_indo($filter['bulan'])) . ' ' . $filter['tahun'], 0, 1, 'C', 0);

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
        $pdf->Cell(210, 5, 'DAFTAR ABSENSI KEHADIRAN GURU PEGAWAI BULAN ' . strtoupper(bulan_indo($filter['bulan'])) . ' ' . $filter['tahun'], 0, 1, 'C', 0);
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
        $thn = $filter['tahun'];
        $bln = (int) $filter['bulan'];



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
            $pdf->row_absensi($i, $ttl, $jlh_hari_kerja, $usr);

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
