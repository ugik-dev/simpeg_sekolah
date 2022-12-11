<?php
defined('BASEPATH') or exit('No direct script access allowed');

class General extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('username')) {
            redirect('auth');
        }

        $this->load->model(['ParameterModel']);
    }

    public function getAllJenisBankData()
    {
        try {
            $filter = $this->input->post();
            $filter['id_user'] = $this->session->userdata()['id_user'];
            $data = $this->ParameterModel->getAllJenisBankData($filter);
            echo json_encode(['error' => false, 'data' => $data]);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
}
