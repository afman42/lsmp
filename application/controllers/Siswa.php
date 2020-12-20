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
		$user = $this->db->get_where('user',['level' => $this->session->userdata('level')])->row();
        $data['ujian'] = $this->Siswa_model->ujian_siswa($user->is_siswa)->result();
		$this->load->view('template/header',$data);
		$this->load->view('siswa/ujian',$data);
		$this->load->view('template/footer');
    }

    public function kerjakan($id)
    {
    	$data['header'] = 'E-elearning - Kerjakan Ujian';
        $data['kerjakan'] = $this->Siswa_model->kerjakan_ujian($id)->row(1);
		$this->load->view('template/header',$data);
		$this->load->view('siswa/kerjakan',$data);
		$this->load->view('template/footer');
    }

    public function kerjakan_soal()
    {
    	$ujian_id = $_POST['id'];
		$user = $this->db->get_where('user',['level' => $this->session->userdata('level')])->row();
    	$data['soal'] = $this->Siswa_model->kerjakan_soal($ujian_id,$user->is_siswa)->result();
		$this->load->view('siswa/soal',$data);
    }

    public function nilai()
    {
	  if (empty($_SESSION['username']) AND empty($_SESSION['passuser']) AND $_SESSION['login']==0){
	  echo "
	 <center><br><br><br><br><br><br>Maaf, untuk masuk <b>Halaman</b><br>
	  <center>anda harus <b>Login</b> dahulu!<br><br>";
	 echo "<div> <a href='index.php'><img src='images/kunci.png'  height=176 width=143></a>
	             </div>";
	  echo "<input type=button class='btn btn-primary' value='LOGIN DI SINI' onclick=location.href='index.php'></a></center>";
	}else{
	
	$soal = $this->db->query("SELECT * FROM ujian where ujian.id='$_POST[id_topik]'");
	$pilganda = $soal->num_rows();
	$user_id = $this->db->get_where('user',['level' => $_SESSION['level']])->row();
	
	//jika ada pilihan ganda dan ada esay
		if (!empty($pilganda)){

		//jika ada inputan soal pilganda
			if(!empty($_POST['soal_pilganda'])){
			    $benar = 0;
			    $salah = 0;
				foreach($_POST['soal_pilganda'] as $key => $value){
				    $cek = $this->db->query("SELECT * FROM soal WHERE id=$key");
				    // while($c = mysqli_fetch_array($cek)){
				    foreach ($cek->result_array() as $k) {
				        $jawaban = $k['jwb_pg'];
				    }
				    // }
				    if($value==$jawaban){
				        $benar++;
				    }else{
				        $salah++;
				    }
				}

			$jumlah = $_POST['jumlahsoalpilganda'];
			$tidakjawab = $jumlah - $benar - $salah;
			$persen = $benar / $jumlah;
			$hasil = $persen * 100;

		$this->db->query("INSERT INTO nilai (ujian_id, id_siswa, benar, salah, tidak_dikerjakan,persentase)
		                           VALUES ('$_POST[id_topik]','$user_id->is_siswa','$benar','$salah','$tidakjawab','$hasil')");

		}elseif (empty($_POST['soal_pilganda'])){
		    $jumlah = $_POST['jumlahsoalpilganda'];
		    $this->db->query("INSERT INTO nilai (ujian_id, id_siswa, benar, salah, tidak_dikerjakan,persentase)
		                           VALUES ('$_POST[id_topik]','$user_id->is_siswa','0','0','$jumlah','0')");
		}


			redirect(site_url('siswa/ujian'));
		}
    }
}