<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kepsek extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('username')) {
            redirect('auth');
        }
        if ($this->session->userdata('controller') != 'kepsek') {
            // echo 'x';
            // die();
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


    public function permohonan_cuti()
    {
        $filter = $this->input->get();
        if (!empty($filter['r'])) $this->ParameterModel->readNotif($filter['r']);
        if (empty($filter['status_cuti'])) {
            // $filter['status_cuti'] = 'acc_adm';
        }
        // $filter['id_pegawai'] = $this->session->userdata('id');
        $data['cuti'] = $this->PegawaiModel->getCuti($filter);
        // echo json_encode($data);
        // die();      
        $data['link_reset'] = 'kepsek/permohonan_cuti';
        $data['user'] = $this->UserModel->get();
        $data['title'] = 'Permohonan Cuti';
        $data['filter'] = $filter;
        $data['page'] = 'admin/permohonan_cuti';
        $this->load->view('page', $data);
    }

    public function kepegawaian()
    {
        $data['filter'] =  $filter =    $this->input->get();
        $data['user'] = $this->UserModel->getPegawaiDetail($filter);
        $data['link_reset'] = 'kepsek/kepegawaian';
        $data['title'] = 'Kepegawaian';
        $data['page'] = 'admin/kepegawaian';
        $this->load->view('page', $data);
    }
    public function action_cuti()
    {
        try {
            $data = $this->input->post();
            // if()
            $this->PegawaiModel->edit_cuti($data);
            $dc = $this->PegawaiModel->getCuti(['id_cuti' => $data['id_cuti']])[$data['id_cuti']];

            $notif['id_user'] =  $dc['id_pegawai'];
            $notif['link'] = 'pegawai/cuti/?id' . $data['id_cuti'];
            if ($data['status_cuti'] == 'acc_kepsek') {
                $notif['icon'] = 'fas fa-check';
                $notif['text'] =  'Selamat Pengajuan Cuti anda telah di terima oleh ke Kepela Sekolah.';
            }
            if ($data['status_cuti'] == 'tol_kepsek') {
                $notif['icon'] = 'fas fa-exclamation-triangle';
                $notif['text'] =  'Pengajuan cuti anda telah ditolak oleh Kepala Sekolah.';
            } else if ($data['status_cuti'] == 'rev_kepsek') {
                $notif['icon'] = 'fas fa-exclamation-triangle';
                $notif['text'] =  'Pengajuan cuti anda revisi oleh Kepala Sekolah';
            }

            $this->ParameterModel->pushNotif($notif);

            $this->session->set_flashdata('pesan', 'Aksi disimpan');
            redirect(base_url('admin/permohonan_cuti'));

            // echo json_encode(['error' => false, 'data' => $data]);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
    public function absensi_harian()
    {
        $filter = $this->input->get();

        // $filter['tanggal'] = '2022-10-08';
        if (empty($filter['tanggal'])) $filter['tanggal'] = date('Y-m-d');

        $tmp = date_create($filter['tanggal']);
        $filter['tanggal'] =  date_format($tmp, "Y-m-d");
        // die();
        $data = [
            'title' => 'Absensi',
            'page' => 'admin/absensi_harian',
            'absensi' => $this->AdminModel->getAbsensi($filter),
            'tanggal' => $filter['tanggal']
        ];

        $this->load->view('page', $data);
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
            'bulan' => $filter['bulan'],
            'tahun' => $filter['tahun']
        ];

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
            if (!empty($data['st_absen_p'])) {
                $data_p = [
                    'id_pegawai' => $data['id_pegawai'],
                    'id_absen' => $data['id_p'],
                    'st_absen' => $data['st_absen_p'],
                    'jenis' => 'p',
                    'rec_time' => $data['tanggal'] . ' ' . $data['rec_time_p'],
                ];
                $this->AdminModel->rec_absen($data_p);
            }
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
            echo json_encode(['error' => false, 'data' => $data]);
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
            redirect('admin/kepegawaian');
            return;
        }

        $data['return'] = $this->UserModel->getPegawai(['id' => $id])[$id];
        $data['title'] = 'Edit Pegawai';

        $data['page'] = 'admin/form_pegawai';
        $this->load->view('page', $data);
    }
}
