<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserModel extends CI_Model
{
    public function get($filter = [], $arr = false)
    {
        $this->db->from('user as u');
        $this->db->join('level as l', 'l.id_level = u.level');
        if (!empty($filter['id']))  $this->db->where('id', $filter['id']);
        if (!empty($filter['username']))  $this->db->where('username', $filter['username']);
        if (!empty($filter['status_user']))  $this->db->where('u.status_user', $filter['status_user']);
        if (!empty($filter['level']))  $this->db->where('u.level', $filter['level']);
        $res =  $this->db->get();
        if ($arr) return $res->row_array();
        return  DataStructure::keyValue($res->result_array(), 'id');
    }

    public function getPegawai($filter = [], $arr = false)
    {
        $this->db->select('p.id as id_pegawai, u.id as id_user,u.id as id, rp.nama_ptk, rs.nama_status, ');
        $this->db->select('u.*,p.*,l.*');
        $this->db->from('user as u');
        $this->db->join('level as l', 'l.id_level = u.level');
        $this->db->join('pegawai as p', 'p.id = u.id', 'left');
        $this->db->join('ref_ptk as rp', 'rp.id_ptk = p.jenis_ptk', 'left');
        $this->db->join('ref_status as rs', 'rs.id_status = p.status', 'left');
        if (!empty($filter['id']))  $this->db->where('u.id', $filter['id']);
        if (!empty($filter['username']))  $this->db->where('u.username', $filter['username']);
        if (!empty($filter['level']))  $this->db->where('u.level', $filter['level']);
        if (!empty($filter['st_sertifikasi']))  $this->db->where('p.st_sertifikasi', $filter['st_sertifikasi']);
        if (!empty($filter['jenis_kelamin']))  $this->db->where('p.jenis_kelamin', $filter['jenis_kelamin']);
        if (!empty($filter['status_user']))  $this->db->where('u.status_user', $filter['status_user']);
        $res =  $this->db->get();
        if ($arr) return $res->row_array();
        return  DataStructure::keyValue($res->result_array(), 'id_user');
    }
    public function getPegawaiDetail($filter = [], $arr = false)
    {
        $year = date('Y');
        // $year = 2023;
        $this->db->select('rs.nama_status,rt.nama_ptk, p.id as id_pegawai, u.id as id_user,u.id as id');
        $this->db->select('u.*,p.*,l.*, COALESCE(cc.ct_n , 0) as ct_n, COALESCE( cc.ct_n1,0) ct_n2 , COALESCE(cc2.ct2_n , 0) AS ct2_n');
        $this->db->from('user as u');
        $this->db->join('level as l', 'l.id_level = u.level');
        $this->db->join('pegawai as p', 'p.id = u.id', 'left');
        $this->db->join('ref_status as rs', 'p.status = rs.id_status', 'left');
        $this->db->join('ref_ptk as rt', 'p.jenis_ptk = rt.id_ptk', 'left');
        $this->db->join('(SELECT sum(n) ct_n , sum(n1) ct_n1 ,id_pegawai, YEAR(sampai) FROM `cuti` where jenis = 1 AND  status_cuti = "acc_kepsek" AND YEAR(sampai) = ' . $year . ' GROUP by id_pegawai, year(sampai)  ) as cc', 'cc.id_pegawai = u.id', 'left');
        $this->db->join('(SELECT sum(n) ct2_n ,id_pegawai, YEAR(sampai) FROM `cuti` where jenis = 1 AND status_cuti = "acc_kepsek" AND  YEAR(sampai) = ' . ($year - 1) . ' GROUP by id_pegawai, year(sampai)  ) as cc2', 'cc2.id_pegawai = u.id', 'left');


        if (!empty($filter['id']))  $this->db->where('u.id', $filter['id']);
        if (!empty($filter['tmt_start']))  $this->db->where('p.tmt_kerja > ', $filter['tmt_start']);
        if (!empty($filter['tmt_end']))  $this->db->where('p.tmt_kerja < ', $filter['tmt_end']);
        if (!empty($filter['tl_start']))  $this->db->where('p.tanggal_lahir > ', $filter['tl_start']);
        if (!empty($filter['tl_end']))  $this->db->where('p.tanggal_lahir < ', $filter['tl_end']);
        if (!empty($filter['jenis_kelamin']))  $this->db->where('p.jenis_kelamin ', $filter['jenis_kelamin']);
        if (!empty($filter['st_sertifikasi']))  $this->db->where('p.st_sertifikasi ', $filter['st_sertifikasi']);
        if (!empty($filter['kgb'])) {
            $futureDate = date('Y-m-d', strtotime('-2 year'));
            if ($filter['kgb'] == 'Y') {
                $this->db->where('p.tgl_kgb < ', $futureDate);
            } else {
                $this->db->where('p.tgl_kgb > ', $futureDate);
            }
        }

        if (!empty($filter['pensiun'])) {
            $pDate = date('Y-m-d', strtotime('-60 year'));
            if ($filter['pensiun'] == '1') {
                $this->db->where('p.tanggal_lahir < ', $pDate);
            } else  if ($filter['pensiun'] == '2') {
                $qDate = date('Y-m-d', strtotime('-719 month'));
                $this->db->where('p.tanggal_lahir < ', $qDate);
                $this->db->where('p.tanggal_lahir > ', $pDate);
            } else  if ($filter['pensiun'] == '3') {
                $this->db->where('p.tanggal_lahir > ', $pDate);
            }
        }
        if (!empty($filter['status']))  $this->db->where('p.status ', $filter['status']);
        if (!empty($filter['username']))  $this->db->where('u.username', $filter['username']);
        if (!empty($filter['status_user']))  $this->db->where('u.status_user', $filter['status_user']);

        $res =  $this->db->get();
        // echo $this->db->last_query();
        // die();
        if ($arr) return $res->row_array();
        return  DataStructure::keyValue($res->result_array(), 'id_user');
    }

    public function add_pegawai($data)
    {
        $this->db->insert('pegawai', $data);
    }

    public function edit_pegawai($data)
    {
        $this->db->where('id', $data['id']);
        $this->db->update('pegawai', $data);
    }

    public function add($data)
    {
        $this->db->set('username', $data['username']);
        $this->db->set('level', $data['level']);
        $this->db->set('status_user', $data['status_user']);
        $this->db->set('password', md5($data['password']));
        $this->db->insert('user');
    }

    public function edit($data)
    {
        $this->db->set('username', $data['username']);
        $this->db->set('level', $data['level']);
        $this->db->set('status_user', $data['status_user']);
        if (!empty($data['password'])) $this->db->set('password', md5($data['password']));
        $this->db->where('id', $data['id']);
        $this->db->update('user');
    }

    public function ganti_password($data)
    {
        $this->db->set('password', md5($data['new_password']));
        $this->db->where('id', $this->session->userdata('id_user'));
        $this->db->update('user');
    }
}
