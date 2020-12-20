<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas_model extends CI_Model {

    public function pengajar()
    {
        return $this->db->get('pengajar');
    }

    public function kelas()
    {
        return $this->db->get('kelas');
    }

    public function tambah_kelas($data)
    {
        return $this->db->insert('kelas',$data);
    }

    public function edit_kelas($id)
    {
        return $this->db->get_where('kelas',['id' => $id]);
    }

    public function hapus_kelas($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('kelas');
    }

    public function update_kelas($id,$data)
    {
        $this->db->where('id', $id);
        $this->db->update('kelas', $data);
    }
}