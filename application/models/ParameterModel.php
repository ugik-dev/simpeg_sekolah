<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ParameterModel extends CI_Model
{
    public function ref_ptk($filter = [])
    {
        $this->db->from('ref_ptk');
        $this->db->order_by('nama_ptk');
        $res =  $this->db->get();
        return  $res->result_array();
    }
    public function ref_jabatan($filter = [])
    {
        $this->db->from('ref_jabatan');
        $this->db->order_by('urutan_jabatan');
        $res =  $this->db->get();
        return  $res->result_array();
    }

    public function ref_cuti($filter = [])
    {
        $this->db->from('ref_cuti');
        // $this->db->order_by('urutan_jabatan');
        $res =  $this->db->get();
        return  $res->result_array()[0];
    }


    public function getPengumuman($filter = [])
    {
        $this->db->from('pengumuman');
        if (!empty($filter['id_pengumuman'])) $this->db->where('id_pengumuman', $filter['id_pengumuman']);
        if (!empty($filter['limit'])) $this->db->limit($filter['limit'], 'desc');
        $this->db->order_by('tanggal', 'desc');
        $res =   $this->db->get();
        return  DataStructure::keyValue($res->result_array(), 'id_pengumuman');
    }

    public function pushNotif($data)
    {
        $this->db->insert('notif', $data);
    }

    public function readNotif($data)
    {
        $this->db->set('status', 1);
        $this->db->where('id_notif', $data);
        $this->db->update('notif');
    }

    public function cekNotifKGB()
    {
        $this->db->from('notif_kgb');
        $this->db->where('id_user', $this->session->userdata()['id_user']);
        $this->db->where('tgl_kgb', $this->session->userdata()['tgl_kgb']);
        $res = $this->db->get();
        $res = $res->result_array();

        if (empty($res)) {
            $notif2['id_user'] =  $this->session->userdata()['id_user'];
            $notif2['link'] = 'pegawai/data_diri/?';
            $notif2['icon'] = 'fa fa-bell';
            $notif2['text'] = $this->session->userdata()['nama'] . ' anda sudah berkah mengajukan Kenaikan Gaji Berkala.';
            $this->pushNotif($notif2);

            $nkgb['id_user'] = $this->session->userdata()['id_user'];
            $nkgb['tgl_kgb'] = $this->session->userdata()['tgl_kgb'];
            $this->db->insert('notif_kgb', $nkgb);
        } else {
            return false;
        }
        // $this->db->set('status', 1);
        // $this->db->where('id_notif', $data);
        // $this->db->update('notif');
    }
}
