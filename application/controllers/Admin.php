<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('Admin_model');
		$this->load->model('Mapel_model');
	}

    public function index()
	{
		$data['header'] = 'E-elearning - Admin';
		$this->load->view('template/header',$data);
		$this->load->view('admin/beranda');
		$this->load->view('template/footer');
	}

	//Pengajar
	public function pengajar()
	{
		$data['header'] = 'E-elearning - Pengajar';
		$data['pengajar'] = $this->Admin_model->pengajar()->result();
		$this->load->view('template/header',$data);
		$this->load->view('admin/pengajar');
		$this->load->view('template/footer');
	}

	public function tambah_pengajar()
	{
		$data['header'] = 'E-elearning - Tambah Pengajar';
		$data['mapel'] = $this->Mapel_model->mapel()->result();
		$this->load->view('template/header',$data);
		$this->load->view('admin/tambah_pengajar',$data);
		$this->load->view('template/footer');
	}

	public function edit_pengajar($id)
	{
		$data['header'] = 'E-elearning - Edit Pengajar';
		$data['pengajar'] = $this->db->get_where('pengajar',['id' => $id])->row();
		$data['user'] = $this->db->get_where('user',['is_pengajar' => $id])->row();
		$data['mapel'] = $this->Mapel_model->mapel()->result();
		$this->load->view('template/header',$data);
		$this->load->view('admin/edit_pengajar');
		$this->load->view('template/footer');
	}

	public function insert_pengajar()
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
			$this->Admin_model->tambah_pengajar($data);
				$data_user = [
					'email' => $post['email'],
					'password' => md5('pengajar123'),
					'is_pengajar' => $this->db->insert_id(),
					'level' => 2
				];
			$this->Admin_model->tambah_user($data_user);
			$this->session->set_flashdata('success','Berhasil Tambah Akun Pengajar');
			redirect(site_url('admin/pengajar'));
		}else{
			$data['header'] = 'E-elearning - Tambah Pengajar';
			$error = array('error' => $this->upload->display_errors());
			$this->load->view('template/header',$data);
			$this->load->view('admin/tambah_pengajar',$error);
			$this->load->view('template/footer');
		}
	}

	public function update_pengajar($id)
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
				];
			$this->Admin_model->update_pengajar($id,$data,$data_user);
			$this->session->set_flashdata('success','Berhasil Update Akun Pengajar');
			redirect(site_url('admin/pengajar'));
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
				];
			$this->Admin_model->update_pengajar($id,$data,$data_user);
			$this->session->set_flashdata('success','Berhasil Update Akun Pengajar');
			redirect(site_url('admin/pengajar'));
		}else{
			$data['header'] = 'E-elearning - Edit Pengajar';
			$error = array('error' => $this->upload->display_errors());
			$this->load->view('template/header',$data);
			$this->load->view('admin/tambah_pengajar',$error);
			$this->load->view('template/footer');
		}
	}

	public function hapus_pengajar($id)
	{
		$model = $this->db->get_where('pengajar',['id' => $id])->row();
		if ($model != null) {
			unlink($model->foto);
			$this->Admin_model->hapus_pengajar($model->id);
			$this->session->set_flashdata('success','Berhasil Hapus Akun Pengajar');
			redirect(site_url('admin/pengajar'));
		}else{
			$this->session->set_flashdata('success','Gagal Hapus Akun Pengajar');
			redirect(site_url('admin/pengajar'));
		}
	}

	//Siswa
	public function siswa()
	{
		$data['header'] = 'E-elearning - Siswa';
		$data['siswa'] = $this->Admin_model->siswa()->result();
		$this->load->view('template/header',$data);
		$this->load->view('admin/siswa');
		$this->load->view('template/footer');
	}

	public function tambah_siswa()
	{
		$data['header'] = 'E-elearning - Tambah Siswa';
		$this->load->view('template/header',$data);
		$this->load->view('admin/tambah_siswa');
		$this->load->view('template/footer');
	}

	public function edit_siswa($id)
	{
		$data['header'] = 'E-elearning - Edit user';
		$data['siswa'] = $this->db->get_where('siswa',['id' => $id])->row();
		$data['user'] = $this->db->get_where('user',['is_siswa' => $id])->row();
		$this->load->view('template/header',$data);
		$this->load->view('admin/edit_siswa',$data);
		$this->load->view('template/footer');
	}

	public function insert_siswa()
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
					'nis' => $post['nis'],
					'nama' => $post['nama'],
					'tempat_lahir' => $post['tempat_lahir'],
					'tgl_lahir' => $post['tgl_lahir'],
					'foto' => 'uploads/'.$featured_image,
					'agama' => $post['agama'],
					'jk' => $post['jk'],
					'alamat' => $post['alamat'],
					'tahun_masuk' => $post['tahun_masuk'],
				];
			$this->Admin_model->tambah_siswa($data);
				$data_user = [
					'email' => $post['email'],
					'password' => md5('siswa123'),
					'is_siswa' => $this->db->insert_id(),
					'level' => 3
				];
			$this->Admin_model->tambah_user($data_user);
			$this->session->set_flashdata('success','Berhasil Tambah Akun User');
			redirect(site_url('admin/siswa'));
		}else{
			$data['header'] = 'E-elearning - Tambah Siswa';
			$error = array('error' => $this->upload->display_errors());
			$this->load->view('template/header',$data);
			$this->load->view('admin/tambah_siswa',$error);
			$this->load->view('template/footer');
		}
	}

	public function update_siswa($id)
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
					'nis' => $post['nis'],
					'nama' => $post['nama'],
					'tempat_lahir' => $post['tempat_lahir'],
					'tgl_lahir' => $post['tgl_lahir'],
					'foto' => 'uploads/'.$featured_image,
					'agama' => $post['agama'],
					'jk' => $post['jk'],
					'alamat' => $post['alamat'],
					'tahun_masuk' => $post['tahun_masuk'],
				];
				$data_user = [
					'email' => $post['email'],
				];
			$this->Admin_model->update_siswa($id,$data,$data_user);
			$this->session->set_flashdata('success','Berhasil Update Akun User');
			redirect(site_url('admin/siswa'));
		}elseif (!$this->upload->do_upload('foto')) {
			$data = [
				'nis' => $post['nis'],
				'nama' => $post['nama'],
				'tempat_lahir' => $post['tempat_lahir'],
				'tgl_lahir' => $post['tgl_lahir'],
				'agama' => $post['agama'],
				'jk' => $post['jk'],
				'alamat' => $post['alamat'],
				'tahun_masuk' => $post['tahun_masuk'],
			];
			$data_user = [
					'email' => $post['email'],
				];
			$this->Admin_model->update_siswa($id,$data,$data_user);
			$this->session->set_flashdata('success','Berhasil Update Akun User');
			redirect(site_url('admin/siswa'));
		}else{
			$data['header'] = 'E-elearning - Edit User';
			$error = array('error' => $this->upload->display_errors());
			$this->load->view('template/header',$data);
			$this->load->view('admin/edit_siswa',$error);
			$this->load->view('template/footer');
		}
	}

	public function hapus_siswa($id)
	{
		$model = $this->db->get_where('siswa',['id' => $id])->row();
		if ($model != null) {
			unlink($model->foto);
			$this->Admin_model->hapus_siswa($model->id);
			$this->session->set_flashdata('success','Berhasil Hapus Akun Siswa');
			redirect(site_url('admin/siswa'));
		}else{
			$this->session->set_flashdata('success','Gagal Hapus Akun Siswa');
			redirect(site_url('admin/siswa'));
		}
	}

	//Mapel
	public function mapel()
	{
		$data['header'] = 'E-elearning - Siswa';
		$data['mapel'] = $this->Mapel_model->mapel()->result();
		$this->load->view('template/header',$data);
		$this->load->view('admin/mapel',$data);
		$this->load->view('template/footer');
	}

	public function tambah_mapel()
	{
		$data['header'] = 'E-elearning - Tambah Mapel';
		$this->load->view('template/header',$data);
		$this->load->view('admin/tambah_mapel');
		$this->load->view('template/footer');
	}

	public function edit_mapel($id)
	{
		$data['header'] = 'E-elearning - Edit Mapel';
		$data['mapel'] = $this->db->get_where('mapel',['id' => $id])->row();
		$this->load->view('template/header',$data);
		$this->load->view('admin/edit_mapel',$data);
		$this->load->view('template/footer');
	}

	public function insert_mapel()
	{
		$post = $this->input->post();
		
		$data = [
				'nama' => $post['nama'],	
			];
		$this->Mapel_model->tambah_mapel($data);
		
		$this->session->set_flashdata('success','Berhasil Tambah Mapel');
		redirect(site_url('admin/mapel'));
	}

	public function update_mapel($id)
	{
		$post = $this->input->post();
		$data = [
			'nama' => $post['nama'],			
		];
		
		$this->Mapel_model->update_mapel($id,$data);
		
		$this->session->set_flashdata('success','Gagal Update Mapel');
		redirect(site_url('admin/mapel'));
	}

	public function hapus_mapel($id)
	{
		$model = $this->db->get_where('mapel',['id' => $id])->row();
		if ($model != null) {
			$this->Mapel_model->hapus_mapel($model->id);
			$this->session->set_flashdata('success','Berhasil Hapus Mapel');
			redirect(site_url('admin/mapel'));
		}else{
			$this->session->set_flashdata('success','Gagal Hapus Mapel');
			redirect(site_url('admin/mapel'));
		}
	}
}