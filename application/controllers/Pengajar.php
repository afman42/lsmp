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
		$data['header'] = 'E-elearning - Pengajar';
		// $data['ujian'] = $this->Ujian_model->ujian_hitung($_SESSION['id_pengajar'],$_SESSION['mapel_id'])->result();
		// $data['kuis'] = $this->Ujian_model->ujian_kuis_hitung($_SESSION['id_pengajar'],$_SESSION['mapel_id'])->result();
		$data['pengajar'] = $this->db->get_where('pengajar',['id' => $_SESSION['id_pengajar']])->row();
		$this->load->view('template/header',$data);
		$this->load->view('pengajar/index',$data);
		$this->load->view('template/footer');
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

	//Tugas
	public function tugas()
	{
		$data['header'] = 'E-elearning - Tugas';
		$data['kelas'] = $this->Ujian_model->kelas($_SESSION['id_pengajar'])->result();
		$this->load->view('template/header',$data);
		$this->load->view('pengajar/kelas',$data);
		$this->load->view('template/footer');
	}

	public function tugas_kelas($id)
	{
		$data['header'] = 'E-elearning - Tugas / Kelas';
		$data['kelas'] = $this->Ujian_model->kelas($_SESSION['id_pengajar'])->row(1);
		$data['ujian'] = $this->Ujian_model->ujian($_SESSION['id_pengajar'])->result();
		$this->load->view('template/header',$data);
		$this->load->view('pengajar/kelas_siswa',$data);
		$this->load->view('template/footer');
	}

	public function tambah_tugas_kelas($id)
	{
		$data['header'] = 'E-elearning - Tugas / Kelas';
		$data['kelas'] = $this->Ujian_model->kelas($_SESSION['id_pengajar'])->row(1);
		$this->load->view('template/header',$data);
		$this->load->view('pengajar/tambah_ujian_kelas',$data);
		$this->load->view('template/footer');
	}

	public function insert_tugas_siswa($id)
	{
		$post = $this->input->post();
		$data = [
			'judul' => $post['judul'],
			'waktu_pengerjaan' => $post['waktu_pengerjaan'],
			'mapel_kelas_id' => $id,
			'pengajar_id' => $_SESSION['id_pengajar'],
			'tgl_dibuat' => date('Y-m-d'),
			'terbit' => $post['terbit'],
		];
		$save = $this->Ujian_model->tambah_tugas($data);
		if ($save) {
			$this->session->set_flashdata('success','Berhasil Tambah Tugas Siswa');
			redirect(site_url('pengajar/tugas_kelas/'.$id));
		} else {
			$this->session->set_flashdata('success','Gagal Tambah Tugas Siswa');
			redirect(site_url('pengajar/tugas_kelas/'.$id));
		}
	}

	public function edit_tugas_kelas($id)
	{
		$data['header'] = 'E-elearning - Tugas / Kelas';
		$data['ujian'] = $this->Ujian_model->cek_tugas($id)->row(1);
		$data['kelas'] = $this->Ujian_model->kelas($_SESSION['id_pengajar'])->row(1);
		$this->load->view('template/header',$data);
		$this->load->view('pengajar/edit_ujian_kelas',$data);
		$this->load->view('template/footer');
	}

	public function update_tugas_siswa($id)
	{
		$post = $this->input->post();
		$data = [
			'judul' => $post['judul'],
			'waktu_pengerjaan' => $post['waktu_pengerjaan'],
			'pengajar_id' => $_SESSION['id_pengajar'],
			'tgl_dibuat' => date('Y-m-d'),
			'terbit' => $post['terbit'],
		];
		// var_dump($data);
		$this->Ujian_model->update_tugas($id,$data);
		$ujian = $this->Ujian_model->cek_tugas($id)->row(1);
		// var_dump($ujian);		
		$this->session->set_flashdata('success','Berhasil Update Tugas Siswa');
		redirect(site_url('pengajar/tugas_kelas/'.$ujian->mapel_kelas_id));
	}

	public function hapus_tugas_kelas($id)
	{
		$model = $this->Ujian_model->cek_tugas($id)->row();
		$kelas = $this->Ujian_model->kelas($model->pengajar_id)->row(1);
		if ($model != null) {
			$this->Ujian_model->hapus_tugas($model->id);
			$this->session->set_flashdata('success','Berhasil Hapus Tugas Siswa');
			redirect(site_url('pengajar/tugas_kelas/'.$kelas->id));
		}else{
			$this->session->set_flashdata('success','Gagal Hapus Tugas Siswa');
			redirect(site_url('pengajar/tugas_kelas/'.$kelas->id));
		}
	}

	//Soal Pilganda
	public function soal_pilganda($id)
	{
		$data['header'] = 'E-elearning - Soal Pilganda / Kelas';
		$data['ujian'] = $this->Ujian_model->cek_tugas($id)->row(1);
		$data['kelas'] = $this->Ujian_model->kelas($data['ujian']->pengajar_id)->row(1);
		$data['soal'] = $this->Soal_model->soal($id)->result();
		$this->load->view('template/header',$data);
		$this->load->view('pengajar/soal_pilganda',$data);
		$this->load->view('template/footer');
	}

	public function tambah_soal_pilganda($id)
	{
		$data['header'] = 'E-elearning - Soal Pilganda / Siswa';
		$data['ujian'] = $this->Ujian_model->cek_tugas($id)->row(1);
		$data['kelas'] = $this->Ujian_model->kelas($data['ujian']->pengajar_id)->row(1);
		$this->load->view('template/header',$data);
		$this->load->view('pengajar/tambah_soal_pilganda',$data);
		$this->load->view('template/footer');
	}

	public function insert_soal_pilganda($id)
	{
		$post = $this->input->post();
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'jpg|png|jpeg';
		$config['max_size'] = 1024;
		
		$this->upload->initialize($config);
			if ($this->upload->do_upload('gambar')){
				$upload_data = $this->upload->data();
				$featured_image = $upload_data['file_name'];

				$data = [
					'pertanyaan' => $post['pertanyaan'],
					'pil_a' => $post['pil_a'],
					'pil_b' => $post['pil_b'],
					'pil_c' => $post['pil_c'],
					'pil_d' => $post['pil_d'],
					'kunci' => $post['kunci'],
					'topik_tugas_id' => $id,
					'gambar' => 'uploads/'.$featured_image,
				];
			$save = $this->Soal_model->tambah_soal_pilganda($data);
			if ($save) {
				$this->session->set_flashdata('success','Berhasil Tambah Soal Pilganda Siswa');
				redirect(site_url('pengajar/soal_pilganda/'.$id));
			} else {
				$this->session->set_flashdata('success','Gagal Tambah Soal Pilganda Siswa');
				redirect(site_url('pengajar/soal_pilganda/'.$id));
			}
		}elseif (!$this->upload->do_upload('foto')) {
			$data = [
				'pertanyaan' => $post['pertanyaan'],
				'pil_a' => $post['pil_a'],
				'pil_b' => $post['pil_b'],
				'pil_c' => $post['pil_c'],
				'pil_d' => $post['pil_d'],
				'kunci' => $post['kunci'],
				'topik_tugas_id' => $id,
			];
			
			$save = $this->Soal_model->tambah_soal_pilganda($data);
			if ($save) {
				$this->session->set_flashdata('success','Berhasil Tambah Soal Pilganda Siswa');
				redirect(site_url('pengajar/soal_pilganda/'.$id));
			} else {
				$this->session->set_flashdata('success','Gagal Tambah Soal Pilganda Siswa');
				redirect(site_url('pengajar/soal_pilganda/'.$id));
			}
		}else{
			$data['header'] = 'E-elearning - Tambah Soal Pilganda';
			$data['error'] = $this->upload->display_errors();
			$data['ujian'] = $this->Ujian_model->cek_tugas($id)->row(1);
			$data['kelas'] = $this->Ujian_model->kelas($data['ujian']->pengajar_id)->row(1);
			$this->load->view('template/header',$data);
			$this->load->view('pengajar/tambah_soal_pilganda',$data);
			$this->load->view('template/footer');
		}
	}

	public function edit_soal_pilganda($id)
	{
		$data['header'] = 'E-elearning - Tugas / Soal';
		$data['soal'] = $this->Soal_model->cek_soal_pilganda($id)->row(1);
		$data['ujian'] = $this->Ujian_model->cek_tugas($data['soal']->topik_tugas_id)->row(1);
		$data['kelas'] = $this->Ujian_model->kelas($data['ujian']->pengajar_id)->row(1);
		$this->load->view('template/header',$data);
		$this->load->view('pengajar/edit_soal_pilganda',$data);
		$this->load->view('template/footer');
	}

	public function update_soal_pilganda($id)
	{
		$post = $this->input->post();
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'jpg|png|jpeg';
		$config['max_size'] = 1024;
		
		$this->upload->initialize($config);
			if ($this->upload->do_upload('gambar')){
				$upload_data = $this->upload->data();
				$featured_image = $upload_data['file_name'];

				$data = [
					'pertanyaan' => $post['pertanyaan'],
					'pil_a' => $post['pil_a'],
					'pil_b' => $post['pil_b'],
					'pil_c' => $post['pil_c'],
					'pil_d' => $post['pil_d'],
					'kunci' => $post['kunci'],
					'gambar' => 'uploads/'.$featured_image,
				];
			$this->Soal_model->update_soal_pilganda($id,$data);
			$soal = $this->Soal_model->cek_soal_pilganda($id)->row(1);		
			$this->session->set_flashdata('success','Berhasil Update Soal Pilganda Siswa');
			redirect(site_url('pengajar/soal_pilganda/'.$soal->topik_tugas_id));
		}elseif (!$this->upload->do_upload('gambar')) {
			$data = [
				'pertanyaan' => $post['pertanyaan'],
				'pil_a' => $post['pil_a'],
				'pil_b' => $post['pil_b'],
				'pil_c' => $post['pil_c'],
				'pil_d' => $post['pil_d'],
				'kunci' => $post['kunci'],
			];
			
			$this->Soal_model->update_soal_pilganda($id,$data);
			$soal = $this->Soal_model->cek_soal_pilganda($id)->row(1);		
			$this->session->set_flashdata('success','Berhasil Update Soal Pilganda Siswa');
			redirect(site_url('pengajar/soal_pilganda/'.$soal->topik_tugas_id));
		}else{
			$data['header'] = 'E-elearning - Edit Soal Pilganda';
			$data['error'] = $this->upload->display_errors();
			$data['ujian'] = $this->Ujian_model->cek_tugas($id)->row(1);
			$data['kelas'] = $this->Ujian_model->kelas($data['ujian']->pengajar_id)->row(1);
			$this->load->view('template/header',$data);
			$this->load->view('pengajar/edit_soal_pilganda',$data);
			$this->load->view('template/footer');
		}
	}

	public function hapus_soal_pilganda($id)
	{
		$model = $this->Soal_model->cek_soal_pilganda($id)->row(1);
		$ujian = $this->Ujian_model->cek_tugas($model->topik_tugas_id)->row(1);
		if ($model != null) {
			$this->Soal_model->hapus_soal_pilganda($model->id);
			$this->session->set_flashdata('success','Berhasil Hapus Soal Pilganda Siswa');
			redirect(site_url('pengajar/soal_pilganda/'.$ujian->id));
		}else{
			$this->session->set_flashdata('success','Gagal Hapus Soal PilgandaSiswa');
			redirect(site_url('pengajar/soal_pilganda/'.$ujian->id));
		}
	}

	//soal essay
	public function soal_essay($id)
	{
		$data['header'] = 'E-elearning - Soal Essay / Kelas';
		$data['ujian'] = $this->Ujian_model->cek_tugas($id)->row(1);
		$data['kelas'] = $this->Ujian_model->kelas($data['ujian']->pengajar_id)->row(1);
		$data['soal'] = $this->Soal_model->soal_essay($id)->result();
		$this->load->view('template/header',$data);
		$this->load->view('pengajar/soal_essay',$data);
		$this->load->view('template/footer');
	}

	public function tambah_soal_essay($id)
	{
		$data['header'] = 'E-elearning - Soal Essay / Siswa';
		$data['ujian'] = $this->Ujian_model->cek_tugas($id)->row(1);
		$data['kelas'] = $this->Ujian_model->kelas($data['ujian']->pengajar_id)->row(1);
		$this->load->view('template/header',$data);
		$this->load->view('pengajar/tambah_soal_essay',$data);
		$this->load->view('template/footer');
	}

	public function insert_soal_essay($id)
	{
		$post = $this->input->post();
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'jpg|png|jpeg';
		$config['max_size'] = 1024;
		
		$this->upload->initialize($config);
			if ($this->upload->do_upload('gambar')){
				$upload_data = $this->upload->data();
				$featured_image = $upload_data['file_name'];

				$data = [
					'pertanyaan' => $post['pertanyaan'],
					'tgl_dibuat' => date('Y-m-d'),
					'topik_tugas_id' => $id,
					'gambar' => 'uploads/'.$featured_image,
				];
			$save = $this->Soal_model->tambah_soal_essay($data);
			if ($save) {
				$this->session->set_flashdata('success','Berhasil Tambah Soal Essay Siswa');
				redirect(site_url('pengajar/soal_essay/'.$id));
			} else {
				$this->session->set_flashdata('success','Gagal Tambah Soal Essay Siswa');
				redirect(site_url('pengajar/soal_essay/'.$id));
			}
		}elseif (!$this->upload->do_upload('foto')) {
			$data = [
				'pertanyaan' => $post['pertanyaan'],
				'tgl_dibuat' => date('Y-m-d'),
				'topik_tugas_id' => $id,
			];
			
			$save = $this->Soal_model->tambah_soal_essay($data);
			if ($save) {
				$this->session->set_flashdata('success','Berhasil Tambah Soal Essay Siswa');
				redirect(site_url('pengajar/soal_essay/'.$id));
			} else {
				$this->session->set_flashdata('success','Gagal Tambah Soal Essay Siswa');
				redirect(site_url('pengajar/soal_essay/'.$id));
			}
		}else{
			$data['header'] = 'E-elearning - Tambah Soal Pilganda';
			$data['error'] = $this->upload->display_errors();
			$data['ujian'] = $this->Ujian_model->cek_tugas($id)->row(1);
			$data['kelas'] = $this->Ujian_model->kelas($data['ujian']->pengajar_id)->row(1);
			$this->load->view('template/header',$data);
			$this->load->view('pengajar/tambah_soal_essay',$data);
			$this->load->view('template/footer');
		}
	}

	public function edit_soal_essay($id)
	{
		$data['header'] = 'E-elearning - Tugas / Soal';
		$data['soal'] = $this->Soal_model->cek_soal_essay($id)->row(1);
		$data['ujian'] = $this->Ujian_model->cek_tugas($data['soal']->topik_tugas_id)->row(1);
		$data['kelas'] = $this->Ujian_model->kelas($data['ujian']->pengajar_id)->row(1);
		$this->load->view('template/header',$data);
		$this->load->view('pengajar/edit_soal_essay',$data);
		$this->load->view('template/footer');
	}

	public function update_soal_essay($id)
	{
		$post = $this->input->post();
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'jpg|png|jpeg';
		$config['max_size'] = 1024;
		
		$this->upload->initialize($config);
			if ($this->upload->do_upload('gambar')){
				$upload_data = $this->upload->data();
				$featured_image = $upload_data['file_name'];

				$data = [
					'pertanyaan' => $post['pertanyaan'],
					'gambar' => 'uploads/'.$featured_image,
				];
			$this->Soal_model->update_soal_essay($id,$data);
			$soal = $this->Soal_model->cek_soal_essay($id)->row(1);		
			$this->session->set_flashdata('success','Berhasil Update Soal Essay Siswa');
			redirect(site_url('pengajar/soal_essay/'.$soal->topik_tugas_id));
		}elseif (!$this->upload->do_upload('gambar')) {
			$data = [
				'pertanyaan' => $post['pertanyaan'],
			];
			
			$this->Soal_model->update_soal_essay($id,$data);
			$soal = $this->Soal_model->cek_soal_pilganda($id)->row(1);		
			$this->session->set_flashdata('success','Berhasil Update Soal Essay Siswa');
			redirect(site_url('pengajar/soal_essay/'.$soal->topik_tugas_id));
		}else{
			$data['header'] = 'E-elearning - Edit Soal Essay';
			$data['error'] = $this->upload->display_errors();
			$data['ujian'] = $this->Ujian_model->cek_tugas($id)->row(1);
			$data['kelas'] = $this->Ujian_model->kelas($data['ujian']->pengajar_id)->row(1);
			$this->load->view('template/header',$data);
			$this->load->view('pengajar/edit_soal_essay',$data);
			$this->load->view('template/footer');
		}
	}

	public function hapus_soal_essay($id)
	{
		$model = $this->Soal_model->cek_soal_essay($id)->row(1);
		$ujian = $this->Ujian_model->cek_tugas($model->topik_tugas_id)->row(1);
		if ($model != null) {
			$this->Soal_model->hapus_soal_essay($model->id);
			$this->session->set_flashdata('success','Berhasil Hapus Soal Essay Siswa');
			redirect(site_url('pengajar/soal_essay/'.$ujian->id));
		}else{
			$this->session->set_flashdata('success','Gagal Hapus Soal Essay Siswa');
			redirect(site_url('pengajar/soal_essay/'.$ujian->id));
		}
	}

	//Ubah Profil
	public function ubah_profil()
	{
		$data['header'] = 'E-elearning - Ubah Profil Pengajar';
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