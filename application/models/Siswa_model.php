<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa_model extends CI_Model {

	public function __construct()
    {
        parent::__construct();
    }

	public function jadwal_siswa($id_siswa)
	{
		$this->db->select('*, mapel.nama as mapel_nama');
        $this->db->from('kelas_siswa');
        $this->db->join('mapel_kelas', 'mapel_kelas.kelas_id = kelas_siswa.kelas_id');
        $this->db->join('mapel', 'mapel.id = mapel_kelas.mapel_id');
        $this->db->where('kelas_siswa.siswa_id',$id_siswa);
        return $this->db->get();
	}
}
