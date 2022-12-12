   <?php
    defined('BASEPATH') or exit('No direct script access allowed');

    class AdminModel extends CI_Model
    {
        public function getAbsensi($filter = [], $sort = true)
        {
            $this->db->select('p.nama,p.id, p.jabatan, p.nip, pt.* ');
            $this->db->from('pegawai as p');
            if (!empty($filter['id_pegawai'])) $this->db->where('p.id', $filter['id_pegawai']);
            $this->db->join('ref_ptk as pt', 'pt.id_ptk = p.jenis_ptk', 'left');
            $this->db->join('user as u', 'u.id = p.id');
            $pegawai = $this->db->get();
            $pegawai = $pegawai->result_array();
            $ptmp = [];
            foreach ($pegawai as $p) {
                array_push($ptmp, $p['id']);
            }

            $this->db->from('absensi as c');
            if (!empty($filter['tanggal'])) $this->db->where('date(rec_time)', $filter['tanggal']);
            if (!empty($filter['bulan'])) $this->db->where('rec_time like "' . $filter['bulan'] . '%"');
            $this->db->where_in('id_pegawai', $ptmp);
            $res =  $this->db->get();
            $res =  DataStructure::absensi_rekap($pegawai, $res->result_array(), $sort);
            // echo json_encode($res);
            // die();
            return $res;
        }

        public function rec_absen($data)
        {
            if (empty($data['id_absen']))
                $this->db->insert('absensi', $data);
            else {
                $this->db->where('id_absen', $data['id_absen']);
                $this->db->update('absensi', $data);
            }
            // echo $this->db->last_query();
        }

        public function rec_pengumuman($data)
        {
            if (empty($data['id_pengumuman']))
                $this->db->insert('pengumuman', $data);
            else {
                $this->db->where('id_pengumuman', $data['id_pengumuman']);
                $this->db->update('pengumuman', $data);
            }
        }
        public function update_pengaturan_cuti($data)
        {
            $this->db->update('ref_cuti', $data);
        }

        public function delete_pengumuman($data)
        {

            $this->db->where('id_pengumuman', $data);
            $this->db->delete('pengumuman');
        }

        public function delete_user($id)
        {
            $this->db->where('id', $id);
            $this->db->delete('user');
            ExceptionHandler::handleDBError($this->db->error(), "Hapus user", "User");
        }

        public function last_mesin()
        {
            $this->db->from('absensi');
            $this->db->limit(1, 'asc');
            $this->db->where('mesin', 1);
            $this->db->order_by('rec_time', 'desc');
            $data = $this->db->get()->result_array();
            if (empty($data))
                return '2022-01-01 01:00:00';
            else
                return $data[0]['rec_time'];
            // var_dump($data);
            // die();
        }

        public function push_mesin($data)
        {
            $q2 = false;
            $query = "INSERT INTO `absensi`(`id_pegawai`, `rec_time`, `jenis`, `st_absen`, `mesin`) VALUES ";
            $i = 0;
            foreach ($data as $dat) {
                if ($i == 0)
                    $query .= " ( '{$dat->id_pegawai}', '{$dat->rec_time}' , '{$dat->jenis}' , 'h', '1' )";
                else
                    $query .= ", ( '{$dat->id_pegawai}', '{$dat->rec_time}' , '{$dat->jenis}' , 'h', '1' )";
                $i++;
                // $dat['st_absen'] = 'h'
                // $dat['mesin']
                $q2 = true;
            }
            // echo $query;
            if ($q2)
                if ($this->db->simple_query($query)) {
                    return true;
                } else {
                    return false;
                }
            return true;
        }
    }
