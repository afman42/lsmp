<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengajar extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('Ujian_model');
		$this->load->model('Kelas_model');
	}

    public function index()
	{
		$this->load->view('welcome_message');
	}

	public function kuis()
	{
		$this->load->view('welcome_message');
	}

	//Ujian
	public function ujian()
	{
		$data['header'] = 'E-elearning - Ujian';
		$data['kelas'] = $this->Ujian_model->kelas($_SESSION['mapel_id'])->result();
		$this->load->view('template/header',$data);
		$this->load->view('pengajar/kelas',$data);
		$this->load->view('template/footer');
	}

	public function ujian_kelas($id)
	{
		$data['header'] = 'E-elearning - Ujian / Kelas';
		$data['kelas'] = $this->Ujian_model->kelas($id)->row(1);
		$data['ujian'] = $this->Ujian_model->ujian($_SESSION['id_pengajar'], $_SESSION['mapel_id'])->result();
		$this->load->view('template/header',$data);
		$this->load->view('pengajar/kelas_siswa',$data);
		$this->load->view('template/footer');
	}

	public function tambah_ujian_kelas($id)
	{
		$data['header'] = 'E-elearning - Ujian / Kelas';
		$data['kelas'] = $this->Ujian_model->kelas($id)->row(1);
		$this->load->view('template/header',$data);
		$this->load->view('pengajar/tambah_ujian_kelas',$data);
		$this->load->view('template/footer');
	}

	public function insert_ujian_siswa($id)
	{
		$post = $this->input->post();
		$data = [
			'nama_ujian' => $post['nama_ujian'],
			'jsoal' => $post['jsoal'],
			'jam_mulai' => ubah_date_time($post['jam_mulai']),
			'jam_selesai' => ubah_date_time($post['jam_selesai']),
			'mapel_kelas_id' => $id,
			'pengajar_id' => $_SESSION['id_pengajar'],
			'tgl_expired' => ubah_date_time($post['tgl_expired']),
			'tgl_dibuat' => date('Y-m-d')
		];
		// var_dump($data);
		$save = $this->Ujian_model->tambah_ujian($data);
		if ($save) {
			$this->session->set_flashdata('success','Berhasil Tambah Ujian Siswa');
			redirect(site_url('pengajar/ujian_kelas/'.$id));
		} else {
			$this->session->set_flashdata('success','Gagal Tambah Ujian Siswa');
			redirect(site_url('pengajar/ujian_kelas/'.$id));
		}
	}

	public function edit_ujian_kelas($id)
	{
		$data['header'] = 'E-elearning - Ujian / Kelas';
		$data['ujian'] = $this->Ujian_model->cek_ujian($id)->row(1);
		$data['kelas'] = $this->Ujian_model->kelas($data['ujian']->mapel_kelas_id)->row(1);
		$this->load->view('template/header',$data);
		$this->load->view('pengajar/edit_ujian_kelas',$data);
		$this->load->view('template/footer');
	}

	public function update_ujian_siswa($id)
	{
		$post = $this->input->post();
		$data = [
			'nama_ujian' => $post['nama_ujian'],
			'jsoal' => $post['jsoal'],
			'jam_mulai' => ubah_date_time($post['jam_mulai']),
			'jam_selesai' => ubah_date_time($post['jam_selesai']),
			'tgl_expired' => ubah_date_time($post['tgl_expired'])
		];
		// var_dump($data);
		$this->Ujian_model->update_ujian($id,$data);
		$kelas = $this->Ujian_model->kelas($id)->row(1);		
		$this->session->set_flashdata('success','Berhasil Update Ujian Siswa');
		redirect(site_url('pengajar/ujian_kelas/'.$kelas->id));
	}

	public function hapus_ujian_kelas($id)
	{
		$model = $this->Ujian_model->cek_ujian($id)->row();
		$kelas = $this->Ujian_model->kelas($model->mapel_kelas_id)->row(1);
		if ($model != null) {
			$this->Ujian_model->hapus_ujian($model->id);
			$this->session->set_flashdata('success','Berhasil Hapus Ujian Siswa');
			redirect(site_url('pengajar/ujian_kelas/'.$kelas->id));
		}else{
			$this->session->set_flashdata('success','Gagal Hapus Ujian Siswa');
			redirect(site_url('pengajar/ujian_kelas/'.$kelas->id));
		}
	}

	//Soal
	public function soal($id)
	{
		
	}
}