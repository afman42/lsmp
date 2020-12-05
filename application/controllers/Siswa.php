<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa extends CI_Controller {

    public function index()
	{
		$data['header'] = 'E-elearning - Siswa';
		$this->load->view('template/header',$data);
		$this->load->view('siswa/index');
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