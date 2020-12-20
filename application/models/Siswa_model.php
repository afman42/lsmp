<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa_model extends CI_Model {

	public function __construct()
    {
        parent::__construct();
    }

	public function jadwal_siswa($id_siswa)
	{
		$this->db->select('*, mapel.nama as mapel_nama, pengajar.nama as nama_pengajar');
        $this->db->from('kelas_siswa');
        $this->db->join('mapel_kelas', 'mapel_kelas.kelas_id = kelas_siswa.kelas_id');
        $this->db->join('mapel', 'mapel.id = mapel_kelas.mapel_id');
        $this->db->join('pengajar', 'pengajar.mapel_id = mapel.id');
        $this->db->where('kelas_siswa.siswa_id',$id_siswa);
        return $this->db->get();
	}

    public function ujian_siswa($id_siswa)
    {
        $this->db->select('*,mapel.nama as mapel_nama, ujian.id as id_ujian');
        $this->db->from('ujian');
        $this->db->join('mapel_kelas', 'mapel_kelas.id = ujian.mapel_kelas_id');
        $this->db->join('mapel', 'mapel.id = mapel_kelas.mapel_id');
        $this->db->join('kelas_siswa','kelas_siswa.kelas_id = mapel_kelas.kelas_id');
        $this->db->where('kelas_siswa.siswa_id',$id_siswa);
        $this->db->where('ujian.tgl_expired >=', date('Y-m-d H:i:s'));
        $this->db->where('ujian.tgl_dibuat <=', date('Y-m-d'));
        return $this->db->get();
    }

    public function kerjakan_ujian($id_ujian)
    {
        $this->db->select('*,mapel.nama as mapel_nama, ujian.id as id_ujian');
        $this->db->from('ujian');
        $this->db->join('mapel_kelas', 'mapel_kelas.id = ujian.mapel_kelas_id');
        $this->db->join('mapel', 'mapel.id = mapel_kelas.mapel_id');
        $this->db->where('ujian.id',$id_ujian);
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