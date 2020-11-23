<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Soal_model extends CI_Model {

    public function soal($id,$pengajar)
    {
        $this->db->select('*,soal.id as soal_id');
        $this->db->from('soal');
        $this->db->join('ujian', 'ujian.id = soal.ujian_id');
        $this->db->where('soal.ujian_id',$id);
        $this->db->where('soal.pengajar_id',$pengajar);
        return $this->db->get();
    }

    public function hitung_soal($id,$pengajar)
    {
        $this->db->select('COUNT(*) AS hitung');
        $this->db->from('soal');
        $this->db->join('ujian', 'ujian.id = soal.ujian_id');
        $this->db->where('soal.ujian_id',$id);
        $this->db->where('soal.pengajar_id',$pengajar);
        return $this->db->get();
    }

    public function ujian($pengajar,$mapel)
    {
        $this->db->select('*');
        $this->db->from('ujian');
        // $this->db->join('kelas', 'kelas.id = mapel_kelas.kelas_id');
        // $this->db->join('mapel', 'mapel.id = mapel_kelas.mapel_id');
        $this->db->where('ujian.pengajar_id',$pengajar);
        $this->db->where('ujian.mapel_kelas_id',$mapel);
        return $this->db->get();
    }

    public function cek_soal($id)
    {
        return $this->db->get_where('soal',['id' => $id]);
    }

    public function tambah_soal($data)
    {
        return $this->db->insert('soal',$data);
    }

    public function hapus_soal($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('soal');
    }

    public function update_soal($id,$data)
    {
        $this->db->where('id', $id);
        $this->db->update('soal', $data);
    }
}