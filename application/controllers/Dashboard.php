<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('username')) {
            redirect('auth');
        }
        $this->load->model(['ParameterModel', 'UserModel']);
    }

    public function index()
    {
        if (!empty($this->session->userdata()['controller'])) {
            redirect(base_url($this->session->userdata()['controller']));
        }
    }

    public function buka_pengumuman($id)
    {
        $data['pengumuman'] = $this->ParameterModel->getPengumuman(['id_pengumuman' => $id])[$id];
        $data['title'] = "Pengumuman";
        $data['page'] = 'pengumuman_detail';
        $this->load->view('page', $data);
    }

    public function pengumuman()
    {
        $data['pengumuman'] = $this->ParameterModel->getPengumuman(['limit' => 30]);
        $data['title'] = "Pengumuman";
        $data['page'] = 'pengumuman';
        $this->load->view('page', $data);
    }
}
