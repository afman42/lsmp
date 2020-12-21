<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa_model extends CI_Model {

	public function __construct()
    {
        parent::__construct();
    }

    public function hitung_tugas($id_siswa)
    {
        $this->db->select('COUNT(*) as jumlah');
        $this->db->from('topik_tugas');
        $this->db->join('mapel_kelas', 'mapel_kelas.id = topik_tugas.mapel_kelas_id');
        $this->db->join('kelas_siswa', 'kelas_siswa.kelas_id = mapel_kelas.kelas_id'); 
        $this->db->where('kelas_siswa.siswa_id',$id_siswa);
        return $this->db->get();
    }

	public function jadwal_siswa($id_siswa)
	{
		$this->db->select('*, mapel.nama as mapel_nama, pengajar.nama as nama_pengajar');
        $this->db->from('kelas_siswa');
        $this->db->join('mapel_kelas', 'mapel_kelas.kelas_id = kelas_siswa.kelas_id');
        $this->db->join('pengajar', 'pengajar.id = mapel_kelas.pengajar_id');
        $this->db->join('mapel', 'mapel.id = mapel_kelas.mapel_id');
        $this->db->where('kelas_siswa.siswa_id',$id_siswa);
        return $this->db->get();
	}

    public function ujian_siswa($id_siswa)
    {
        $this->db->select('*,mapel.nama as mapel_nama, topik_tugas.id as id_ujian');
        $this->db->from('topik_tugas');
        $this->db->join('mapel_kelas', 'mapel_kelas.id = topik_tugas.mapel_kelas_id');
        $this->db->join('mapel', 'mapel.id = mapel_kelas.mapel_id');
        $this->db->join('kelas_siswa','kelas_siswa.kelas_id = mapel_kelas.kelas_id');
        $this->db->where('kelas_siswa.siswa_id',$id_siswa);
        return $this->db->get();
    }

    public function kerjakan_ujian($id_ujian)
    {
        $this->db->select('*,mapel.nama as mapel_nama, topik_tugas.id as id_ujian');
        $this->db->from('topik_tugas');
        $this->db->join('mapel_kelas', 'mapel_kelas.id = topik_tugas.mapel_kelas_id');
        $this->db->join('mapel', 'mapel.id = mapel_kelas.mapel_id');
        $this->db->where('topik_tugas.id',$id_ujian);
        return $this->db->get();   
    }

    public function kerjakan_soal($id_ujian,$id_siswa)
    {
        $this->db->select('*, soal.id as soal_id');
        $this->db->from('soal');
        $this->db->join('ujian','ujian.id = soal.ujian_id');
        $this->db->join('mapel_kelas', 'mapel_kelas.id = ujian.mapel_kelas_id');
        $this->db->join('mapel', 'mapel.id = mapel_kelas.mapel_id');
        $this->db->join('kelas_siswa','kelas_siswa.kelas_id = mapel_kelas.kelas_id');
        $this->db->where('kelas_siswa.siswa_id',$id_siswa);
        $this->db->where('ujian.id',$id_ujian);
        return $this->db->get();   
    }
}