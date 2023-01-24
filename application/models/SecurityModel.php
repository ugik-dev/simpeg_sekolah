<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SecurityModel extends CI_Model
{




  public function guestOnlyGuard($ajax = false)
  {
    if ($this->session->userdata('id')) {
      if ($ajax) throw new UserException('Kamu tidak berhak mengakses resource ini', UNAUTHORIZED_CODE);
      redirect('dashboard');
    }
  }

  public function userOnlyGuard($ajax = false, $forward = false)
  {
    if (!$this->session->has_userdata('id')) {
      if ($ajax) throw new UserException('Kamu tidak berhak mengakses resource ini', UNAUTHORIZED_CODE);
      if ($forward) {
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
          $url = "https://";
        else
          $url = "http://";
        // Append the host(domain name, ip) to the URL.   
        $url .= $_SERVER['HTTP_HOST'];

        // Append the requested resource location to the URL   
        $url .= $_SERVER['REQUEST_URI'];
        $this->session->set_flashdata('originnalurl', $url);
      }
      redirect('login');
    }
  }

  public function roleOnlyGuard($role, $ajax = false)
  {
    if (strtolower($this->session->userdata('user_id')['nama_role']) != $role) {
      if ($ajax) throw new UserException('Kamu tidak berhak mengakses resource ini', UNAUTHORIZED_CODE);
      redirect($this->session->userdata('nama_controller'));
    }
  }

  public function rolesOnlyGuard($roles = [], $ajax = false)
  {
    if (!in_array(strtolower($this->session->userdata('user_id')['nama_role']), $roles)) {
      if ($ajax) throw new UserException('Kamu tidak berhak mengakses resource ini', UNAUTHORIZED_CODE);
      redirect($this->session->userdata('nama_controller'));
    }
  }

  public function changePasswordValidation()
  {
    return array($this->password, $this->repassword);
  }


  private $idUser = array(
    'field' => 'username',
    'label' => 'Username',
    'rules' => 'required|trim',
  );

  private $password = array(
    'field' => 'password',
    'label' => 'Password',
    'rules' => 'required|trim'
  );

  private $repassword = array(
    'field' => 'repassword',
    'label' => 'Konfirmasi Password',
    'rules' => 'required|trim|matches[password]'
  );
}
