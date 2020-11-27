<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengajar extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('Ujian_model');
		$this->load->model('Kelas_model');
		$this->load->model('Soal_model');
		$this->load->model('Admin_model');
		$this->load->model('Mapel_model');
	}

    public function index()
	{
		$this->load->view('welcome_message');
	}

	//Kuis
	public function kuis()
	{
		$data['header'] = 'E-elearning - Kuis';
		$data['kelas'] = $this->Ujian_model->kelas($_SESSION['mapel_id'])->result();
		$this->load->view('template/header',$data);
		$this->load->view('pengajar/kelas',$data);
		$this->load->view('template/footer');
	}

	public function kuis_kelas($id)
	{
		$data['header'] = 'E-elearning - Kuis / Kelas';
		$data['kelas'] = $this->Ujian_model->kelas($id)->row(1);
		$data['ujian'] = $this->Ujian_model->ujian_kuis($_SESSION['id_pengajar'], $_SESSION['mapel_id'])->result();
		$this->load->view('template/header',$data);
		$this->load->view('pengajar/kelas_siswa',$data);
		$this->load->view('template/footer');
	}

	public function tambah_kuis_kelas($id)
	{
		$data['header'] = 'E-elearning - Ujian / Kelas';
		$data['kelas'] = $this->Ujian_model->kelas($id)->row(1);
		$this->load->view('template/header',$data);
		$this->load->view('pengajar/tambah_kuis_kelas',$data);
		$this->load->view('template/footer');
	}

	public function insert_kuis_siswa($id)
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
			'tgl_dibuat' => date('Y-m-d'),
			'tipe' => 2
		];
		// var_dump($data);
		$save = $this->Ujian_model->tambah_kuis($data);
		if ($save) {
			$this->session->set_flashdata('success','Berhasil Tambah Kuis Siswa');
			redirect(site_url('pengajar/kuis_kelas/'.$id));
		} else {
			$this->session->set_flashdata('success','Gagal Tambah Kuis Siswa');
			redirect(site_url('pengajar/kuis_kelas/'.$id));
		}
	}

	public function edit_kuis_kelas($id)
	{
		$data['header'] = 'E-elearning - Kuis / Kelas';
		$data['ujian'] = $this->Ujian_model->cek_ujian($id)->row(1);
		$data['kelas'] = $this->Ujian_model->kelas($data['ujian']->mapel_kelas_id)->row(1);
		$this->load->view('template/header',$data);
		$this->load->view('pengajar/edit_kuis_kelas',$data);
		$this->load->view('template/footer');
	}

	public function update_kuis_siswa($id)
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
		$this->Ujian_model->update_kuis($id,$data);
		$kelas = $this->Ujian_model->kelas($id)->row(1);		
		$this->session->set_flashdata('success','Berhasil Update Kuis Siswa');
		redirect(site_url('pengajar/kuis_kelas/'.$kelas->id));
	}

	public function hapus_kuis_kelas($id)
	{
		$model = $this->Ujian_model->cek_ujian($id)->row();
		$kelas = $this->Ujian_model->kelas($model->mapel_kelas_id)->row(1);
		if ($model != null) {
			$this->Ujian_model->hapus_ujian($model->id);
			$this->session->set_flashdata('success','Berhasil Hapus Kuis Siswa');
			redirect(site_url('pengajar/kuis_kelas/'.$kelas->id));
		}else{
			$this->session->set_flashdata('success','Gagal Hapus Kuis Siswa');
			redirect(site_url('pengajar/kuis_kelas/'.$kelas->id));
		}
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
			'tgl_dibuat' => date('Y-m-d'),
			'tipe' => 1
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
		$data['header'] = 'E-elearning - Ujian / Kelas';
		$data['ujian'] = $this->Ujian_model->cek_ujian($id)->row(1);
		$data['kelas'] = $this->Ujian_model->kelas($data['ujian']->mapel_kelas_id)->row(1);
		if ($data['ujian']->tipe == 1) {
			$data['soal'] = $this->Soal_model->soal($id,$_SESSION['id_pengajar'])->result();
		}else{
			$data['soal'] = $this->Soal_model->soal_kuis($id,$_SESSION['id_pengajar'])->result();
		}
		$data['hitung'] = $this->Soal_model->hitung_soal($id,$_SESSION['id_pengajar'])->result();
		$this->load->view('template/header',$data);
		$this->load->view('pengajar/soal',$data);
		$this->load->view('template/footer');
	}

	public function tambah_soal_siswa($id)
	{
		$data['header'] = 'E-elearning - Soal / Siswa';
		$data['ujian'] = $this->Ujian_model->cek_ujian($id)->row(1);
		$data['kelas'] = $this->Ujian_model->kelas($data['ujian']->mapel_kelas_id)->row(1);
		$this->load->view('template/header',$data);
		$this->load->view('pengajar/tambah_soal_siswa',$data);
		$this->load->view('template/footer');
	}

	public function insert_soal_siswa($id)
	{
		$post = $this->input->post();
		$data = [
			'pertanyaan' => $post['pertanyaan'],
			'pg_a' => 'a.'.$post['pg_a'],
			'pg_b' => 'b.'.$post['pg_b'],
			'pg_c' => 'c.'.$post['pg_c'],
			'pg_d' => 'd.'.$post['pg_d'],
			'pengajar_id' => $_SESSION['id_pengajar'],
			'jwb_pg' => $post['jwb_pg'],
			'ujian_id' => $id
		];
		// var_dump($data);
		$save = $this->Soal_model->tambah_soal($data);
		if ($save) {
			$this->session->set_flashdata('success','Berhasil Tambah Ujian Siswa');
			redirect(site_url('pengajar/soal/'.$id));
		} else {
			$this->session->set_flashdata('success','Gagal Tambah Ujian Siswa');
			redirect(site_url('pengajar/soal/'.$id));
		}
	}

	public function edit_soal_siswa($id)
	{
		$data['header'] = 'E-elearning - Ujian / Soal';
		$data['soal'] = $this->Soal_model->cek_soal($id)->row(1);
		$data['ujian'] = $this->Ujian_model->cek_ujian($data['soal']->ujian_id)->row(1);
		$data['kelas'] = $this->Ujian_model->kelas($data['ujian']->mapel_kelas_id)->row(1);
		$this->load->view('template/header',$data);
		$this->load->view('pengajar/edit_soal_siswa',$data);
		$this->load->view('template/footer');
	}

	public function update_soal_siswa($id)
	{
		$post = $this->input->post();
		$data = [
			'pertanyaan' => $post['pertanyaan'],
			'pg_a' => 'a.'.$post['pg_a'],
			'pg_b' => 'b.'.$post['pg_b'],
			'pg_c' => 'c.'.$post['pg_c'],
			'pg_d' => 'd.'.$post['pg_d'],
			'jwb_pg' => $post['jwb_pg'],
		];
		// var_dump($data);
		$this->Soal_model->update_soal($id,$data);
		$soal = $this->Soal_model->cek_soal($id)->row(1);		
		$this->session->set_flashdata('success','Berhasil Update Soal Siswa');
		redirect(site_url('pengajar/soal/'.$soal->ujian_id));
	}

	public function hapus_soal_siswa($id)
	{
		$model = $this->Soal_model->cek_soal($id)->row(1);
		$ujian = $this->Ujian_model->cek_ujian($model->ujian_id)->row(1);
		if ($model != null) {
			$this->Soal_model->hapus_soal($model->id);
			$this->session->set_flashdata('success','Berhasil Hapus Soal Siswa');
			redirect(site_url('pengajar/soal/'.$ujian->id));
		}else{
			$this->session->set_flashdata('success','Gagal Hapus Soal Siswa');
			redirect(site_url('pengajar/soal/'.$ujian->id));
		}
	}

	//Ubah Profil
	public function ubah_profil()
	{
		$data['header'] = 'E-elearning - Ubah Profil Admin';
		$data['admin'] = $this->db->get_where('user',['level' => $this->session->userdata('level')])->row();
		$data['pengajar'] = $this->db->get_where('pengajar',['id' => $data['admin']->is_pengajar ])->row();
		$data['mapel'] = $this->Mapel_model->mapel()->result();
		$this->load->view('template/header',$data);
		$this->load->view('admin/ubah_profil',$data);
		$this->load->view('template/footer');
	}

	public function update_ubah_profil($id)
	{
		$post = $this->input->post();
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'jpg|png|jpeg';
		$config['max_size'] = 1024;
		
		$this->upload->initialize($config);
			if ($this->upload->do_upload('foto')){
				$upload_data = $this->upload->data();
				$featured_image = $upload_data['file_name'];
				$data = [
					'nip' => $post['nip'],
					'nama' => $post['nama'],
					'tempat_lahir' => $post['tempat_lahir'],
					'tgl_lahir' => $post['tgl_lahir'],
					'foto' => 'uploads/'.$featured_image,
					'mapel_id' => $post['mapel_id'],
					'jk' => $post['jk'],
					'alamat' => $post['alamat'],
				];
				$data_user = [
					'email' => $post['email'],
					'password' => md5($post['password']),
				];
			$this->Admin_model->update_pengajar($id,$data,$data_user);
			$this->session->set_flashdata('success','Berhasil Update Ubah Profil');
			redirect(site_url('admin/ubah_profil'));
		}elseif (!$this->upload->do_upload('foto')) {
			$data = [
				'nip' => $post['nip'],
				'nama' => $post['nama'],
				'tempat_lahir' => $post['tempat_lahir'],
				'tgl_lahir' => $post['tgl_lahir'],
				'mapel_id' => $post['mapel_id'],
				'jk' => $post['jk'],
				'alamat' => $post['alamat'],
			];
			$data_user = [
					'email' => $post['email'],
					'password' => md5($post['password']),
				];
			$this->Admin_model->update_pengajar($id,$data,$data_user);
			$this->session->set_flashdata('success','Berhasil Update Ubah Profil');
			redirect(site_url('admin/ubah_profil'));
		}else{
			$data['header'] = 'E-elearning - Edit Ubah Profil';
			$error = array('error' => $this->upload->display_errors());
			$this->load->view('template/header',$data);
			$this->load->view('admin/ubah_profil',$error);
			$this->load->view('template/footer');
		}
	}
}