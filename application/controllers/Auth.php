<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function index()
    {
        if ($this->session->userdata('username')) {
            redirect('dashboard');
        }
        $this->form_validation->set_rules(
            'username',
            'Username',
            'required|trim',
            [
                'required' => 'Username Tidak Boleh Kosong'
            ]
        );

        $this->form_validation->set_rules('password', 'Password', 'required|trim', [
            'required' => 'Password Tidak Boleh Kosong'
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('auth/index');
        } else {
            $this->_login();
        }
    }

    private function _login()
    {
        $username = htmlspecialchars($this->input->post('username'));
        $password = $this->input->post('password');

        $this->load->model('UserModel');
        $user = $this->UserModel->getPegawai(['username' => $username], true);

        if ($user) {
            if ($user['status_user'] == 'Y') {
                if (md5($password) == $user['password']) {
                    $this->session->set_userdata($user);
                    $this->session->set_flashdata('pesan', 'Login');


                    $now = new DateTime();
                    $since_start = $now->diff(new DateTime($user['tgl_kgb']));
                    if ($since_start->y >= 2) {
                        $this->load->model('ParameterModel');
                        $this->ParameterModel->cekNotifKGB();
                    }

                    redirect(base_url($user['controller']));
                } else {
                    $this->session->set_flashdata('error', 'Password Salah');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('error', 'Maaf Data Non-Aktif');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('error', 'Username Belum Terdaftar');
            redirect('auth');
        }
    }
    public function ganti_password()
    {
        $data = $this->input->post();
        $this->load->model('UserModel');

        if (md5($data['old_password']) != $this->session->userdata('password')) {
            $this->session->set_flashdata('error', 'Password Lama Salah');
        } else {
            if (empty($data['new_password'])) {
                $this->session->set_flashdata('error', 'Password Kosong');
            } else {

                if ($data['new_repassword'] != $data['new_password']) {
                    $this->session->set_flashdata('error', 'Password Tidak sama');
                } else {
                    $this->UserModel->ganti_password($data);
                    $this->session->set_flashdata('pesan', 'Password Berhasil dirubah');
                }
            }
        }
        redirect(base_url() . 'pegawai/data_diri');
    }

    public function logout()
    {
        $this->session->unset_userdata('username');
        $this->session->set_flashdata('pesan', 'Logout');
        redirect('auth');
    }
}
