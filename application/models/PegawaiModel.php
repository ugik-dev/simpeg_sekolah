<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PegawaiModel extends CI_Model
{
    public function getAbsensi($filter = [])
    {
        $this->db->from('absensi as c');
        $res =  $this->db->get();
        return  DataStructure::absensi($res->result_array(), 'id_absensi');
    }




    public function getCuti($filter = [])
    {
        $this->db->select('c.*, p.*, jc.*,u.level, ks.nama as nama_kepsek,ks.nip as nip_kepsek,ks.jabatan as jabatan_kepsek');
        $this->db->from('cuti as c');
        $this->db->join('pegawai as p', 'p.id = c.id_pegawai', 'left');
        $this->db->join('user as u', 'p.id = u.id', 'left');
        $this->db->join('pegawai as ks', 'ks.id = c.id_kepsek', 'left');
        $this->db->join('ref_jenis_cuti as jc', 'jc.id_jenis_cuti = c.jenis', 'left');
        if (!empty($filter['id_cuti']))  $this->db->where('c.id_cuti', $filter['id_cuti']);
        if (!empty($filter['jenis_cuti']))  $this->db->where('c.jenis', $filter['jenis_cuti']);
        if (!empty($filter['id']))  $this->db->where('c.id_cuti', $filter['id']);
        if (!empty($filter['id_pegawai']))  $this->db->where('c.id_pegawai', $filter['id_pegawai']);
        if (!empty($filter['status_cuti']))  $this->db->where('c.status_cuti', $filter['status_cuti']);
        if (!empty($filter['tgl_start']))  $this->db->where('c.dari >= ', $filter['tgl_start']);
        if (!empty($filter['tgl_end']))  $this->db->where('c.sampai <= ', $filter['tgl_end']);

        $res =  $this->db->get();
        return  DataStructure::keyValue($res->result_array(), 'id_cuti');
    }

    public function getGajiBerkala($filter = [])
    {
        $this->db->from('gaji_berkala as c');
        $this->db->join('pegawai as p', 'p.id = c.id_pegawai', 'left');
        if (!empty($filter['id_cuti']))  $this->db->where('c.id_cuti', $filter['id_cuti']);
        if (!empty($filter['id_pegawai']))  $this->db->where('c.id_pegawai', $filter['id_pegawai']);

        $res =  $this->db->get();
        return  DataStructure::keyValue($res->result_array(), 'id_cuti');
    }


    public function add_cuti($data)
    {
        $this->db->insert('cuti', $data);

        return $this->db->insert_id();
    }


    public function edit_cuti($data)
    {
        $this->db->where('id_cuti', $data['id_cuti']);
        $this->db->update('cuti', $data);
    }

    public function hapus_cuti($id)
    {
        $this->db->where('id_cuti', $id);
        $this->db->delete('cuti');
    }
}
