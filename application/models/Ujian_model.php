<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ujian_model extends CI_Model {

    public function kelas($id)
    {
        $this->db->select('*,kelas.nama as kelas_nama, mapel.nama as mapel_nama');
        $this->db->from('mapel_kelas');
        $this->db->join('kelas', 'kelas.id = mapel_kelas.kelas_id');
        $this->db->join('mapel', 'mapel.id = mapel_kelas.mapel_id');
        $this->db->where('mapel_kelas.mapel_id',$id);
        return $this->db->get();
    }

    public function ujian_hitung($pengajar,$mapel)
    {
        $this->db->select('COUNT(*) as ujian_hitung');
        $this->db->from('ujian');
        $this->db->where('ujian.tipe',1);
        $this->db->where('ujian.pengajar_id',$pengajar);
        $this->db->where('ujian.mapel_kelas_id',$mapel);
        return $this->db->get();
    }

    public function ujian_kuis_hitung($pengajar,$mapel)
    {
        $this->db->select('COUNT(*) as kuis_hitung');
        $this->db->from('ujian');
        $this->db->where('ujian.tipe',1);
        $this->db->where('ujian.pengajar_id',$pengajar);
        $this->db->where('ujian.mapel_kelas_id',$mapel);
        return $this->db->get();
    }

    public function ujian($pengajar,$mapel)
    {
        $this->db->select('*');
        $this->db->from('ujian');
        $this->db->where('ujian.tipe',1);
        $this->db->where('ujian.pengajar_id',$pengajar);
        $this->db->where('ujian.mapel_kelas_id',$mapel);
        return $this->db->get();
    }

    public function ujian_kuis($pengajar,$mapel)
    {
        $this->db->select('*');
        $this->db->from('ujian');
        $this->db->where('ujian.tipe',2);
        $this->db->where('ujian.pengajar_id',$pengajar);
        $this->db->where('ujian.mapel_kelas_id',$mapel);
        return $this->db->get();
    }

    public function cek_ujian($id)
    {
        return $this->db->get_where('ujian',['id' => $id]);
    }

    public function tambah_ujian($data)
    {
        return $this->db->insert('ujian',$data);
    }

    public function tambah_kuis($data)
    {
        return $this->db->insert('ujian',$data);
    }

    public function hapus_ujian($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('ujian');
    }

    public function update_ujian($id,$data)
    {
        $this->db->where('id', $id);
        $this->db->update('ujian', $data);
    }

    public function update_kuis($id,$data)
    {
        $this->db->where('id', $id);
        $this->db->update('ujian', $data);
    }
}