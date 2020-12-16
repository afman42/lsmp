<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Siswa_model');
	}

    public function index()
	{
		$data['header'] = 'E-elearning - Siswa';
		$user = $this->db->get_where('user',['level' => $this->session->userdata('level')])->row();
        $data['jadwal'] = $this->Siswa_model->jadwal_siswa($user->is_siswa)->result();
		$this->load->view('template/header',$data);
		$this->load->view('siswa/index',$data);
		$this->load->view('template/footer');
    }
    
    public function ujian()
    {
        $data['header'] = 'E-elearning - Siswa Ujian';
		$this->load->view('template/header',$data);
		$this->load->view('siswa/ujian');
		$this->load->view('template/footer');
    }
}